<?php

use Dotenv\Dotenv;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
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

date_default_timezone_set(TIME_ZONE);  //设置默认时区
require __DIR__ . '/../vendor/autoload.php';
//加载环境变量
Dotenv::create(BASE_PATH, '.env')->load();
