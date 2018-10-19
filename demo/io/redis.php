<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/19
 * Time: 2:18 PM
 */

$redis = new swoole_redis();
$redis->connect('127.0.0.1', 6379, function ($client, $result) {
    echo 'connect success' . PHP_EOL;

    $client->set('swh', time(), function ($client, $result) {
        var_dump($client);
        var_dump($result);
        $client->close();
    });

    $client->get('swh', function ($client, $result) {
        var_dump('get: '.$result);
        $client->close();
    });

    $client->keys('*', function ($client, $result) {
        var_dump($result);
        $client->close();
    });
});

echo 'start' . PHP_EOL;