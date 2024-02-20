<?php

namespace App\Controller;

class AssetController
{
    private function load($file, $type){
        return "/public/$type/$file";
    }
    public function styles($file): string
    {
        ob_start();
        require  $this->load($file,"css");
        $content = ob_get_clean();
        return $content;
    }

}
