<?php

namespace App\Controller;

class IndexController
{
    public function home(): string
    {
        return "Accueil";
    }

    public function contact(): string
    {
        return "Contact";
    }
}
