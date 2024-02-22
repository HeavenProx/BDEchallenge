<?php

namespace App\Controller;

use App\Model\Profil;

class ProfilController
{
     public function profil()
    {
        ob_start();
        require 'src/View/Profil/index.php';
        $content = ob_get_clean();
        return $content;
    }

    public function update($id)
    {
        // Récupérez les données du formulaire de mise à jour
        $email = $_POST['email'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $password = $_SESSION['user']['password'];
        $role = $_SESSION['user']['role'];

        // var_dump($email, $firstName, $lastName, $password);
        $userModel = new Profil();
        // var_dump($userModel);
        $userModel->updateProfil($id, $email, $firstName, $lastName, $password, $role);
        // var_dump($userModel);

        // Re initialiser les nouvelles données dans les $_SESSION
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;


        header('Location: /');
        exit;
    }

    public function delete($id)
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

}
