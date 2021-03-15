<?php

use Dotenv\Dotenv;
use framework\Bootstrap;
use framework\log\Logger;
use framework\response\Response;
use framework\route\PipeLine;
use framework\route\Router;
use framework\view\HerosphpView;
use framework\view\ViewInterface;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
if (! file_exists(BASE_PATH . '/.env')) {
    echo '请先配置.env 配置文件';
    die;
}
$envConfig = parse_ini_file(BASE_PATH . '/.env');
define('ENV', $envConfig['env'] ?? 'prod');

define('CONFIG_PATH', BASE_PATH . '/config');
define('CORE_PATH', BASE_PATH . '/core');
define('RUNTIME_PATH', BASE_PATH . '/runtime');
define('TIME_ZONE', 'PRC');
//分布式ID生成
define('SERVER_NODE', 0x01);
//开始时间
define('START_TIME', microtime(true));
//开始内存
define('START_MEMORY', memory_get_usage());
//设置默认时区
date_default_timezone_set(TIME_ZONE);
require __DIR__ . '/../vendor/autoload.php';
//加载环境变量
Dotenv::create(BASE_PATH, 'env_' . ENV)->load();

Bootstrap::getInstance()->setRegisters([
    'response' => Response::class,
    'log' => Logger::class,
    'router' => Router::class,
    'pipeline' => PipeLine::class,
    ViewInterface::class => HerosphpView::class,
])->init();
