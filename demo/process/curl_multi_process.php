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

for ($i = 0; $i < 6; $i++) {
    $process = new swoole_process(function (swoole_process $worker) use ($i, $urls) {
        $content = curlData($urls[$i]);
        $worker->write($content . PHP_EOL);
    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $worker) {
    echo $worker->read();
}

function curlData($url)
{
    sleep(1);
    return $url . ' success' . PHP_EOL;
}

echo 'process end:' . date('Y-m-d H:i:s') . PHP_EOL;