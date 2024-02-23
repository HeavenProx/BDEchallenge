<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Profil;

class UserController
{

    // Envoie sur la page où se trouve tous les users
    public function index()
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin'){

        // CHarge tous les users
        $user = new User();
        $users = $user->getAllUsers();

        // Incluez les utilisateurs dans la vue
        $viewPath = __DIR__ . '/../View/User/index.php';
        ob_start();  // Démarre la temporisation de sortie
        include $viewPath;  // Inclut la vue
        $viewContent = ob_get_clean();  // Récupère le contenu de la temporisation de sortie et l'efface
        return $viewContent;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas acceder à cette page";
            header('Location: /');
        }
    }

    // Envoie sur la page de creation de compte
    public function create()
    {
        // Verifie si l'user est un admin
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

    // Prepare la requete pour enregistrer un nouvel utilisateur 
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $email = $_POST['email'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Envoie l'enregistrement de l'utilisateur dans la base de données
            $userModel = new User();
            $userModel->createUser($email, $firstName, $lastName, $password);

            header('Location: /users');
            exit;
        }
        // Affichez le formulaire d'inscription
        echo 'Vous êtes bien inscrit !';
    }

    // Envoie sur la page de modification de l'utilisateur
    public function edit($id)
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin'){

            // Cherche le user par son id
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

    // Prepare la requete de modification de l'utilisateur
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire de mise à jour
            $email = $_POST['email'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';

            // Demande la suppression de l'user au model
            $userModel = new User();
            $userModel->updateUser($id, $email, $firstName, $lastName, $password, $role);
            header('Location: /users');
            exit;
        }
    }

    // Prepare la suppression de l'utilisateur dans la bdd
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

    // Prepare l'ajout dans la wishlist
    public function addToWishlist($eventNumber)
    {
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
    }

    // Prepare la suppression dans la wishlist
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
