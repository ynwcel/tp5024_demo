<?php
namespace ecore\controller;

use think\Controller;

class AbsController extends Controller{
    protected $page_index = 1;
    protected $page_size = 50;
    protected $view_layout = '';

    public function __construct(){
        parent::__construct();
        $this->page_index = intval($this->request->get('pageidx'))<=1 ? 1 : intval($this->request->get('pageidx'));
        $this->page_size = intval($this->request->get('pagesize'))<=50 ? 50 : intval($this->request->get('pagesize'));
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
}