<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return 'swh';
    }
    public function swh()
    {
        echo date('Y-m-d H:i:s');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
