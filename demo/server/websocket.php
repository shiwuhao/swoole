<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/17
 * Time: 5:31 PM
 */

$server = new swoole_websocket_server("0.0.0.0", 8812);

$server->set([
    'enable_static_handler' => true,
    'document_root' => "/home/vagrant/code/swoole/data"
]);

// 监听websocket连接打开事件
$server->on('open', function (swoole_websocket_server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
});

// 监听websocket消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

// 监听websocket关闭事件
$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();