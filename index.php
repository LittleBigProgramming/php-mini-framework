<?php

require 'vendor/autoload.php';

$app = new App\App();

$container = $app->getContainer();

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
        'mysql:host=localhost;dbname=project',
        'root',
        'root'
    );
};

$app->get('/', function () {
    echo "Home";
});

$app->get('/users', function () {
    echo "users";
});

$app->run();
