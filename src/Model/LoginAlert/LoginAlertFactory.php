<?php

namespace App\Model\LoginAlert;

abstract class LoginAlertFactory
{
    abstract public function createLoginAlert(): LoginAlertInterface;
}
