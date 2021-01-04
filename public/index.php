<?php


use Dotenv\Dotenv;
use framework\Container;
use framework\request\FpmRequest;
use framework\request\RequestInterface;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', dirname(__DIR__) . '/app');
define('CONFIG_PATH', dirname(__DIR__) . '/config');
define('CORE_PATH', dirname(__DIR__) . '/core');
define('RUNTIME_PATH', dirname(__DIR__) . '/runtime');
//分布式ID生成
define('SERVER_NODE', 0x01);
//开始时间
define('START_TIME', microtime(true));
//开始内存
define('START_MEMORY', memory_get_usage());

require __DIR__ . '/../vendor/autoload.php';
//加载环境变量
Dotenv::create(BASE_PATH, '.env')->load();
//适配request
Container::getContainer()->bind(RequestInterface::class, static function () {
    return FpmRequest::create($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_SERVER);
});


Container::getContainer()->get('response')->setContent(
    Container::getContainer()->get('router')->dispatch(
        Container::getContainer()->get(RequestInterface::class)
    )
)->send();
