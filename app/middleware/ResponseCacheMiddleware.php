<?php
/**
 * This file is part of Monda-PHP.
 *
 */

namespace app\middleware;

use Carbon\Carbon;
use framework\cache\CacheFactory;
use framework\cache\FileCache;
use framework\request\RequestInterface;

/**
 * 建议放在首页
 * 设置返回缓存
 */
class ResponseCacheMiddleware
{
    /**
     * @var RequestInterface $request
     */
    private $request;

    /**
     * @var \Closure
     */
    private $next;

    /**
     * @var int 默认1分钟
     */
    private $minutes = 1;

    /**
     * @var array 缓存数据
     */
    private $responseCache;

    /**
     * 缓存命中状态，1为命中，0为未命中
     *
     * @var int
     */
    protected $cacheHit = 1;

    /**
     * 缓存Key
     *
     * @var string
     */
    protected $cacheKey;


    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     * 针对Get请求
     */
    public function handle($request, \Closure $next)
    {
        $this->prepare($request, $next);
        $this->responseCache();
        $headers = $this->addHeaders();
        foreach ($headers ?? [] as $key => $header) {
            response()->addHeader($key, $header);
        }
        return $this->responseCache['content'];
    }

    /**
     * 初始化数据
     * @param $request
     * @param \Closure $next
     */
    private function prepare($request, \Closure $next)
    {
        $this->request = $request;
        $this->next = $next;
        $this->cacheKey = $this->resolveKey();
    }

    /**
     * 根据请求获取指定的Key
     */
    private function resolveKey(): string
    {
        return md5($this->request->getFullUrl());
    }

    /**
     * @return array
     */
    private function responseCache(): array
    {
        /** @var FileCache $fileCache */
        $fileCache = CacheFactory::get('file');
        $this->responseCache = $fileCache->remember(
            $this->cacheKey,
            $this->minutes * 60,
            function () {
                $this->cacheMissed();
                $response = ($this->next)($this->request);
                return [
                    'content' => $response,
                    'cacheExpireAt' => Carbon::now()->addMinutes($this->minutes)->format('Y-m-d H:i:s T')
                ];
            }
        );
        return $this->responseCache;
    }


    /**
     * 缓存未命中
     * @return mixed
     */
    protected function cacheMissed(): void
    {
        $this->cacheHit = 0;
    }

    /**
     * 追加Headers
     *
     * @param mixed
     * @return array
     */
    protected function addHeaders(): array
    {
        return [
            'X-Cache' => $this->cacheHit ? 'Hit from cache' : 'Missed',
            'X-Cache-Key' => $this->cacheKey,
            'X-Cache-Expires' => $this->responseCache['cacheExpireAt'],
        ];
    }

}
