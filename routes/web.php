<?php

if (!isset($router)) {
    return;
}
$router->get('/hello', function () {
    echo App::getContainer()->get('config')->get('database.connections.mysql.driver');
    App::getContainer()->get('config')->set('database.connections.mysql.driver', 'mysql set');
    echo App::getContainer()->get('config')->get('database.connections.mysql.driver');

    return '你在访问 Hello';
});

$router->get('/db', function () {
    $id = 1;
    var_dump(App::getContainer()->get('db')->select('select * from users where id = ?', [$id]));
});

$router->get('/query', function () {
    var_dump(App::getContainer()->get('db')->table('users')->where('id', '<>', 10)->get());
});

$router->get('/model', function () {
    var_dump(\App\Models\User::where('id', '<>', 10)->get());
});

$router->get('/controller', 'UserController@index');

$router->get('/view/blade', function () {
    return App::getContainer()->get('view')->render('index.html', ['name' => 'Twig']);
});
