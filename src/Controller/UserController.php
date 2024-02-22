<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Profil;

class UserController
{
    public function create()
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin'){
            ob_start();
            require 'src/View/User/register_form.php';
            $content = ob_get_clean();
            return $content;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
    }


    public function register()
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
            $mailController->sendMail('mathis.enrici@gmail.com', 'BEEDE', $_POST['email'], $_POST['first_name'] . $_POST['last_name'], 'Confirmation de compte', $contentWithId);

            header('Location: /users');
            exit;
        }
     
        // Affichez le formulaire d'inscription
        echo 'Vous êtes bien inscrit !';
    }

    public function edit($id)
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin'){

            $userModel = new User();
            $user = $userModel->getUserById($id);

            $viewPath = __DIR__ . '/../View/User/edit.php';
            ob_start();
            include $viewPath;
            $viewContent = ob_get_clean();

            return $viewContent;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire de mise à jour
            $email = $_POST['email'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';

            // var_dump($email, $firstName, $lastName, $password);
            $userModel = new User();
            // var_dump($userModel);
            $userModel->updateUser($id, $email, $firstName, $lastName, $password, $role);
            // var_dump($userModel);
            header('Location: /users');
            exit;
        }
    }

    public function delete($id)
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin'){

        // Utilisez l'$id pour supprimer l'utilisateur de la base de données
        $userModel = new User();
        $userModel->deleteUser($id);
        // var_dump($userModel);
        // Redirigez l'utilisateur vers la liste des utilisateurs ou effectuez toute autre action souhaitée
        header('Location: /users');
        exit;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
    }
    public function index()
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin'){
        $user = new User();
        $users = $user->getAllUsers();

        // Incluez les utilisateurs dans la vue
        $viewPath = __DIR__ . '/../View/User/index.php';
        ob_start();  // Démarre la temporisation de sortie
        include $viewPath;  // Inclut la vue
        $viewContent = ob_get_clean();  // Récupère le contenu de la temporisation de sortie et l'efface

        return $viewContent;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
    }



    public function profil()
    {
        ob_start();
        require 'src/View/Profil/index.php';
        $content = ob_get_clean();
        return $content;
    }

    public function profilUpdate($id)
    {
        // Récupérez les données du formulaire de mise à jour
        $email = $_POST['email'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $password = $_SESSION['user']['password'];
        $role = $_SESSION['user']['role'];

        // var_dump($email, $firstName, $lastName, $password);
        $profilModel = new Profil();
        // var_dump($userModel);
        $profilModel->updateProfil($id, $email, $firstName, $lastName, $password, $role);
        // var_dump($userModel);

        // Re initialiser les nouvelles données dans les $_SESSION
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;


        header('Location: /');
        exit;
    }

    public function profilDelete($id)
    {
        // Utilisez l'$id pour supprimer l'utilisateur de la base de données
        $userModel = new Profil();
        $userModel->deleteProfil($id);

        $_SESSION['logged'] = false;
        $_SESSION['user'] = [];
        // var_dump($userModel);
        // Redirigez l'utilisateur vers la liste des utilisateurs ou effectuez toute autre action souhaitée
        header('Location: /');
        exit;
    }

    public function addToWishlist($eventNumber)
    {
        // var_dump($_SESSION);// Assurez-vous que l'utilisateur est connecté et que userNumber est disponible
        if ((isset($_SESSION['logged']) && $_SESSION['logged'] == true)) {
            $userModel = new User();
            $userModel->userNumber = $_SESSION['user']['userNumber'];

            if (!$userModel->isInWishlist($eventNumber)) {
                // Ajoutez l'événement à la wishlist
                $userModel->insertIntoWishlist($eventNumber);
            }
            header('Location: /events');
            exit;
        }

        // Créez une instance du modèle User
        
    }

    public function removeFromWishlist($eventNumber)
    {
        // Assurez-vous que l'utilisateur est connecté et que userNumber est disponible
        if ((isset($_SESSION['logged']) && $_SESSION['logged'] == true)) {
            $userModel = new User();
            $userModel->userNumber = $_SESSION['user']['userNumber'];

            if ($userModel->isInWishlist($eventNumber)) {
                // Ajoutez l'événement à la wishlist
                $userModel->deleteFromWishlist($eventNumber);
            }
            header('Location: /events');
            exit;
        }
    }

    public function wishlist()
    {
        // Assurez-vous que l'utilisateur est connecté et que userNumber est disponible
        if (isset($_SESSION['userNumber'])) {
            // Créez une instance du modèle User
        $userModel = new User();
        $userModel->userNumber = $_SESSION['userNumber'];

        // Obtenez la wishlist de l'utilisateur
        $wishlist = $userModel->getWishlist();

        // Affichez la wishlist dans la vue (à implémenter)
        // ...

        // Vous pouvez également rediriger l'utilisateur si nécessaire
        header('Location: /events');
        exit;
        }

        
    }
    
}
