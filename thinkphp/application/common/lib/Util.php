<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/23
 * Time: 上午8:58
 */
namespace app\common\lib;
/**
 * Class Util
 * @package app\common\lib
 */
class Util {

    /**
     * @param $status
     * @param string $message
     * @param array $data
     * @return false|string
     */
    public static function show($status, $message = '', $data = []) {
        $result = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        return json_encode($result, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
    }
}