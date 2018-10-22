<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/22
 * Time: 10:53 AM
 */

$process = new swoole_process(function (swoole_process $process) {

    $process->exec('/usr/bin/php', [__DIR__ . '/../server/http.php']);

}, false);

$pid = $process->start();
var_dump($pid);

swoole_process::wait();
