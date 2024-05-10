<?php

namespace App\Model\Event;

class Event
{
    protected $eventNumber;
    protected $name;
    protected $category;
    protected $eventDate;
    protected $location;
    protected $description;

    public function __construct($eventNumber, $name, $category, $eventDate, $location, $description)
    {
        $this->eventNumber = $eventNumber;
        $this->name = $name;
        $this->category = $category;
        $this->eventDate = $eventDate;
        $this->location = $location;
        $this->description = $description;
    }

    // Méthodes de base de l'événement...
}
