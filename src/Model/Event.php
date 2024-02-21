<?php

namespace App\Model;

class Event extends BaseModel
{

    public function getAllEvents()
    {
        $stmt = $this->db->query("SELECT * FROM Event");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    public function createEvent($name, $category, $eventDate, $location, $description, $DefaultUsernumber = 2)
    {
        // Par défaut, assigner le user number 2 ==== a changer
        $usernumber = [$DefaultUsernumber];
        if (is_array($usernumber)) {
            $usernumber = reset($usernumber);
        }
        // Insérer l'event dans la base de données
        $stmt = $this->db->prepare("INSERT INTO Event(name, category, eventDate, location, description, userNumber) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $category, $eventDate, $location, $description, $usernumber]);
    }

    
    public function updateEvent($eventNumber, $name, $category, $eventDate, $location, $description)
    {
        // Mettez à jour les informations de l'événement dans la base de données
        $stmt = $this->db->prepare("UPDATE event SET name = ?, category = ?, eventDate = ?, location = ?, description = ? WHERE eventNumber = ?");
        
        // Garder la premiere valeur du tableau
        $eventNumber = is_array($eventNumber) ? reset($eventNumber) : $eventNumber;
        // Exécution de la requête
        $stmt->execute([$name, $category, $eventDate, $location, $description, $eventNumber]);
        var_dump($stmt->errorInfo());
    }

    
    public function deleteEvent($eventId)
    {
        // Mettez en œuvre la logique pour supprimer l'utilisateur de la base de données
        $stmt = $this->db->prepare("DELETE FROM Event WHERE eventNumber = ?");
        if (!$stmt) {
            die("Error in DELETE statement: " . print_r($this->db->errorInfo(), true));
        }
        $eventId = is_array($eventId) ? reset($eventId) : $eventId;

        $stmt->execute([$eventId]);
    }

    public function getEventById($eventId)
    {
        // Assurez-vous que $eventId est une valeur, pas un tableau
        if (is_array($eventId)) {
            // Utilisez la première valeur du tableau
            $eventId = reset($eventId);
        }

        $stmt = $this->db->prepare("SELECT * FROM Event WHERE eventNumber = ?");
        
        if (!$stmt) {
            die("Error in SELECT statement: " . print_r($this->db->errorInfo(), true));
        }

        $stmt->execute([$eventId]);

        $event = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Gestion du cas où aucun événement n'est trouvé
        return ($event !== false) ? $event : null;
    }

    /*
    public function getUserId($userEmail)
    {
        $stmt = $this->db->prepare("SELECT userNumber FROM User WHERE email = ?");
        $stmt->execute([$userEmail]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateVerification($userId)
    {
        $stmt = $this->db->prepare("UPDATE User SET verified = 1 WHERE userNumber = ?");
        $stmt->execute([$userId]);
    }*/
}
