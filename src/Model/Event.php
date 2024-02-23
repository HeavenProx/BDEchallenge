<?php

namespace App\Model;

class Event extends BaseModel
{

    public $userNumber;
    public function getAllEvents()
    {
        $stmt = $this->db->query("SELECT * FROM Event");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    public function createEvent($name, $category, $eventDate, $location, $description, $DefaultUsernumber)
    {
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
        $eventId = is_array($eventId) ? reset($eventId) : $eventId;
        // Supprimez d'abord les participants de la table event_participants
        $stmtParticipants = $this->db->prepare("DELETE FROM event_participants WHERE eventNumber = ?");
        $stmtParticipants->execute([$eventId]);
        $stmtwishlist = $this->db->prepare("DELETE FROM wishlist WHERE eventNumber = ?");
        $stmtwishlist->execute([$eventId]);

        // Ensuite, supprimez l'événement de la table event
        $stmtEvent = $this->db->prepare("DELETE FROM Event WHERE eventNumber = ?");
        if (!$stmtEvent) {
            die("Error in DELETE statement: " . print_r($this->db->errorInfo(), true));
        }


        $stmtEvent->execute([$eventId]);
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

    public function addParticipant($eventNumber)
    {
        $eventNumber = is_array($eventNumber) ? reset($eventNumber) : $eventNumber;        

        $stmt = $this->db->prepare("INSERT INTO event_participants (userNumber, eventNumber) VALUES (?, ?)");
        $stmt->execute([$this->userNumber, $eventNumber]);
    }

    public function deleteParticipant($eventNumber)
    {
        $eventNumber = is_array($eventNumber) ? reset($eventNumber) : $eventNumber;        

        $stmt = $this->db->prepare("DELETE FROM event_participants WHERE userNumber = ? AND eventNumber = ?");
        $stmt->execute([$this->userNumber, $eventNumber]);
    }

    public function isParticipant($eventNumber) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM event_participants WHERE eventNumber = ? AND userNumber = ?");
        $stmt->execute([$eventNumber, $this->userNumber]);
        return $stmt->fetchColumn() > 0;
    }
    public function getParticipants($eventNumber)
    {
        $stmt = $this->db->prepare("SELECT userNumber FROM event_participants WHERE eventNumber = ?");
        $stmt->execute([$eventNumber]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
