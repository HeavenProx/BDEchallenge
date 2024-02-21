<?php

namespace App\Controller;

use App\Model\Event;

class EventController
{
    public function index()
    {
        $event = new Event();
        $events = $event->getAllEvents();

        // Incluez les utilisateurs dans la vue
        $viewPath = __DIR__ . '/../View/Event/index.php';
        ob_start();  // Démarre la temporisation de sortie
        include $viewPath;  // Inclut la vue
        $viewContent = ob_get_clean();  // Récupère le contenu de la temporisation de sortie et l'efface

        return $viewContent;
    }

    public function create(){
        ob_start();
        require 'src/View/Event/create.php';
        $content = ob_get_clean();
        return $content;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $name = $_POST['name'] ?? '';
            $category = $_POST['category'] ?? '';
            $eventDate = $_POST['eventDate'] ?? '';
            $location = $_POST['location'] ?? '';
            $description = $_POST['description'] ?? '';

            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                // Validez les données d'inscription (ajoutez des validations supplémentaires selon vos besoins)
                // Enregistrez l'utilisateur dans la base de données
                $eventModel = new Event();
                $eventModel->createEvent($name, $category, $eventDate, $location, $description, $_SESSION['user']['userNumber']);

                header('Location: /events');
                exit;
            } else{
                $_SESSION['error'] = "Vous n'êtes pas connecté";
                header('Location: /event/create');
            }
        }
    }

    public function edit($id)
    {
        $eventModel = new Event();
        $event = $eventModel->getEventById($id);

        // Vérifiez si l'event est trouvé
        if ($event === false) {
            // Faites quelque chose en cas d'event non trouvé, par exemple, redirigez l'utilisateur
            // header('Location: /not_found');
            // exit;
        }

        $viewPath = __DIR__ . '/../View/Event/edit.php';
        ob_start();
        include $viewPath;
        $viewContent = ob_get_clean();

        return $viewContent;
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire de mise à jour
            $name = $_POST['name'] ?? '';
            $category = $_POST['category'] ?? '';
            $eventDate = $_POST['eventDate'] ?? '';
            $location = $_POST['location'] ?? '';
            $description = $_POST['description'] ?? '';

            // Appel de la méthode updateEvent du modèle
            $eventModel = new Event();
            $eventModel->updateEvent($id, $name, $category, $eventDate, $location, $description);

            // Redirection vers la liste des événements
            header('Location: /events');
            exit;
        }
    }

    public function delete($id)
    {
        // Utilisez l'$id pour supprimer l'utilisateur de la base de données
        $eventModel = new Event();
        $eventModel->deleteEvent($id);
        // Redirigez l'utilisateur vers la liste des utilisateurs ou effectuez toute autre action souhaitée
        header('Location: /events');
        exit;
    }


}