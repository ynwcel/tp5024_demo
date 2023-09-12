<?php
namespace app\index\controller;

use tpext\controller\Controller;
use tpext\dao\Dao;

class Index extends Controller{

    public function index(){
        //return THINK_VERSION;
        echo "<pre>";
        $dao = Dao::connect('main');
        $wheres = array();
        $wheres[] = "id >= 3";
        $wheres[] = ["cate_id = ?",3];
        $wheres[] = ["add_time >=? and add_time <= ?",'2003-01-01',date('Y-m-d')];
        $wheres[] = ["orders","not between",[3,5]];
        $wheres[] = ["orders","not between",3,5];
        $wheres[] = ["cate_id","in",1,3,5,7,9];
        $wheres[] = ["cate_id","in",[1,3,5,7,9]];
        print_r($dao->table('e_articles')->where('id',5)->wheres($wheres)->select());
        print_r($dao->getLastSql());
    }
}
