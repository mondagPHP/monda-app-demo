<?php

use framework\Container;
use framework\request\FpmRequest;
use framework\request\RequestInterface;

require_once dirname(__DIR__) . '/bootstrap/app.php';
//适配request
Container::getContainer()->bind(RequestInterface::class, static function () {
    return FpmRequest::create($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_SERVER);
});
Container::getContainer()->get('response')->setContent(
    Container::getContainer()->get('router')->dispatch(
        Container::getContainer()->get(RequestInterface::class)
    )
)->send();
