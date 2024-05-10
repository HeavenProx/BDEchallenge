<?php

namespace App\Controller;

use App\Model\User;
use App\Controller\MailController;

class AuthenticationController {

    // Charger le contenu de la vue register_form.php
    public function register()
    {
        $viewPath = __DIR__ . '/../View/Authentication/register_form.php';
        $viewContent = file_get_contents($viewPath);
    
        // Retourner le contenu de la vue
        return $viewContent;
    }

    // Charger le contenu de la vue login_form.php
    public function login()
    {
        // Charger le contenu de la vue login_form.php
        // $viewPath = __DIR__ . '/../View/Authentication/login_form.php';
        // $viewContent = file_get_contents($viewPath);
        ob_start();
        require 'src/View/Authentication/login_form.php';
        $content = ob_get_clean();
        return $content;

    }

    // Gere si l'user est inscrit ou mdp incorrect
    // Si c'est bon : attribue les variables de session user et logged
    public function checklogs() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getUserByEmail($email);

            if ($user === false) {
                $_SESSION['error'] = "Vous n'êtes pas inscrit";
            } elseif (!password_verify($password, $user['password'])) {
                $_SESSION['error'] = "Mot de passe incorrect";
            }

            if ($_SESSION['error'] != "") {
                // Rediriger vers la page de connexion en incluant le message d'erreur dans l'URL
                header('Location: /login');
                exit;
            } else {
                // Authentification réussie
                $_SESSION['logged'] = true;
                $_SESSION['user'] = $user;
                $_SESSION['user']['role'] = $user['role'];
                header('Location: /');
            }
        }
    }

    // Inscrit un nouvel utilisateur et lui envoie un mail de validation
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
        
        // Envoie l'email de confirmation
        $mailController = new MailController();
        $mailController->sendMail('mathis.enrici@gmail.com', 'BEEDE', $_POST['email'], $_POST['first_name'] . $_POST['last_name'], 'Confirmation de compte', $contentWithId);

        // Redirige le nouvel utilisaeur sur la page de confirmation
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

        $user = $userModel->getUserById($id);
        $mailController = new MailController();
        $mailController->sendMail($user['email'], $user['lastName'] . " " . $user['firstName'], 'mathis.enrici@gmail.com', 'BEEDE', 'Confirmation de compte', $user['lastName'] . " " . $user['firstName'] . ' a confirmé son compte !');

        return $viewContent;
    }

    // Deconnecte l'utilisateur, ecrase ses variables de session et le redirige a l'accueil
    public function logout()
    {
        $_SESSION['logged'] = false;
        $_SESSION['user'] = [];
        header('Location: /');
    }
}