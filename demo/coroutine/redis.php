<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/23
 * Time: 11:14 AM
 */


$http = new swoole_http_server('0.0.0.0', 8811);
$http->on('request', function ($request, $response) {

    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->set('key', $request->get['key']);
    $value = $redis->get('key');

    $response->header("Content-type", 'text/plain');
    $response->end($value);
});

$http->start();