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

#### 4.PHP 8.2 兼容改造
> 目标：不改动业务代码（`application/`、`extend/`），仅对框架核心打补丁。

* `thinkphp/library/think/console/output/Ask.php`、`Descriptor.php`
    * 字符串插值 `${width}` 改为 `{$width}`（PHP 8.2 起弃用，否则控制台直接报错）
    * `strlen()` 前加 `(string)` 强转，避免传入 `null` 触发弃用
* `thinkphp/library/think/Error.php`
    * 错误处理策略调整：仅致命类错误（E_ERROR/E_PARSE/E_CORE_ERROR/E_COMPILE_ERROR/E_USER_ERROR/E_RECOVERABLE_ERROR）抛异常，弃用/通知/警告改为记录日志
    * 原因：PHP 8.x 弃用提示极多，原来一律抛 ErrorException 会导致 500
* `thinkphp/library/think/Collection.php`、`Model.php`、`Paginator.php`
    * 为 `ArrayAccess`/`Countable`/`IteratorAggregate`/`JsonSerializable` 的方法加 `#[\ReturnTypeWillChange]`（共 19 处）
* `thinkphp/library/think/session/driver/Memcache.php`、`Memcached.php`、`Redis.php`
    * 同上：为 `SessionHandler` 的 `open/close/read/write/destroy/gc` 方法加 `#[\ReturnTypeWillChange]`（共 18 处，PHP 8.1 起类加载即报弃用）
* `thinkphp/library/think/Paginator.php`
    * `http_build_query($parameters, null, '&')` 改为 `''`，避免 PHP 8.1+ 弃用
* `thinkphp/library/think/Request.php`
    * `ip2long()` 前补 `$ip = $ip ?: '0.0.0.0';`，避免传入 `null`
* `thinkphp/library/think/App.php`
    * `ReflectionParameter::getClass()` 改为 `getType()` + `ReflectionClass`（前者自 PHP 8.0 弃用）
* `composer.json`
    * `php` 约束由 `>=5.4.0` 调整为 `>=8.0`
* 备份
    * 改动前的原文件均保留为同目录 `*.php.ai` / `*.json.ai` / `*.md.ai`