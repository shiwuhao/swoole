<?php
/**
 * Created by PhpStorm.
 * User: shiwuhao
 * Date: 2018/10/23
 * Time: 10:56 AM
 */

$table = new swoole_table(1024);
$table->column('id', swoole_table::TYPE_INT, 4);
$table->column('name', swoole_table::TYPE_STRING, 64);
$table->column('age', swoole_table::TYPE_INT, 3);
$table->create();

$table->set('swh', ['id' => '1', 'name' => 'shiwuhao', 'age' => 20]);

$res = $table->get('swh');
print_r($res);
$table->incr('swh', 'age', 2 );
$res = $table->get('swh');
print_r($res);

$table->decr('swh', 'age', 1 );
$res = $table->get('swh');
print_r($res);

$table->del('swh');
$res = $table->get('swh');
var_dump($res);