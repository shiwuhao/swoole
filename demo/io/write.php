<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/19
 * Time: 9:21 AM
 */

$content = date('Y-m-d H:i:s') . PHP_EOL;
$i = 1;
while ($i < 100000) {
    $filePath = __DIR__ . '/1.txt';
    $result = swoole_async_write($filePath, $content, -1, function ($filename) {
        echo "write ok " . PHP_EOL;
    });
    $i++;
};


var_dump($result);

echo 'start' . PHP_EOL;