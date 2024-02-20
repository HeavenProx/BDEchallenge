<?php

namespace App\Controller;

class IndexController
{
    public function home(): string
    {
        return $this->render('auth.html.twig');
    }

    public function contact(): string
    {
        return "Contact";
    }
}
