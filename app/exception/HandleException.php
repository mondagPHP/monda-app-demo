<?php
/**
 * This file is part of Monda-PHP.
 *
 */

namespace app\exception;

use framework\exception\BaseExceptionHandler;
use Throwable;

/**
 * Class HandleException.
 */
class HandleException extends BaseExceptionHandler
{
    protected $ignores = [
    ];

    /**
     * @param Throwable $e
     *                     异常托管到这个方法
     */
    public function handleException(Throwable $e): void
    {
        if (method_exists($e, 'render')) {
            app('response')->setContent(
                $e->render()
            )->send();
        }
        if (! $this->isIgnore($e)) { // 不忽略 记录异常到日志去
            app('log')->debug(
                $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine()
            );
            echo $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine();
        }
    }
}
