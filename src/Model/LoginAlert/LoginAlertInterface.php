<?php

namespace App\Model\LoginAlert;

interface LoginAlertInterface
{
    public function alert(string $message): void;
}
