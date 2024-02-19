<?php

namespace App\Model;

class User extends BaseModel
{
    public function createUser($email, $firstName, $lastName, $password, $roles = ['Étudiant'])
    {
        // Hasher le mot de passe (vous devez implémenter une fonction de hachage sécurisée)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Convertir le tableau de rôles en chaîne JSON
        $rolesJson = json_encode($roles);

        // Insérer l'utilisateur dans la base de données
        $stmt = $this->db->prepare("INSERT INTO users (email, first_name, last_name, password, roles) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $firstName, $lastName, $hashedPassword, $rolesJson]);
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
