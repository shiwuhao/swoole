<?php
namespace app\index\controller;

use app\common\lib\ali\Sms;
use think\Exception;

class Index
{
    public function index()
    {
        return '';
//        return 'swh';
    }
    public function swh()
    {
        echo date('Y-m-d H:i:s');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function sms()
    {
        try{
            Sms::sendSms(18501367987, 12345);
        }catch (Exception $e) {

        }
    }
}
