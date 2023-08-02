<?php

use App\Exceptions\ErrorMessageException;

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

$router->get('/log/stack', function () {
    App::getContainer()->get('log')->debug('{language} is the best language', ['language' => 'php']);
    App::getContainer()->get('log')->info('Hello World');
});

$router->get('exception', function () {
    throw new ErrorMessageException('the server did not want to bird you and threw an exception');
});

$router->get('error', function () {
    //    ErrorMessageException
    //    12321
});
