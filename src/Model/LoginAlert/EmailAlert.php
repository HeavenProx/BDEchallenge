<?php

namespace App\Model\LoginAlert;

class EmailAlert implements LoginAlertInterface
{
    public function alert(string $message): void
    {
        // Envoyez le message par e-mail (ici nous utilisons echo pour simplifier)
        echo "Email Alert: $message\n";
    }
}
