<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/25
 * Time: 2:36 PM
 */

class Http
{
    /**
     * host
     */
    const HOST = '0.0.0.0';
    /**
     * port
     */
    const PORT = 8811;
    /**
     * http server
     * @var null
     */
    public $http = null;

    /**
     * Http constructor.
     */
    public function __construct()
    {
        $config = [
            'worker_num' => 4, // 设置启动的Worker进程数。
            'task_worker_num' => 5,
            'max_request' => 10000,
            'enable_static_handler' => true,
            'document_root' => "/home/vagrant/code/swoole/thinkphp/public/static"
        ];
        $this->http = new swoole_http_server(self::HOST, self::PORT);
        $this->http->set($config);

        $this->init();
    }

    /**
     * 初始化监听事件 启动服务
     * @return bool
     */
    public function init()
    {
        $this->http->on('workerStart', [$this, 'onWorkerStart']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('task', [$this, 'onTask']);
        $this->http->on('finish', [$this, 'onFinish']);
        $this->http->on('close', [$this, 'onClose']);

        return $this->http->start();
    }

    /**
     * 此事件在Worker进程/Task进程启动时发生
     * @param swoole_server $server
     * @param int $workerId
     */
    public function onWorkerStart(swoole_server $server, int $workerId)
    {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../application/');

        // ThinkPHP 引导文件
        require __DIR__ . '/../thinkphp/start.php';
    }

    /**
     * 在收到一个完整的Http请求后，会回调此函数
     * @param $request
     * @param $response
     * @return mixed
     */
    public function onRequest($request, $response)
    {
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            return $response->end();
        }

        $_SERVER = [];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }
        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }
        $_POST['http_server'] = $this->http;

        ob_start();
        try {
            // 执行应用并响应
            think\Container::get('app', [APP_PATH])->run()->send();
        } catch (Exception $e) {

        }
        $content = ob_get_contents();
        ob_end_clean();

        $response->end($content);
    }

    /**
     * task任务
     * @param swoole_server $server
     * @param int $task_id
     * @param int $src_worker_id
     * @param $data
     * @return mixed
     */
    public function onTask(swoole_server $server, int $task_id, int $src_worker_id, $data)
    {
        $task = new \app\common\lib\task\Task;
        $method = $data['method'];
        $flag = $task->$method($data['data']);

        return $flag;
    }

    /**
     * 当worker进程投递的任务在task_worker中完成时，task进程会通过swoole_server->finish()方法将任务处理的结果发送给worker进程。
     * @param swoole_server $server
     * @param int $task_id
     * @param string $data
     */
    public function onFinish(swoole_server $server, int $task_id, string $data)
    {
        echo 'finish' . PHP_EOL;
    }

    /**
     * 监听连接关闭事件
     * @param swoole_server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onClose(swoole_server $server, int $fd, int $reactorId)
    {
        echo 'close' . PHP_EOL;
    }
}

new Http();