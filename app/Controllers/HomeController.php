<?php

namespace App\Controllers;

use PDO;

class HomeController
{
    public function __construct(PDO $db)
    {
        var_dump($db);
        die;
    }

    public function index()
    {
        echo 'Home';
    }

    public function indexWithDependency()
    {
        echo 'Home';
    }
}
