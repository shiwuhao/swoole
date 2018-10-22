<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/22
 * Time: 3:31 PM
 */

echo 'process start:' . date('Y-m-d H:i:s') . PHP_EOL;
$workers = [];
$urls = [
    'http://baidu.com',
    'http://sina.com',
    'http://qq.com',
    'http://baidu.com?search=shiwuhao',
    'http://baidu.com?search=swh',
    'http://baidu.com?search=cxd',
];

foreach ($urls as $url) {
    echo curlData($url);
}

function curlData($url)
{
    sleep(1);
    return $url . ' success' . PHP_EOL;
}

echo 'process end:' . date('Y-m-d H:i:s') . PHP_EOL;