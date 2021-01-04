<?php
/**
 * This file is part of Monda-PHP.
 *
 */
return [
    //全局
    'global' => [
        \app\middleware\GlobalMiddleWare::class,
    ],

    //模块名
    'admin' => [
        \app\middleware\WebMiddleWare::class,
    ],
];
