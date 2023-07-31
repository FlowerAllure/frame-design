<?php

if (!isset($router)) {
    return;
}
$router->get('/hello', function () {
    return '你在访问 Api Hello';
});
