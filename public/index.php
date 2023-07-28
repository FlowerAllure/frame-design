<?php

// 开发期间 显示所有错误
error_reporting(E_ALL);
date_default_timezone_set("Asia/Shanghai");

use Core\request\PHPRequest;
use Psr\Http\Message\RequestInterface;

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app.php';

App::getContainer()->bind('str',function (){
    return 'hello str';
});

echo App::getContainer()->get('str');

echo hello();

App::getContainer()->bind('Request', function () {
    return PHPRequest::create(
        $_SERVER['REQUEST_URI'],
        $_SERVER['REQUEST_METHOD'],
        $_SERVER
    );
});

App::getContainer()->get('response')->setContent(
    App::getContainer()->get('Request')->getMethod()
)->send();

endView();