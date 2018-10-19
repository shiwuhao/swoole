<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/19
 * Time: 9:21 AM
 */

$filePath = __DIR__ . '/1.txt';
$result = swoole_async_read($filePath, function ($filename, $fileContent) {
    echo "filename: $filename" . PHP_EOL;
    echo "fileContent: $fileContent" . PHP_EOL;

    sleep(3);
});

var_dump($result);

echo 'start' . PHP_EOL;