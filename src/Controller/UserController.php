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
