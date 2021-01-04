<?php
/**
 * This file is part of Monda-PHP.
 *
 */

namespace app\middleware;

/**
 * 全局中间件
 * Class GlobalMiddleWare.
 */
class GlobalMiddleWare
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
