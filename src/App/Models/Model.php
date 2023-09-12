<?php

namespace App\Models;

use App\App;

class Model
{
    protected \PDO $db;

    public function __construct()
    {
        $this->db = App::getDB()->getPDO();
    }
}