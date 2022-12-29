<?php
/**
 * @note:
 * @return WeChatMiniProgram
 * @author:Je_taime
 * @time: 2022/11/9 11:03
 */

namespace App\Services\Util;

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\MiniApp\Application as MiniProgramApplication;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Modules\Mall\Repositories\Interfaces\System\ConfigRepository;

class WeChatMiniProgram
{
    /**
     * @throws InvalidArgumentException
     */
    public static function config($name)
    {
        $configName = 'oauth_' . $name;
        $configInfo = self::getSystemConfig($configName);
        if ($configInfo) {
            $config = [
                'app_id' => $configInfo['app_id'],
                'secret' => $configInfo['secret'],
                'http' => [
                    'throw' => false, // 状态码非 200、300 时是否抛出异常，默认为开启
                    'timeout' => 5.0,
                    'retry' => true, // 使用默认重试配置
                ],
            ];
            return new MiniProgramApplication($config);
        }
        return false;
    }

    /**
     * @note: 获取AccessToken
     * @author:Je_taime
     * @time: 2022/11/9 11:05
     */
    public static function getAccessToken($name)
    {
        $redisName = 'redis_' . $name . '_accessToken';
        try {
            $accessToken = self::config($name)->getAccessToken()->getToken();
        } catch (\Exception $e) {
            self::getAccessToken($name);
        }
        Redis::setex(self::getSystemConfig($redisName), 7100, $accessToken);
        return $accessToken;
    }

    /**
     * @note:Code解析换openid和sessionKey
     * @author:Je_taime
     * @time: 2022/11/9 11:06
     */
    public static function codeToSession($data, $name)
    {
        try {
            $result = self::config($name)->getUtils()->codeToSession($data['code']);
        } catch (\Exception $e) {
            return false;
        }
        return $result;
    }

    /**
     * @note:根据sessionKey来解析加密数据信息
     * @author:Je_taime
     * @time: 2022/11/9 11:06
     */
    public static function decryptData($data, $name): bool|array
    {
        //先解析code
        if ($sessionInfo = self::codeToSession($data, $name)) {
            try {
                $result = self::config($name)->getUtils()->decryptSession($sessionInfo['session_key'], $data['iv'], $data['encryptedData']);
            } catch (\Exception $e) {
                return false;
            }
            $result['session_key'] = $sessionInfo['session_key'];
            $result['openid'] = $sessionInfo['openid'];
            $result['unionid'] = $sessionInfo['unionid'];
            return $result;
        }
        return false;
    }

    /**
     * @note: 根据Code和AccessToken来换取用户的手机号
     * @author:Je_taime
     * @time: 2022/11/9 11:06
     */
    public static function getPhoneNumber($code, $name)
    {
        $configInfo = self::getSystemConfig($name);
        $accessToken = Redis::get($configInfo['redis']);
        $data = [
            'code' => $code,
        ];
        $baseUrl = 'https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=' . $accessToken;
        $response = Http::retry(1, 100, throw: false)->post($baseUrl, $data)->json();
        if ((int)$response['errcode'] === 0) {
            return $response['phone_info']['phoneNumber'];
        }
        return false;
    }

    public static function getSystemConfig($name)
    {
        return app(ConfigRepository::class)->getConfig($name);
    }
}
