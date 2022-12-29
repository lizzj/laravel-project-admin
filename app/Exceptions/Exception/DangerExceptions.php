<?php

namespace App\Exceptions\Exception;

use App\Exceptions\Lang\Danger;
use Exception;

class DangerExceptions extends Exception
{
    public $data;

    /**
     * @throws \JsonException
     */
    public function dispose($data)
    {
        $result = $data['class'];
        return [
            'Code' => Danger::Init($result)['code'],
            'Message' => Danger::Init($result)['message'],
            'Type' => 'error',
        ];
    }
}
