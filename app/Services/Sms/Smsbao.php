<?php
/**
 * @note: 短信宝短信
 * @author:Je_taime
 * @time: 2022/6/25 17:20
 */

namespace App\Services\Sms;

use App\Repositories\Interfaces\System\Sms\GatewayRepository;
use App\Repositories\Interfaces\System\Sms\TemplateRepository;
use Illuminate\Support\Facades\Http;

class Smsbao
{
    public const ENDPOINT_URL = 'http://api.smsbao.com/sms';
    public const ENDPOINT_TIMEOUT = 10;
    public const SUCCESS_CODE = 0;

    protected array $errorStatus = [
        '0' => '短信发送成功',
        '-1' => '参数不全',
        '-2' => '服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！',
        '30' => '密码错误',
        '40' => '账号不存在',
        '41' => '余额不足',
        '42' => '帐户已过期',
        '43' => 'IP地址限制',
        '50' => '内容含有敏感词'
    ];

    public function getGateway()
    {
        return app(GatewayRepository::class)->find('smsbao')['data'];
    }

    public function getTemplate($id)
    {
        return app(TemplateRepository::class)->find($id)['data'];
    }

    public function processContent($templateInfo, $data)
    {
        switch ($templateInfo['template_no']) {
            case 'SMS_BAO_01':   //自定义短信验证
                return '【' . $templateInfo['template_sign'] . '】' . '您的验证码是' . $data['code'] . ',5(分钟)内有效';
                break;
            case 'SMS_BAO_02':   //自定义短信消息提醒
                return null;
                break;
            default:
                return false;
        }
    }

    public function send($phone, $template, $data)
    {
        if ($message = $this->processContent($this->getTemplate($template), $data)) {
            $params = [
                'u' => $this->getGateway()['key'],
                'p' => $this->getGateway()['secret'],
                'm' => $phone,
                'c' => $message
            ];
            $result = Http::timeout(self::ENDPOINT_TIMEOUT)->get(self::ENDPOINT_URL, $params)->json();
            if ((int)$result === self::SUCCESS_CODE) {
                return [
                    'Code' => 'OK',
                    'Message' => '短信发送成功'
                ];
            }
            return [
                'Code' => $result,
                'Message' => $this->errorStatus[$result] ?? '未知的短信错误',
            ];
        }
        return [
            'Code' => 60022,
            'Message' => '短信内容参数异常',
        ];
    }
}
