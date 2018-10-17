<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/16
 * Time: 10:38 AM
 */

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);

$serv->set([
    'worker_num' => 4, // 设置启动的Worker进程数。
    'max_request' => 10000,
]);

/**
 * 监听连接进入事件
 * $fd 客户端连接唯一标识
 * $reactor_id 线程ID
 */
$serv->on('connect', function ($serv, $fd, $reactor_id) {
    echo "TCP-Client: 线程ID:{$reactor_id}-客户端ID:{$fd}Connect.\n";
});

//监听数据接收事件

$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "TCP-Server: 线程ID:{$reactor_id}-客户端ID:{$fd}-数据:{$data}");
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "TCP-Client: Close.\n";
});

//启动服务器
$serv->start();