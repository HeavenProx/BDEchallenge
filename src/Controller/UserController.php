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
        // Utilisez l'$id pour récupérer les informations de l'utilisateur à éditer
        $userModel = new User();
        $user = $userModel->getUserById($id);

        // Passez les informations de l'utilisateur à la vue
        $viewPath = __DIR__ . '/../View/User/edit_form.php';
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

            // Validez les données de mise à jour (ajoutez des validations supplémentaires selon vos besoins)
            // Mettez à jour les informations de l'utilisateur dans la base de données
            $userModel = new User();
            $userModel->updateUser($id, $email, $firstName, $lastName);
        }

        // Affichez le formulaire de mise à jour
        echo 'Vos informations ont bien été mises à jour !';
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
