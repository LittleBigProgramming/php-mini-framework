<?php

namespace App\Controllers;

use PDO;
use App\Models\User;

class UserController
{
    protected $db;

    /**
     * UserController constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param $response
     * @return mixed
     */
    public function index($response)
    {
        $users = $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_CLASS, User::class);

        return $response->withJson($users);
    }
}
