<?php

// 连接tcp服务
$client = new swoole_client(SWOOLE_SOCK_UDP);

if (!$client->connect('127.0.0.1', 9501)) {
    echo '连接失败';
    exit();
}

// 获取用户输入
fwrite(STDOUT,'请输入消息：');
$msg = trim(fgets(STDIN));

// 发送用户输入给 tcp server服务器
$client->send($msg);

// 接受来自server的数据
$result = $client->recv();

echo $result;