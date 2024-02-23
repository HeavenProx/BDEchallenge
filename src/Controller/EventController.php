<?php

namespace App\Controller;

use App\Model\Event;
use App\Model\User;
use DateTime;

class EventController
{
    public function index()
    {
        if($_SESSION['currentPage'] > 1 && isset($_GET['btn']) && $_GET['btn'] == "prev"){
            $_SESSION['currentPage']--;
        }

        if($_SESSION['currentPage'] < $_SESSION['totalPages'] && isset($_GET['btn']) && $_GET['btn'] == "next"){
            $_SESSION['currentPage']++;
        }

        $event = new Event();
        $allEvents = $event->getAllEvents();
        usort($allEvents, function($a, $b) {
            return strtotime($a['eventDate']) - strtotime($b['eventDate']);
        });

        // Filtre les elements suivant les categories et la date
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

        $currentpage = isset($_SESSION['currentPage']) ? $_SESSION['currentPage'] : 1;
        
        // Calculer l'indice de début et de fin des événements à afficher pour la page actuelle
        $startIndex = ($currentpage - 1) * $eventsPerPage;
        $endIndex = min($startIndex + $eventsPerPage - 1, count($eventsToCome) - 1);

        // Extraire les événements à afficher pour la page actuelle
        $events = array_slice($eventsToCome, $startIndex, $endIndex - $startIndex + 1);

        $wishlistButtons = [];
        $eventParticipants = [];

        $userModel = new User();
        if ($_SESSION['logged'] == true) {
            $userModel->userNumber = $_SESSION['user']['userNumber'];
        }

        // Parcourir les événements pour déterminer quels boutons afficher
        foreach ($events as $ev) {
            $participants = $event->getParticipants($ev['eventNumber']);
            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && $_SESSION['user']['validated'] == 1){
                $isParticipant = in_array($_SESSION['user']['userNumber'], $participants);
                $isInWishlist = $userModel->isInWishlist($ev['eventNumber']);
                // Stockez l'information pour chaque événement
                $wishlistButtons[$ev['eventNumber']] = $isInWishlist;
                $eventParticipants[$ev['eventNumber']] = $isParticipant;
            }
        }

        // Envoyer a la page des events
        $viewPath = __DIR__ . '/../View/Event/index.php';
        ob_start();  
        include $viewPath; 
        $viewContent = ob_get_clean();  

