<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/17
 * Time: 4:07 PM
 */

$http = new swoole_http_server("0.0.0.0", 8811);

$http->set([
    'enable_static_handler' => true,
    'document_root' => "/home/vagrant/code/swoole/data"
]);

$http->on('request', function ($request, $response) {

    $log = [
        'date: ' => date('Y-m-d H:i:s'),
        'get' => $request->get,
        'post' => $request->post,
        'header' => $request->header,
    ];

    swoole_async_writefile(__DIR__ . '/access.log', json_encode($log) . PHP_EOL, function ($filename) {
        echo '日志写入成功' . PHP_EOL;
    }, FILE_APPEND);

    $response->cookie('swh', '123', time() + 1800);
    $response->end(json_encode($request->get));
});

$http->start();