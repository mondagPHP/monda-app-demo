<?php
/**
 * This file is part of Monda-PHP.
 *
 */
return [
    //全局
    'global' => [
        \app\middleware\GlobalMiddleWare::class,
        \app\middleware\EnableCrossMiddleware::class,
    ],

    //模块名
    'admin' => [
        \app\middleware\WebMiddleWare::class,
    ],
];
