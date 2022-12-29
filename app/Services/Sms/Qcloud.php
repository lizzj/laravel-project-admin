<?php
/**
 * @note: 腾讯云短信
 * @author:Je_taime
 * @time: 2022/6/25 17:19
 */

namespace App\Services\Sms;

use App\Repositories\Interfaces\System\Sms\GatewayRepository;
use App\Repositories\Interfaces\System\Sms\TemplateRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Qcloud
{
    public const ENDPOINT_URL = 'https://sms.tencentcloudapi.com';
    public const ENDPOINT_HOST = 'sms.tencentcloudapi.com';
    public const ENDPOINT_SERVICE = 'sms';
    public const ENDPOINT_METHOD = 'SendSms';
    public const ENDPOINT_VERSION = '2021-01-11';
    public const ENDPOINT_REGION = 'ap-guangzhou';
    public const ENDPOINT_TIMEOUT = 10;

    public function getGateway()
    {
        return app(GatewayRepository::class)->find('qcloud')['data'];
    }

    public function getTemplate($id)
    {
        return app(TemplateRepository::class)->find($id)['data'];
    }

    public function send($phone, $template, $data = [])
    {

        $params = [
            'PhoneNumberSet' => [
                (string)$phone
            ],
            'SmsSdkAppId' => $this->getGateway()['sdk_id'],
            'SignName' => $this->getTemplate($template)['template_sign'],
            'TemplateId' => $this->getTemplate($template)['template_no'],
            'TemplateParamSet' => array_map('strval', array_values($data)),
        ];
        $result = $this->sendPost($params);
        if (Arr::get($result, 'Response.SendStatusSet.0.Code', 'Fail') === 'Ok') {
            return [
                'Code' => 'OK',
                'Data' => $result
            ];
        }
        return [
            'Code' => 'Fail',
            'Data' => $result
        ];
    }

    public function sendPost($params)
    {
        $time = time();
        return Http::timeout(self::ENDPOINT_TIMEOUT)->withHeaders([
            'Authorization' => $this->generateSign($params, $time),
            'Host' => self::ENDPOINT_HOST,
            'Content-Type' => 'application/json; charset=utf-8',
            'X-TC-Action' => self::ENDPOINT_METHOD,
            'X-TC-Region' => self::ENDPOINT_REGION,
            'X-TC-Timestamp' => $time,
            'X-TC-Version' => self::ENDPOINT_VERSION,
        ])->post(self::ENDPOINT_URL, $params)->json();
    }

    protected function generateSign($params, $timestamp)
    {

        $date = gmdate("Y-m-d", $timestamp);
        $secretKey = $this->getGateway()['key'];
        $secretId = $this->getGateway()['secret'];
        $canonicalRequest = 'POST' . "\n" .
            '/' . "\n" .
            '' . "\n" .
            'content-type:application/json; charset=utf-8' . "\n" .
            'host:' . self::ENDPOINT_HOST . "\n" . "\n" .
            'content-type;host' . "\n" .
            hash("SHA256", json_encode($params));
        $stringToSign =
            'TC3-HMAC-SHA256' . "\n" .
            $timestamp . "\n" .
            $date . '/' . self::ENDPOINT_SERVICE . '/tc3_request' . "\n" .
            hash("SHA256", $canonicalRequest);

        $secretDate = hash_hmac("SHA256", $date, "TC3" . $secretKey, true);
        $secretService = hash_hmac("SHA256", self::ENDPOINT_SERVICE, $secretDate, true);
        $secretSigning = hash_hmac("SHA256", "tc3_request", $secretService, true);
        $signature = hash_hmac("SHA256", $stringToSign, $secretSigning);

        return 'TC3-HMAC-SHA256'
            . " Credential=" . $secretId . "/" . $date . '/' . self::ENDPOINT_SERVICE . '/tc3_request'
            . ", SignedHeaders=content-type;host, Signature=" . $signature;
    }
}

