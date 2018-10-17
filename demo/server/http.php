<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/17
 * Time: 4:07 PM
 */

$http = new swoole_http_server("0.0.0.0", 8811);

$http->set([
    'enable_static_handler' => true,
    'document_root' => "/home/vagrant/code/swoole/data"
]);

$http->on('request', function ($request, $response) {
    $swh = $request->get['swh'];
    $response->cookie('swh', '123', time() + 1800);
    $response->end(json_encode($request->get));
});

$http->start();