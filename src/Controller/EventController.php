<?php

namespace App\Controller;

use App\Model\Event;
use App\Model\User;

class EventController
{
    public function index()
    {
        
        $event = new Event();
        $allEvents = $event->getAllEvents();
        // var_dump($allEvents);
        $eventsToCome = [];
        foreach ($allEvents as $e) {
            if(isset($_GET['category']) && isset($_GET['date'])){
                if($_GET['category'] == "All"){
                    if($e['eventDate'] >= $_GET['date']){
                        $eventsToCome[] = $e;
                    }
                }else {
                    if($e['eventDate'] >= $_GET['date'] && $e['category'] == $_GET['category']){
                        $eventsToCome[] = $e;
                    }
                }
            } else {
                if($e['eventDate'] >= date('Y-m-d')){
                    $eventsToCome[] = $e;
                }
            }
            
        }

        // Définir le nombre d'événements par page
        $eventsPerPage = 9;

        // Calculer le nombre total de pages
        $_SESSION['totalPages'] = ceil(count($eventsToCome) / $eventsPerPage);

        // Déterminer la page actuelle
        $currentpage = isset($_SESSION['currentPage']) ? $_SESSION['currentPage'] : 1;

        // Calculer l'indice de début et de fin des événements à afficher pour la page actuelle
        $startIndex = ($currentpage - 1) * $eventsPerPage;
        $endIndex = min($startIndex + $eventsPerPage - 1, count($eventsToCome) - 1);

        // Extraire les événements à afficher pour la page actuelle
        $events = array_slice($eventsToCome, $startIndex, $endIndex - $startIndex + 1);

        $wishlistButtons = [];
        
        $userModel = new User();
        $userModel->userNumber = $_SESSION['user']['userNumber'];
        // Parcourez les événements pour déterminer quels boutons afficher
        foreach ($events as $ev) {
            $isInWishlist = $userModel->isInWishlist($ev['eventNumber']);
            // Stockez l'information pour chaque événement
            $wishlistButtons[$ev['eventNumber']] = $isInWishlist;
        }

        // Incluez les utilisateurs dans la vue
        $viewPath = __DIR__ . '/../View/Event/index.php';
        ob_start();  // Démarre la temporisation de sortie
        include $viewPath;  // Inclut la vue
        $viewContent = ob_get_clean();  // Récupère le contenu de la temporisation de sortie et l'efface

        return $viewContent;
    }

    public function nextp() {
        if($_SESSION['currentPage'] < $_SESSION['totalPages']){
            $_SESSION['currentPage']++;
        }
        header('Location: /events');
        exit;
    }

    public function prevp() {
        if($_SESSION['currentPage'] > 1){
            $_SESSION['currentPage']--;
        }
        header('Location: /events');
        exit;
    }

    public function create(){
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'){
            ob_start();
            require 'src/View/Event/create.php';
            $content = ob_get_clean();
            return $content;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
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
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'){
        $eventModel = new Event();
        $event = $eventModel->getEventById($id);

        $viewPath = __DIR__ . '/../View/Event/edit.php';
        ob_start();
        include $viewPath;
        $viewContent = ob_get_clean();

        return $viewContent;
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
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
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'){
        // Utilisez l'$id pour supprimer l'utilisateur de la base de données
        $eventModel = new Event();
        $eventModel->deleteEvent($id);
        // Redirigez l'utilisateur vers la liste des utilisateurs ou effectuez toute autre action souhaitée
        header('Location: /events');
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
    }


}