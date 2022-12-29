<?php

namespace App\Services\Validator;

use Illuminate\Support\Facades\Http;

class Bank
{
    private static $cardType = [
        'CC' => '信用卡',
        'DC' => '储蓄卡',
    ];

    private static $bankInfo = [
        "ABC" => "中国农业银行",
        "BOC" => "中国银行",
        "CCB" => "中国建设银行",
        "CEB" => "中国光大银行",
        "CIB" => "兴业银行",
        "CITIC" => "中信银行",
        "CMB" => "招商银行",
        "CMBC" => "中国民生银行",
        "COMM" => "交通银行",
        "ICBC" => "中国工商银行",
        "JSB" => "晋商银行",
        "PSBC" => "中国邮政储蓄银行",
        "SPDB" => "上海浦东发展银行",
        "YDRCB" => "尧都农商行",
    ];

    public static function info($cardNum)
    {
        $baseUrl = "https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=" . $cardNum . "&cardBinCheck=true";
        try {
            $result = Http::retry(1, 100, throw: false)->get($baseUrl)->json();
        } catch (\Exception $e) {
            return false;
        }
        if ($result && $result['validated']) {
            return [
                'card_type' => $result['cardType'],
                'card_type_name' => self::$cardType[$result['cardType']] ?? null,
                'bank' => $result['bank'],
                'bank_name' => self::$bankInfo[$result['bank']] ?? null,
                'bank_img' => 'https://apimg.alipay.com/combo.png?d=cashier&t=' . $result['bank'],
                'card_no' => $cardNum
            ];
        }
        return false;
    }
}
