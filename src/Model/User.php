<?php

namespace App\Model;

class User extends BaseModel
{
    public function createUser($email, $firstName, $lastName, $password, $defaultRole = 'Étudiant')
    {
        // Hasher le mot de passe (vous devez implémenter une fonction de hachage sécurisée)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Par défaut, assigner le rôle spécifié (ou 'Étudiant' si aucun n'est spécifié)
        $roles = [$defaultRole];
        $role = json_encode($roles);
        // Insérer l'utilisateur dans la base de données
        $stmt = $this->db->prepare("INSERT INTO User (email, firstName, lastName, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $firstName, $lastName, $hashedPassword, $role]);
    }

    public function updateUser($userId, $email, $firstName, $lastName)
    {
        // Mettez à jour les informations de l'utilisateur dans la base de données
        $stmt = $this->db->prepare("UPDATE User SET email = ?, firstName = ?, lastName = ? WHERE userNumber = ?");
        $stmt->execute([$email, $firstName, $lastName, $userId]);
    }



    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM User");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->execute([$userId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
