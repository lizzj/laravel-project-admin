<?php

namespace App\Exceptions\Exception;

use App\Exceptions\Lang\Warning;
use Exception;

class WarningExceptions extends Exception
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @throws \JsonException
     */
    public function dispose($data)
    {
        $data = $data->data;
        return [
            'Code' => array_key_exists("code", $data) ? $data['code'] : 60001,
            'Message' => array_key_exists("message", $data) ? $data['message'] : Warning::Code($data['code']),
            'Type' => 'warning'
        ];
    }
}
