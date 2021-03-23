<?php
/**
 * This file is part of Monda-PHP.
 *
 */
return [
    //默认url
    'default_url' => [
        'module' => 'admin',
        'action' => 'index',
        'method' => 'index',
    ],
    //用于生成安全cookie
    'app_key' => env('app_key', ''),
    //应用名称
    'app_name' => env('app_name', 'monda-php'),
    //打印sql语句
    'app_debug' => env('app_debug', false),
    //环境
    'app_env' => 'dev',

    //正则路由映射
    'route_map' => [
        '^\/index5$' => '/admin/index/index5',
        '^\/index6$' => '/admin/index/index6'
    ]
];
