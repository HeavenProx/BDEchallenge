<?php

namespace App\Model;

class User extends BaseModel
{
    public function createUser($email, $firstName, $lastName, $password, $defaultRole = 'Etudiant')
    {
        // Hasher le mot de passe (vous devez implémenter une fonction de hachage sécurisée)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Par défaut, assigner le rôle spécifié (ou 'Étudiant' si aucun n'est spécifié)
        $roles = [$defaultRole];
        if (is_array($roles)) {
            $roles = reset($roles);
        }
        // Insérer l'utilisateur dans la base de données
        $stmt = $this->db->prepare("INSERT INTO User (email, firstName, lastName, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $firstName, $lastName, $hashedPassword, $roles]);
    }

    public function updateUser($userId, $email, $firstName, $lastName, $password, $defaultRole = 'Étudiant')
    {
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Ajouter la colonne du rôle et lui attribuer une valeur
        $roles = [$defaultRole];
        $roles = is_array($roles) ? reset($roles) : $roles;
        $userId = is_array($userId) ? reset($userId) : $userId;

    
        // Mettez à jour les informations de l'utilisateur dans la base de données
        $stmt = $this->db->prepare("UPDATE User SET email = ?, firstName = ?, lastName = ?, password = ?, role = ? WHERE userNumber = ?");
        var_dump($stmt);
        $stmt->execute([$email, $firstName, $lastName, $hashedPassword, $roles, $userId]);
        var_dump($userId);

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
        // Assurez-vous que $userId est une valeur, pas un tableau
        if (is_array($userId)) {
            // Utilisez la première valeur du tableau
            $userId = reset($userId);
        }

        $stmt = $this->db->prepare("SELECT * FROM User WHERE userNumber = ?");
        $stmt->execute([$userId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
