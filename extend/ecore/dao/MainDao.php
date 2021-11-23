<?php
namespace ecore\dao;

use think\DB;

class MainDao extends AbsDao{

    public function db(){
        return DB::connect(config('database.main'));
    }
}