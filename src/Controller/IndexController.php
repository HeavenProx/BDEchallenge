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

    public function contact(): string
    {
        // Charger le contenu de la vue register_form.php
        $viewPath = __DIR__ . '/../View/Contact/index.php';
        $viewContent = file_get_contents($viewPath);
    
        // Retourner le contenu de la vue
        return $viewContent;
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $objet = $_POST['objet'] ?? '';
            $message = $_POST['message'] ?? '';
            
            // Validez les données 
            // Enregistrez le message dans la base de données
            $contactModel = new Contact();
            $contactModel->createMessage($objet, $message);

            header('Location: /');
            exit;
        }
    }
}
