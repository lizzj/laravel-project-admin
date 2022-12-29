<?php
/**
 * @note: 阿里云短信
 * @author:Je_taime
 * @time: 2022/6/25 17:19
 */

namespace App\Services\Sms;

use App\Repositories\Interfaces\System\Sms\GatewayRepository;
use App\Repositories\Interfaces\System\Sms\TemplateRepository;
use Illuminate\Support\Facades\Http;

class Aliyun
{
    public const ENDPOINT_URL = 'http://dysmsapi.aliyuncs.com';
    public const ENDPOINT_METHOD = 'SendSms';
    public const ENDPOINT_VERSION = '2017-05-25';
    public const ENDPOINT_FORMAT = 'JSON';
    public const ENDPOINT_REGION_ID = 'cn-hangzhou';
    public const ENDPOINT_SIGNATURE_METHOD = 'HMAC-SHA1';
    public const ENDPOINT_SIGNATURE_VERSION = '1.0';
    public const ENDPOINT_TIMEOUT = 10;

    public function getGateway()
    {
        return app(GatewayRepository::class)->find('aliyun')['data'];
    }

    public function getTemplate($id)
    {
        return app(TemplateRepository::class)->find($id)['data'];
    }

    public function send($phone, $template_id, $data = [])
    {
        $params = [
            'RegionId' => self::ENDPOINT_REGION_ID,
            'AccessKeyId' => $this->getGateway()['key'],
            'Format' => self::ENDPOINT_FORMAT,
            'SignatureMethod' => self::ENDPOINT_SIGNATURE_METHOD,
            'SignatureVersion' => self::ENDPOINT_SIGNATURE_VERSION,
            'SignatureNonce' => uniqid('', true),
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'Action' => self::ENDPOINT_METHOD,
            'Version' => self::ENDPOINT_VERSION,
            'PhoneNumbers' => $phone,
            'SignName' => $this->getTemplate($template_id)['template_sign'],
            'TemplateCode' => $this->getTemplate($template_id)['template_no'],
            'TemplateParam' => json_encode($data, JSON_FORCE_OBJECT),
        ];
        $params['Signature'] = $this->generateSign($params);
        return $this->get(self::ENDPOINT_URL, $params);
    }

    public function get($baseUrl, $query = [])
    {

        return Http::timeout(self::ENDPOINT_TIMEOUT)->get($baseUrl, $query)->json();
    }

    protected function generateSign($params)
    {
        ksort($params);
        $accessKeySecret = $this->getGateway()['secret'];
        $stringToSign = 'GET&%2F&' . urlencode(http_build_query($params, null, '&', PHP_QUERY_RFC3986));
        return base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
    }

}
