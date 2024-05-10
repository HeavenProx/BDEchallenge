<?php

namespace App\Model\Repository;

use App\Model\Database\DbConnection;

class Repository
{
    protected DbConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = DbConnection::getInstance();
    }

    
    public function find($id)
    {
        
        $stmt = $this->dbConnection->getConnection()->prepare("SELECT * FROM entity WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        
    }

    public function delete($id)
    {
        
    }
}
