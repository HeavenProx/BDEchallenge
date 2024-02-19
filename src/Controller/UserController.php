<?php

namespace App\Controller;

use App\Model\User;

class UserController
{
    public function index()
    {
        $user = new User();
        $users = $user->getAllUsers();
        //ok 
        // Faites quelque chose avec les données récupérées, par exemple, affichez-les dans une vue
    }
}
