<?php
namespace tpext\controller;

use think\Controller as TpController;
use think\Config;

class Controller extends TpController{
    protected $page_index = 1;
    protected $view_layout = '';

    public function __construct(){
        parent::__construct();
        $this->page_index = intval($this->request->get('pageidx'))<=1 ? 1 : intval($this->request->get('pageidx'));
    }

    protected function fetch($template = '', $vars = [], $replace = [], $config = []){
        $content = parent::fetch($template, $vars, $replace, $config);
        if($this->view_layout){
            $view_layout = trim($this->view_layout);
            if(\strpos($view_layout,'__layouts/')!==0){
                $view_layout = \sprintf("__layouts/%s",$view_layout);
            }
            $layout_vars = array(
                'subview_content'=>$content,
            );
            $content = parent::fetch($view_layout,$layout_vars,$replace,$config);
        }
        return $content;
    }

    protected function render($template = '', $vars = [], $replace = [], $config = []){
        return $this->fetch($template,$vars,$replace,$config);
    }
}
