<?php

namespace App\Model;

class Profil extends BaseModel
{
    
    public function updateProfil($userId, $email, $firstName, $lastName, $password, $role)
    {
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Ajouter la colonne du rôle et lui attribuer une valeur
        $userId = is_array($userId) ? reset($userId) : $userId;

    
        // Mettez à jour les informations de l'utilisateur dans la base de données
        $stmt = $this->db->prepare("UPDATE User SET email = ?, firstName = ?, lastName = ?, password = ?, role = ? WHERE userNumber = ?");
        var_dump($stmt);
        $stmt->execute([$email, $firstName, $lastName, $hashedPassword, $role, $userId]);
        var_dump($userId);
    }

    public function getProfilById($userId)
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

    public function deleteProfil($userId)
    {
        // Mettez en œuvre la logique pour supprimer l'utilisateur de la base de données
        $stmt = $this->db->prepare("DELETE FROM User WHERE userNumber = ?");
        if (!$stmt) {
            die("Error in DELETE statement: " . print_r($this->db->errorInfo(), true));
        }
        $userId = is_array($userId) ? reset($userId) : $userId;

        $stmt->execute([$userId]);
    }
}
