<?php

namespace App\Jobs\System\Sms;

use App\Repositories\Interfaces\System\Sms\LogRepository;
use App\Services\Sms\{Aliyun, Qcloud, Smsbao};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

/**
 * @note: 发送短信队列
 * @author:Je_taime
 * @time: 2022/6/27 9:11
 */
class Send implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return false
     */
    public function handle()
    {
        $log = app(LogRepository::class);
        $logInfo = $log->find($this->id)['data'];
        $sms = match ($logInfo['gateway']) {
            'aliyun' => new Aliyun(),
            'qcloud' => new Qcloud(),
            'smsbao' => new Smsbao(),
            default => null,
        };
        if ($sms) {
            $log->processResult($sms->send($logInfo['phone'], $logInfo['template_id'], $logInfo['content']), $this->id, $logInfo['gateway']);
        }
    }

    public function failed(Throwable $e)
    {
        $param = [
            'id' => $this->id,
        ];
        queueFail(__CLASS__, $param, $e);
    }
}
