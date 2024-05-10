<?php

namespace App\Controller;

use App\Model\Profil;

class ProfilController
{
    // Affiche la page du profil
    public function profil()
    {
        ob_start();
        require 'src/View/Profil/index.php';
        $content = ob_get_clean();
        return $content;
    }

    // Prepare la requete pour la modification des donnees de l'utilisateur
    public function update($id)
    {
        // Récupére les données 
        $email = $_POST['email'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $password = $_SESSION['user']['password'];
        $role = $_SESSION['user']['role'];

        // Envoie au model pour faire la requete de maj
        $userModel = new Profil();
        $userModel->updateProfil($id, $email, $firstName, $lastName, $password, $role);

        // Ecrase les données $_SESSION['user'] pour que le changement apparaisse en front
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;


        header('Location: /');
        exit;
    }

    // Fait la requete de suppression de l'utilisateur en base de données
    public function delete($id)
    {
        $userModel = new Profil();
        $userModel->deleteProfil($id);

        // Deconnecte l'utilisateur et écrase des donnees de session
        $_SESSION['logged'] = false;
        $_SESSION['user'] = [];

        header('Location: /');
        exit;
    }

}
