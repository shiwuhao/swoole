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

        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2
        ]);

        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
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
        echo "ws连接事件\n fd:$request->fd\n";

        // 设置一个间隔时钟定时器
        if ($request->fd == 1) {
            swoole_timer_tick(2000, function ($timerId) {
                echo "2s: timerId:$timerId\n";
            });
        }
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "ws消息事件\n 客户端发送消息为{$frame->data}\n";
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];
//        $ws->task($data);

        swoole_timer_after(5000, function () use ($ws, $frame) {
            $ws->push($frame->fd, "server-time-after\n");
        });

        $ws->push($frame->fd, 'server-push:' . date("Y-m-d H:i:s"));
    }

    /**
     * 监听ws关闭事件
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "ws关闭事件\n clientId:{$fd} close\n";
    }

    /**
     * 执行task任务
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     */
    public function onTask($serv, $taskId, $workerId, $data)
    {
        print_r($data);
        sleep(10);
        return 'on task finish'; // 告诉worker进程
    }

    /**
     * task任务完成事件
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo "task任务完成事件\n taskId: {$taskId}\n";
        echo "finish data success: {$data}\n";
    }
}

$obj = new Ws();