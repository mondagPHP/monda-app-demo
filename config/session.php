<?php
/**
 * This file is part of Monda-PHP.
 *
 */
return [
    /*
    * 定义session介质
    * 1. file => 文件介质存储 (default)
    * 2. redis => redis介质存储
    */
    'session_handler' => 'file',

    //file session configure
    'file' => [
        'session_file_prefix' => 'monda_session_',              /* session file prefix */
        'session_update_interval' => 30,                        /* session update interval */
        'session_save_path' => RUNTIME_PATH . '/session',       /* session文件保存路径 */
        'gc_maxlifetime' => 3600,                              /* session gc lifetime */
        'file_mode' => '0777',
    ],

    //redis session configure
    'redis' => [
        'gc_maxlifetime' => 86400,                             /* session gc lifetime */
    ],
];
