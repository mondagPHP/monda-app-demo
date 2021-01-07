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
];
