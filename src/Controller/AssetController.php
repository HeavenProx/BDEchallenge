<?php

namespace App\Controller;

class AssetController
{
    private function load($file, $type){
        return __DIR__. "../../../public/$type/$file";
    }

    //à supprimer si pas de soucis pour charger le css
    // public function styles($file): string
    // {
    //     ob_start();
    //     include  $this->load($file["file"],"css");
    //     $content = ob_get_clean();
    //     return $content;
    // }
    public function images($file): string
    {
        ob_start();
        include  $this->load($file["file"],"asset/img");
        $content = ob_get_clean();
        return $content;
    }

}
