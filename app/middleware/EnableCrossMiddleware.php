<?php

namespace app\middleware;

use Closure;
use framework\request\RequestInterface;

/**
 * Class EnableCrossMiddleware
 * @package app\middleware
 * 增加跨域请求
 */
class EnableCrossMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param RequestInterface $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(RequestInterface $request, Closure $next)
    {
        $return = $next($request);
        //前端需要在请求头加上HTTP_ORIGIN,防止其他人连接
        $origin = $request->getHeaders()['HTTP_ORIGIN'] ?? '';
        $allowOrigin = [
            'http://127.0.0.1:12345',
        ];
        if (in_array($origin, $allowOrigin)) {
            response()->addHeader('Access-Control-Allow-Origin', $origin);
            response()->addHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN');
            response()->addHeader('Access-Control-Expose-Headers', 'Authorization, authenticated');
            response()->addHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
            response()->addHeader('Access-Control-Allow-Credentials', 'true');
        }
        return $return;
    }
}
