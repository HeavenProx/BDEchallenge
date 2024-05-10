<?php

namespace App\Model\LoginAlert;

class DatabaseAlert implements LoginAlertInterface
{
    public function alert(string $message): void
    {
        // Enregistrez le message dans la base de données (ici nous utilisons echo pour simplifier)
        echo "Database Alert: $message\n";
    }
}
