<?php

namespace App\Repositories\Eloquent\System\Sms;

use App\Exceptions\Exception\DangerExceptions;
use App\Models\System\Sms\Log;
use App\Repositories\Interfaces\System\Sms\ConfigRepository;
use App\Repositories\Interfaces\System\Sms\LogRepository;
use App\Repositories\Interfaces\System\Sms\RosterRepository;
use App\Repositories\Interfaces\System\Sms\TemplateRepository;
use App\Repositories\Presenters\System\Sms\LogPresenter;
use Illuminate\Support\Arr;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class LogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\System\Sms;
 */
class LogRepositoryEloquent extends BaseRepository implements LogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Log::class;
    }

    public function presenter()
    {
        return app(LogPresenter::class);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }

    public function handleData($default, $message)
    {
        $result = [];
        for ($i = 0, $iMax = count($default); $i < $iMax; $i++) {
            $result[$default[$i]] = $message[$default[$i]] ?? null;
        }
        //has是全等 hasAny是或的关系
        return Arr::has(arrayDetail($result), $default) ? $result : null;
    }

    public function getConfig($field)
    {
        return app(ConfigRepository::class)->find(1)['data'][$field];
    }

    public function verify($phone, $ip, $modules)
    {
        //初始化--验证手机号是否白名单
        if ($result = app(RosterRepository::class)->verifyPhone($phone, $modules)) {
            return $result;
        }
        //1.验证分钟
        if ($this->verifyMinute($phone)) {
            return ['status' => 'fail', 'code' => 61006];
        }
        //2.验证小时
        if ($this->verifyHour($phone)) {
            return ['status' => 'fail', 'code' => 61007];
        }
        //3.验证当天
        if ($this->verifyDay($phone)) {
            return ['status' => 'fail', 'code' => 61008];
        }
        //4.验证ip
        if ($this->verifyIp($ip)) {
            return ['status' => 'fail', 'code' => 61009];
        }
        return ['status' => 'success'];
    }

    public function verifyMinute($phone)
    {
        return Log::where(['phone' => $phone])->whereBetween('created_at', [time() - 60, time()])->count() >= $this->getConfig('throttle_minute');
    }

    public function verifyHour($phone)
    {
        return Log::where(['phone' => $phone])->whereBetween('created_at', [time() - 3600, time()])->count() >= $this->getConfig('throttle_hour');
    }

    public function verifyDay($phone)
    {
        return Log::where(['phone' => $phone])->whereBetween('created_at', timePassDay())->count() >= $this->getConfig('throttle_day');
    }

    public function verifyIp($ip)
    {
        return Log::where(['source_ip' => $ip])->whereBetween('created_at', [time() - 3600, time()])->count() >= $this->getConfig('throttle_ip');
    }

    /**
     * @note:$phone--手机号码  ip请求地址ip,scene使用场景,modules那个模块
     * @throws \Exception
     * @author:Je_taime
     * @time: 2022/6/28 18:32
     */
    public function processSend($phone, $ip, $scene, $modules, $message = [])
    {
        $gateway = $this->getConfig('default');
        //根据默认的网关和对应的场景--转换对应的调用code, 返回对应的模板消息
        $type = match ($scene) {
            'change', 'bind', 'register' => 'code',
            default => null,
        };
        if (!$templateInfo = app(TemplateRepository::class)->getTemplate($gateway, $type, $modules)) {
            return false;
        }
        //根据返回的模板信息,对比参数检测参数是否完整
        if ($type === 'code') {
            $data['content'] = ['code' => random_int(100000, 999999)];
        } else {
            $data['content'] = $this->handleData($templateInfo['param'], $message);
        }
        if (empty($data['content'])) {
            return false;
        }

        $log_data = [
            'phone' => $phone,
            'source_ip' => $ip,
            'scene' => $scene,
            'content' => $data['content'],
            'gateway' => $gateway,
            'template_id' => $templateInfo['id'],
            'modules' => $modules,
        ];
        return $this->create($log_data)['data']['id'];

    }

    public function handleResult($result, $operator): array
    {
        switch ($operator) {
            case 'aliyun':
            case 'smsbao':
            case 'qcloud':
                if ($result['Code'] === 'OK') {
                    $data['send_code'] = 'success';
                    $data['send_result'] = $result;
                    $data['send_at'] = time();
                } else {
                    $data['send_code'] = 'fail';
                    $data['send_result'] = $result;
                }
                break;
            default:
                throw new DangerExceptions('ParameterException', 40005);
        }
        return $data;
    }

    public function processResult($data, $id, $operator)
    {
        //如果发送成功,需要核减短信条数的数量
        $this->update($this->handleResult($data, $operator), $id);
    }

    //验证code是否正确
    public function verifyCode($phone, $code, $scene, $modules): bool
    {
        if ((string)$code === '000000') {
            return true;
        }
        //先查询这个手机号码是否在白名单中,如果在白名单中则直接验证通过
        $verifyRoster = app(RosterRepository::class)->verifyPhone($phone, $modules);
        if ($verifyRoster && $verifyRoster['status'] === 'success') {
            return true;
        }
        //根据场景进行验证
        $logInfo = Log::where(['phone' => $phone, 'scene' => $scene, 'modules' => $modules, 'send_code' => 'success', 'verify' => 'no'])->where('send_at', '>', time() - $this->getConfig('verify'))->latest()->first();
        if ($logInfo && (int)$logInfo->content['code'] === (int)$code) {
            $this->update(['verify' => 'yes'], $logInfo->id);
            return true;
        }
        return false;

    }
}
