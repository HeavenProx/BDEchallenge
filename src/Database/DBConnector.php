<?php

namespace App\Database;

use PDO;

class DBConnector
{
    private $pdo;

    public function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../../config/db.ini');
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
