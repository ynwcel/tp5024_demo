<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\exception;

class TemplateNotFoundException extends \RuntimeException
{
    public function __construct($message, protected $template = '')
    {
        $this->message  = $message;
    }

    /**
     * 获取模板文件
     * @access public
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
