<?php
namespace app\index\controller;

use tpext\controller\Controller;

class Index extends Controller{

    public function index(){
        return THINK_VERSION;
    }
}
