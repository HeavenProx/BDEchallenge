<?php

namespace App\Controller;

use App\Model\User;
use App\Controller\MailController;

class AuthenticationController {

    public function register()
    {
        // Charger le contenu de la vue register_form.php
        $viewPath = __DIR__ . '/../View/Authentication/register_form.php';
        $viewContent = file_get_contents($viewPath);
    
        // Retourner le contenu de la vue
        return $viewContent;
    }

    public function registered()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $email = $_POST['email'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validez les données d'inscription (ajoutez des validations supplémentaires selon vos besoins)
            // Enregistrez l'utilisateur dans la base de données
            $userModel = new User();
            $userModel->createUser($email, $firstName, $lastName, $password);

        }

        $content = '
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmation de compte</title>
        </head>
        <body>
            <h1>Confirmation de compte</h1>
            <p>Merci de vous être inscrit! Cliquez sur le lien ci-dessous pour valider votre compte :</p>
            <a href="http://localhost:8000/confirmation/CURRENT_ID">Valider mon compte</a>
        </body>
        </html>
        ';
        $id = $userModel->getUserId($_POST['email']);
        $contentWithId = str_replace('CURRENT_ID', strval(reset($id)), $content);
        
        //Send a confirmation mail
        $mailController = new MailController();
        $mailController->sendMail('beebdechallenge@gmail.com', 'BEEDE', $_POST['email'], $_POST['first_name'] . $_POST['last_name'], 'Confirmation de compte', $contentWithId);


        $viewPath = __DIR__ . '/../View/Authentication/registered.php';
        $viewContent = file_get_contents($viewPath);
        return $viewContent;
    }

    public function confirmation($id){
        $id = intval($id[0]);
        $userModel = new User();
        $userModel->updateVerification($id);

        $viewPath = __DIR__ . '/../View/Authentication/confirmation.php';
        $viewContent = file_get_contents($viewPath);
        return $viewContent;
    }
}