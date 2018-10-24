<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/17
 * Time: 4:07 PM
 */

$http = new swoole_http_server("0.0.0.0", 8811);

$http->set([
    'worker_num' => 4, // 设置启动的Worker进程数。
    'max_request' => 10000,
    'enable_static_handler' => true,
    'document_root' => "/home/vagrant/code/swoole/thinkphp/public/static"
]);

$http->on('WorkerStart', function (swoole_server $server, $workerId) {

    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');

    // ThinkPHP 引导文件
    // 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';
});

$http->on('request', function ($request, $response) use ($http) {

    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        return $response->end();
    }

    $_SERVER = [];
    if (isset($request->server)) {
        foreach ($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if (isset($request->header)) {
        foreach ($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    $_GET = [];
    if (isset($request->get)) {
        foreach ($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }
    $_POST = [];
    if (isset($request->post)) {
        foreach ($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }

    // 执行应用并响应
    ob_start();
    try {
        think\Container::get('app', [APP_PATH])->run()->send();
    } catch (Exception $e) {

    }
    $content = ob_get_contents();
    ob_end_clean();

    $response->end($content);
});

$http->start();
