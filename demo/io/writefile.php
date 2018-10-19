<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/19
 * Time: 9:21 AM
 */

$content = date('Y-m-d H:i:s') . PHP_EOL;

$filePath = __DIR__ . '/1.txt';
$result = swoole_async_writefile($filePath, $content, function ($filename) {
    echo "write ok " . PHP_EOL;
}, FILE_APPEND);

var_dump($result);

echo 'start' . PHP_EOL;