<?php
namespace ecore\dao;

abstract class AbsDao {

    protected $current_command = array();

    public function __construct(){
        
    }

    public abstract function db();

    public function __call($method,$params=array()){
    	return call_user_func_array(array($this->db(),$method), $params);
    }

    public function prepare($command,$params=array()){
        if(func_num_args()!=2 || !is_array($params)){
            $_args = func_get_args();
            $command = array_shift($_args);
            $params = $_args;
        }
        $table_prefix = "";
        $db_config = $this->db()->getConfig();
        if(\is_array($db_config) && isset($db_config['prefix']) && $db_config['prefix']){
            $table_prefix = $db_config['prefix']; 
        }
        $command = preg_replace("/{{([^\s]+)}}/i", $table_prefix.'\\1', $command);

        $this->current_command = array($command,$params);
        return $this;
    }

    public function fetchRow(){
        $query = $this->query();
        if($query){
            return array_shift($query);
        }
        return false;
    }

    public function fetchMap($key_field,$val_field=null){
        $lists = $this->fetchAll();
        $maps = array();
        if(is_array($lists) && $key_field){
            foreach($lists as $row){
                if(isset($row[$key_field])){
                    $maps[$row[$key_field]] = $val_field ? (isset($row[$val_field]) ? $row[$val_field] : null) : $row;
                }
            }
        }
        return $maps;
    }
    
    public function fetchAll(){
        return $this->query();
    }

    public function fetchPage($page_size=30){
        list($command,$params) = $this->current_command;
        return $this->db()->table(sprintf("(%s) as a ",$command))->bind($params)->paginate($page_size);
    }

    public function execute(){
        list($command,$params) = array_values($this->current_command);
        $this->current_command = null;

        return $this->db()->execute($command,$params);
    }

    public function hasTable($table){
        $command = sprintf("show tables like '{{%s}}'",$table);
        $row = $this->prepare($command)->fetchAll();
        if(is_array($row) && count($row) == 1){
            return current(current($row));
        }else{
            return false;
        }
    }


    private function query(){
        list($command,$params) = array_values($this->current_command);
        $this->current_command = null;

        return $this->db()->query($command,$params);
    }
}