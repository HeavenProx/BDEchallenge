<?php

namespace App\Model\Database;

use PDO;

class DbConnection
{
    private static $instance;
    private PDO $connection;

    private function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../../config/db.ini');

        // Configurez la connexion à la base de données (remplacez les valeurs ci-dessous par vos configurations)
        $dsn = "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_NAME']};charset={$config['DB_CHARSET']}";
        $username = $config['DB_USER'];
        $password = $config['DB_PASSWORD'];

        $this->connection = new PDO($dsn, $username, $password);
    }

    public static function getInstance(): DbConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
