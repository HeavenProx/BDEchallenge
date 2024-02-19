<?php

namespace App\Model;

use App\Database\DBConnector;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = (new DBConnector())->getPDO();
    }
}
