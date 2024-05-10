<?php

namespace App\Model\LoginAlert;

class LogAlert implements LoginAlertInterface
{
    public function alert(string $message): void
    {
        // Écrivez le message dans un fichier de log (ici nous utilisons echo pour simplifier)
        echo "Log Alert: $message\n";
    }
}
