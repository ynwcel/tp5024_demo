<?php
namespace app\index\controller;

use ecore\controller\AbsController;

class Index extends AbsController{


    public function index(){
        return THINK_VERSION;
    }
}
