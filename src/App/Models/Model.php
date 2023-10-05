<?php

namespace App\Models;

use App\App;
use App\DBDoctrine;
use JetBrains\PhpStorm\Pure;

class Model
{
    protected DBDoctrine $db;

    #[Pure]
    public function __construct()
    {
        $this->db = App::getDB();
    }
}
