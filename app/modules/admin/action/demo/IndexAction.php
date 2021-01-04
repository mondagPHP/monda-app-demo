<?php
/**
 * This file is part of Monda-PHP.
 *
 */
namespace app\modules\admin\action\demo;


use framework\Controller;
use framework\request\RequestInterface;

/**
 * Class UserController.
 */
class IndexAction extends Controller
{
    public function index(RequestInterface $request): array
    {
        return [
            'method2' => $request->getMethod(),
            'url2' => $request->getUri(),
        ];
    }
}
