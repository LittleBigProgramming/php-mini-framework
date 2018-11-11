<?php

namespace App\Controllers;

use PDO;

class HomeController
{

    /**
     * @param $response
     */
    public function index($response)
    {
        echo 'Home';
    }

    /**
     * @param $response
     * @return mixed
     */
    public function indexWithDependency($response)
    {
        return $response->setBody('Home');
    }
}
