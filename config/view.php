<?php
/**
 * This file is part of Monda-PHP.
 *
 */
return [
    // 模板缓存路径
    'cache_path' => RUNTIME_PATH . '/views/',

    // 模板的根目录
    'view_path' => BASE_PATH . '/views/',

    /**
     * 模板编译缓存配置
     * 0 : 不启用缓存，每次请求都重新编译(建议开发阶段启用)
     * 1 : 开启部分缓存， 如果模板文件有修改的话则放弃缓存，重新编译(建议测试阶段启用)
     * -1 : 不管模板有没有修改都不重新编译，节省模板修改时间判断，性能较高(建议正式部署阶段开启)
     */
    'cache' => 0,

    //模板后缀名
    'ext' => '.html',
];
