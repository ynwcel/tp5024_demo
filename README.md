### 基于 `ThinkPHP 5.0.24` 
#### 1.修改
* 自定义 `composer.json`
    * 避免更新其它库时，恢复已修改的内容
* 修改 `thinkphp/tpl/think_exception.tpl` 
    * 取消显示 版本号
* 修改 `thinkphp/library/think/db/Query.php:400` 行
    * 使用 `[]` 取值，避免 `php7.4`报错
* 增加 `thinkphp/library/think/db/Query.php:1035` 行
    * 增加 `wheres` 方法，方便二维数组设置参数
* 修改 `thinkphp/library/traits/controller/Jump.php`
    * 所有方法返回 `response`，而不使用 `HttpResponseException`

#### 2.封装 


#### 3.`Nginx` 支持 `PATHINFO`
```
set $script $uri;
set $path_info "";
if ($uri ~ "^(.+?\.php)(/.+)$") {
    set $script $1;
    set $path_info $2;
}
fastcgi_param SCRIPT_NAME $script;
fastcgi_param PATH_INFO $path_info;
```