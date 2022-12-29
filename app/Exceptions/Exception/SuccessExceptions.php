<?php

namespace App\Exceptions\Exception;

use App\Exceptions\Lang\Success;
use Exception;
use Illuminate\Support\Arr;

class SuccessExceptions extends Exception
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function dispose($data): array
    {
        return [
            'Code' => $data->data['code'],
            'Message' => Success::Code($data->data['code']),
            'Data' => $data->data['data'] ? $this->process($data, $data->data['code']) : null,
            'Type' => 'success',
        ];
    }


    public function process($start, $code)
    {

        if (in_array((int)$code, [29995, 29996, 29997, 29998, 29999], true)) {
            $data_start = objectArray($start);
        } else {
            $data_start = $start->data['data'];
        }
        if (in_array($code, [20013, 20004], true)) {
            return $data_start;
        } else {
            $dataInfo = null;
            if ($data_start['data']) {
                $data_except = Arr::except($data_start['data'], ['code']);
                if (Arr::exists($data_except, 'data') && Arr::exists($data_except, 'meta')) {
                    $dataInfo = $data_except;
                } elseif (!Arr::exists($data_except, 'data') && !empty($data_except)) {
                    $dataInfo = $data_except;
                } elseif (Arr::exists($data_except, 'data')) {
                    $dataInfo = ['data' => $data_except['data']];
                }
            }
            //再次处理
            return $dataInfo;
        }

    }
}
