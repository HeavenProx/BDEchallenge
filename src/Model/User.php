<?php

namespace App\Model;
use App\Model\Event;

class User extends BaseModel
{
    public $userNumber;
    public function createUser($email, $firstName, $lastName, $password, $defaultRole = 'Etudiant')
    {
        // Hasher le mot de passe (vous devez implémenter une fonction de hachage sécurisée)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Par défaut, assigner le rôle spécifié (ou 'Étudiant' si aucun n'est spécifié)
        $roles = [$defaultRole];
        $roles = is_array($roles) ? reset($roles) : $roles;
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

    public function deleteUser($userId)
    {
        $userId = is_array($userId) ? reset($userId) : $userId;        // Supprimez d'abord les participants de la table event_participants
        $stmtParticipants = $this->db->prepare("DELETE FROM event_participants WHERE userNumber = ?");
        $stmtParticipants->execute([$userId]);
        $stmtwishlist = $this->db->prepare("DELETE FROM wishlist WHERE userNumber = ?");
        $stmtwishlist->execute([$userId]);
        $stmtevent = $this->db->prepare("DELETE FROM event WHERE userNumber = ?");
        $stmtevent->execute([$userId]);

        $stmt = $this->db->prepare("DELETE FROM User WHERE userNumber = ?");
        if (!$stmt) {
            die("Error in DELETE statement: " . print_r($this->db->errorInfo(), true));
        }
        

        $stmt->execute([$userId]);
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

    public function getUserId($userEmail)
    {
        $stmt = $this->db->prepare("SELECT userNumber FROM User WHERE email = ?");
        $stmt->execute([$userEmail]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateVerification($userId)
    {
        $stmt = $this->db->prepare("UPDATE User SET validated = 1 WHERE userNumber = ?");
        $stmt->execute([$userId]);
    }

    public function isInWishlist($eventNumber)
    {
        $eventNumber = is_array($eventNumber) ? reset($eventNumber) : $eventNumber;        
        $stmt = $this->db->prepare("SELECT * FROM wishlist WHERE userNumber = ? AND eventNumber = ?");
        $stmt->execute([$this->userNumber, $eventNumber]);
        return $stmt->fetch() !== false;
    }

    public function insertIntoWishlist($eventNumber)
    {
        $eventNumber = is_array($eventNumber) ? reset($eventNumber) : $eventNumber;        
        $stmt = $this->db->prepare("INSERT INTO wishlist (userNumber, eventNumber) VALUES (?, ?)");
        $stmt->execute([$this->userNumber, $eventNumber]);
    }

    public function deleteFromWishlist($eventNumber)
    {
        $eventNumber = is_array($eventNumber) ? reset($eventNumber) : $eventNumber;        
        $stmt = $this->db->prepare("DELETE FROM wishlist WHERE userNumber = ? AND eventNumber = ?");
        $stmt->execute([$this->userNumber, $eventNumber]);
    }

    public function getWishlist() {
        // Assurez-vous que $this->userNumber est défini
        if (isset($this->userNumber)) {
            $stmt = $this->db->prepare("SELECT * FROM wishlist WHERE userNumber = ?");
            $stmt->execute([$this->userNumber]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            // Gérez le cas où $this->userNumber n'est pas défini
            // Peut-être générer une erreur ou logguer un avertissement
            return [];
        }
    }
}
