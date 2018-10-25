<?php

namespace app\index\controller;

use app\common\lib\Util;
use think\Exception;

/**
 * Class Send
 * @package app\index\controller
 */
class Send
{
    /**
     *
     */
    public function index()
    {

        $phone = intval($_GET['phone']);
        if (empty($phone)) {
            return Util::show(config('code.error'), 'error');
        }

        $code = rand(1000, 9999);

        $taskData = [
            'method' => 'sendSms',
            'data' => [
                'phone' => $phone,
                'code' => $code,
            ],
        ];

        $_POST['http_server']->task($taskData);

        return Util::show(config('code.success'), 'ok');
    }

}
