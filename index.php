<?php

require 'vendor/autoload.php';

$app = new App\App();

$container = $app->getContainer();

$container['errorHandler'] = function () {
    return function ($response) {
        return $response->setBody('Page not found')->withStatus(404);
    };
};

$container['config'] = function () {
    return [
        'db_driver' => 'mysql',
        'db_host' => 'localhost',
        'db_name' => 'project',
        'db_user' => 'root',
        'db_password' => 'root',
    ];
};

$container['db'] = function () {
    return new PDO(
        'mysql:host=localhost;dbname=miniframework',
        'root',
        ''
    );
};

$app->get('/', ['App\Controllers\HomeController', 'index']);

$app->get('/', [new App\Controllers\HomeController($container->db), 'indexWithDependency']);

$app->get('/users', [new App\Controllers\UserController($container->db), 'index']);

$app->run();
