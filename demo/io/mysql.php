<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/19
 * Time: 10:16 AM
 */

class AsyncMysql
{

    public $db;
    public $dbConfig;

    public function __construct()
    {
        $this->db = new Swoole\Mysql;

        $this->dbConfig = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'homestead',
            'password' => 'secret',
            'database' => 'test',
            'charset' => 'utf8'
        ];
    }

    public function update()
    {

    }

    public function add()
    {

    }

    public function execute($id)
    {
        $this->db->connect($this->dbConfig, function ($db, $result) use ($id) {
            if ($result === false) {
                exit($db->connect_error);
            }

//            $sql = "select * from test where id = {$id}";
            $sql = "update test set username='shiwuhao' where id = {$id}";
            $db->query($sql, function ($db, $result) {
                if ($result === false) {
                    exit($db->eroor);
                } elseif ($result === true) {
                    var_dump($db->affected_rows);
                } else {
                    var_dump($result);
                }

                $db->close();
            });
        });

        return true;
    }
}

$mysql = new AsyncMysql();
$result = $mysql->execute(1, '');
var_dump($result);

echo 'start ' . PHP_EOL;