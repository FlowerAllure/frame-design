<?php

// 开发期间 显示所有错误
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

use Core\Request\PHPRequest;

require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app.php';

App::getContainer()->bind('STR', function () {
    return 'Hello';
});

echo App::getContainer()->get('STR');

App::getContainer()->bind('request', function () {
    return PHPRequest::create(
        $_SERVER['REQUEST_URI'],
        $_SERVER['REQUEST_METHOD'],
        $_SERVER
    );
});

App::getContainer()->get('response')->setContent(
    App::getContainer()->get('request')->getMethod()
)->send();

App::getContainer()->get('response')->setContent(
    App::getContainer()->get('request')->getMethod()
)->send();

App::getContainer()->get('response')->setContent(
    App::getContainer()->get('router')->dispatch(App::getContainer()->get('request'))
)->send();

endView();
