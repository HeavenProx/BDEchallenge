<?php

namespace App\Model;

class Contact extends BaseModel
{
    public function createMessage($objet, $message)
    {
        // Insérer l'event dans la base de données
        $stmt = $this->db->prepare("INSERT INTO Contact(objet, message) VALUES (?, ?)");
        $stmt->execute([$objet, $message]);
    }
}