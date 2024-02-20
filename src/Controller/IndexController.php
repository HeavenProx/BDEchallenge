<?php

namespace App\Controller;

class IndexController
{
    public function home(): string
    {
        ob_start();
        require 'src/View/Home/index.php';
        $content = ob_get_clean();
        return $content;
    }

    public function contact(): string
    {
        return "Contact";
    }
}
