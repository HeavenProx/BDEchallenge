<?php

namespace App\Controller;

//use App\Model\User;

class ProfilController
{
    public function profil()
    {
        $viewPath = __DIR__ . '/../View/Profil/index.php';
        ob_start();  // Démarre la temporisation de sortie
        include $viewPath;  // Inclut la vue
        $viewContent = ob_get_clean();  // Récupère le contenu de la temporisation de sortie et l'efface
    }
}
