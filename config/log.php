<?php
/**
 * This file is part of Monda-PHP.
 *
 */
return [
    'default' => 'daily',
    'channels' => [
        //所有日志在一个文件上
        'stack' => [
            'path' => RUNTIME_PATH . '/log/',
            'format' => '[%s][%s] %s',
        ],
        //按照每天记录
        'daily' => [
            'path' => RUNTIME_PATH . '/log/',
            'format' => '[%s][%s] %s',
        ],
    ],
];