        return $viewContent;
    }

    // Passer a la prochaine page 
    public function nextp() {
        if($_SESSION['currentPage'] < $_SESSION['totalPages']){
            $_SESSION['currentPage']++;
        }
        header('Location: /events');
        exit;
    }

    // Passer a la page d'avant
    public function prevp() {
        if($_SESSION['currentPage'] > 1){
            $_SESSION['currentPage']--;
        }
        header('Location: /events');
        exit;
    }

    // Acceder a la page des events
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

    // Preparer l'envoie de la requete pour creer un evenement
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $name = $_POST['name'] ?? '';           
            $category = $_POST['category'] ?? '';
            $eventDate = $_POST['eventDate'] ?? '';
            $location = $_POST['location'] ?? '';
            $description = $_POST['description'] ?? '';

            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && $_SESSION['user']['validated'] == 1){
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

    // Acceder a la page de modification des evenements
    public function edit($id)
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'){

        // Recupere l'id de l'evenement selectionne
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

    // Prepare la requete pour mettre a jour un evenement
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

    // Prepare la requete pour supprimer un evenement
    public function delete($id)
    {
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'){

        // Utilisez l'$id pour supprimer l'utilisateur de la base de données
        $eventModel = new Event();
        $eventModel->deleteEvent($id);

        // Redirigez l'utilisateur vers la liste des evenements
        header('Location: /events');
        } else{
            $_SESSION['error'] = "Vous ne pouvez pas accedé à cette page";
            header('Location: /');
        }
    }

    // Gere l'ajout ou la suppression d'un participation en fonction de l'action
    private function handleParticipantAction($id, $action)
{
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true && $_SESSION['user']['validated'] == 1) {
        $eventModel = new Event();

        // Assurez-vous que l'utilisateur est connecté et que userNumber est disponible
        if (isset($_SESSION['user']['userNumber'])) {
            $eventModel->userNumber = $_SESSION['user']['userNumber']; // Assurez-vous d'ajuster la clé en fonction de votre structure de session
        } else {
            // Gérez le cas où userNumber n'est pas disponible
            // Vous pouvez rediriger l'utilisateur vers une page d'erreur par exemple
            header('Location: /home');
            exit;
        }

        switch ($action) {
            case 'add':
                $eventModel->addParticipant($id);
                    //envoi du mail
                    $eventModel = new Event();
                    $e = $eventModel->getEventById($id);
                    $userModel = new User();
                    $user = $userModel->getUserById($_SESSION['user']['userNumber']);
                    $mailer = new MailController();
                    $mailer->sendMail('mathis.enrici@gmail.com', 'BEEDE', $user['email'], $user['firstName'] . ' ' . $user['lastName'], 'Inscription evenement', 'Bonjour votre inscription a ' . $e['name'] . ' est confirmee');

                break;
            case 'remove':
                $eventModel->deleteParticipant($id);
                break;
            default:
                // Gérer une action non valide
                break;
        }

            // Redirigez l'utilisateur ou effectuez toute autre action souhaitée
            header('Location: /events');
            exit;
        } else {
            // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
            header('Location: /login');
            exit;
        }
    }

    // Ordonne l'ajout du participant
    public function addParticipant($id)
    {
        $this->handleParticipantAction($id, 'add');
    }

    // Ordonne la suppression du participant
    public function removeParticipant($id)
    {
        $this->handleParticipantAction($id, 'remove');
    }

    public function notifDaily()
    {
        $this->notifParticipants();
        $this->notifCreator();
        return "ok";
    }

    // Envoie un mail au participant 1 jour avant l'evenement
    public function notifParticipants(){
        $event = new Event();
        $allEvents = $event->getAllEvents();

        foreach ($allEvents as $e) {
            $date_demain = new DateTime('tomorrow');
            $date_a_verifier = $e['eventDate'];
            $date_a_verifier = new DateTime($date_a_verifier);

            // Verifie la date et envoie les mails
            if($date_demain->diff($date_a_verifier)->days == 0){
                $participantsId = $event->getParticipants($e['eventNumber']);
                foreach ($participantsId as $p) {
                    $user = new User();
                    $participant = $user->getUserById($p);
                    $mailer = new MailController();
                    $mailer->sendMail('mathis.enrici@gmail.com', 'BEEDE', $participant['email'], $participant['firstName'] . ' ' . $participant['lastName'], 'Evenement demain', 'Bonjour votre evenement ' . $e['name'] . ' est demain');
    
                }
            }
                
        }
    }

    // Envoie un mail au createur de l'evenement
    public function notifCreator(){
        $event = new Event();
        $allEvents = $event->getAllEvents();

        // Envoie un mail au createur si il n'y a personne d'inscrit 5 jours avant
        foreach ($allEvents as $e) {
            $date_5 = new DateTime('+4 day');
            $date_a_verifier = $e['eventDate'];
            $date_a_verifier = new DateTime($date_a_verifier);
            $nbParticipants = $event->getParticipants($e['eventNumber']);
            if($date_5->diff($date_a_verifier)->days == 0 && $nbParticipants == []){
                $user = new User();
                $participantId = $e['userNumber'];
                $participant = $user->getUserById($participantId);
                $mailer = new MailController();
                $mailer->sendMail('mathis.enrici@gmail.com', 'BEEDE', $participant['email'], $participant['firstName'] . ' ' . $participant['lastName'], 'Votre evenement', 'Bonjour votre evenement ' . $e['name'] . ' n\'a pas de participants et il est dans 5 jours');
            }
                
        }
    }


    // Affiche la page de detail d'un evenement
    public function details($id){

        // Affiche la page de details en fonction de l'user
        $eventModel = new Event();
        $event = $eventModel->getEventById($id);

        $viewPath = __DIR__ . '/../View/Event/details.php';
        ob_start();
        include $viewPath;
        $viewContent = ob_get_clean();
        return $viewContent;
    }
}