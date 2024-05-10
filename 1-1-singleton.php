<?php

require_once 'src/Model/Database/DbConnection.php';

use App\Model\Database\DbConnection;

$dbConnection = DbConnection::getInstance();
$pdo = $dbConnection->getConnection();

// Effectuez une requête de test pour vérifier la connexion
$statement = $pdo->query('SELECT * FROM Event');
foreach ($statement as $row) {
    echo implode(', ', $row) . PHP_EOL;
}
