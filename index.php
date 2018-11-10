<?php

require 'vendor/autoload.php';

$app = new App\App();

$container = $app->getContainer();

$container['errorHandler'] = function () {
    die('404, not found');
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

$app->get('/', function () {
    echo "home";
});

$app->post('/signup', function () {
    echo "sign up";
});

$app->map('/users', function () {
    echo 'Users';
}, ['GET', 'POST']);

$app->run();
