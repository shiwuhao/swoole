<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/17
 * Time: 6:03 PM
 */

class Ws
{
    /**
     *
     */
    const HOST = '0.0.0.0';
    /**
     *
     */
    const PORT = 8812;

    /**
     * @var null|swoole_websocket_server
     */
    public $ws = null;

    /**
     * Ws constructor.
     */
    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "server-push-message:{$frame->data}\n";
        $ws->push($frame->fd, 'server-push:' . date("Y-m-d H:i:s"));
    }

    /**
     * 监听ws关闭事件
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "clientid:{$fd} close";
    }
}

$obj = new Ws();