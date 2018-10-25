<?php

namespace app\common\lib\ali;
ini_set("display_errors", "on");

class Sms
{

    /**
     * 发送短信
     * @param $phone
     * @param $code
     * @return mixed|
     */
    public static function sendSms($phone, $code)
    {
        echo 'sentSmsTo: ' . $phone . PHP_EOL;
        echo 'code: ' . $code . PHP_EOL;
        return true;
    }

}