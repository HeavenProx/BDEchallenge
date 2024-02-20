<?php

namespace App\Controller;

use App\Model\User;

class UserController
{
    public function create()
    {
        // Charger le contenu de la vue register_form.php
        $viewPath = __DIR__ . '/../View/User/register_form.php';
        $viewContent = file_get_contents($viewPath);
    
        // Retourner le contenu de la vue
        return $viewContent;
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
        $userModel = new User();
        $user = $userModel->getUserById($id);

        // Vérifiez si l'utilisateur est trouvé
        if ($user === false) {
            // Faites quelque chose en cas d'utilisateur non trouvé, par exemple, redirigez l'utilisateur
            // header('Location: /not_found');
            // exit;
        }

        $viewPath = __DIR__ . '/../View/User/edit.php';
        ob_start();
        include $viewPath;
        $viewContent = ob_get_clean();

        return $viewContent;
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
        // Utilisez l'$id pour supprimer l'utilisateur de la base de données
        $userModel = new User();
        $userModel->deleteUser($id);
        // var_dump($userModel);
        // Redirigez l'utilisateur vers la liste des utilisateurs ou effectuez toute autre action souhaitée
        header('Location: /users');
        exit;
    }
    public function index()
    {
        $user = new User();
        $users = $user->getAllUsers();

        // Incluez les utilisateurs dans la vue
        $viewPath = __DIR__ . '/../View/User/index.php';
        ob_start();  // Démarre la temporisation de sortie
        include $viewPath;  // Inclut la vue
        $viewContent = ob_get_clean();  // Récupère le contenu de la temporisation de sortie et l'efface

        return $viewContent;
    }
}
