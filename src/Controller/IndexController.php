<?php

namespace App\Controller;

class IndexController
{
    public function home(): string
    {   
        // var_dump($_SESSION);
        ob_start();
        require 'src/View/Home/index.php';
        $content = ob_get_clean();
        return $content;
    }
}
