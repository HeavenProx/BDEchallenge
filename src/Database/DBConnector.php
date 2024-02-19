<?php

namespace App\Database;

use PDO;

class DBConnector
{
    private $pdo;

    public function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../../config/db.ini');
        
        // Utilisez les clés correctes du fichier db.ini
        $dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset={$config['DB_CHARSET']}";
        
        $this->pdo = new PDO($dsn, $config['DB_USER'], $config['DB_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}