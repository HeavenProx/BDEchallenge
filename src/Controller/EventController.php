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
        $eventParticipants = [];

        $userModel = new User();
        if($_SESSION['logged'] == true){
            $userModel->userNumber = $_SESSION['user']['userNumber'];
        }
        // Parcourez les événements pour déterminer quels boutons afficher
        foreach ($events as $ev) {
            $participants = $event->getParticipants($ev['eventNumber']);
            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                $isParticipant = in_array($_SESSION['user']['userNumber'], $participants);
                $isInWishlist = $userModel->isInWishlist($ev['eventNumber']);
                // Stockez l'information pour chaque événement
                $wishlistButtons[$ev['eventNumber']] = $isInWishlist;
                $eventParticipants[$ev['eventNumber']] = $isParticipant;
            }
            

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

    private function handleParticipantAction($id, $action)
{
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
        $eventModel = new Event();

        // Assurez-vous que l'utilisateur est connecté et que userNumber est disponible
        if (isset($_SESSION['user']['userNumber'])) {
            $eventModel->userNumber = $_SESSION['user']['userNumber']; // Assurez-vous d'ajuster la clé en fonction de votre structure de session
        } else {
            // Gérez le cas où userNumber n'est pas disponible
            // Vous pouvez rediriger l'utilisateur vers une page d'erreur par exemple
            header('Location: /error');
            exit;
        }

        switch ($action) {
            case 'add':
                $eventModel->addParticipant($id);
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

    public function addParticipant($id)
    {
        $this->handleParticipantAction($id, 'add');
    }

    public function removeParticipant($id)
    {
        $this->handleParticipantAction($id, 'remove');
    }

    public function notifDaily()
    {
        $file = '../Mail/test_last_exec.txt';
        if(file_exists($file) && time() - filemtime($file) >= 1){
            $this->notifParticipants();
            $this->notifCreator();

            file_put_contents($file, time());
        }
    }

    public function notifParticipants(){
        $event = new Event();
        $allEvents = $event->getAllEvents();

        foreach ($allEvents as $e) {
            $date_demain = new DateTime('tomorrow');
            $date_a_verifier = $e['eventDate'];
            $date_a_verifier = new DateTime($date_a_verifier);

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

    public function notifCreator(){
        $event = new Event();
        $allEvents = $event->getAllEvents();

        foreach ($allEvents as $e) {
            $date_5 = new DateTime('+4 day');
            $date_a_verifier = $e['eventDate'];
            $date_a_verifier = new DateTime($date_a_verifier);
            $nbParticipants = $event->getParticipants($e['eventNumber']);
            //var_dump($e['name']);
            //var_dump($date_5->diff($date_a_verifier)->days == 0);
            //var_dump($date_5->diff($date_a_verifier)->days);
            if($date_5->diff($date_a_verifier)->days == 0 && $nbParticipants == []){
                $user = new User();
                $participantId = $e['userNumber'];
                $participant = $user->getUserById($participantId);
                $mailer = new MailController();
                $mailer->sendMail('mathis.enrici@gmail.com', 'BEEDE', $participant['email'], $participant['firstName'] . ' ' . $participant['lastName'], 'Votre evenement', 'Bonjour votre evenement ' . $e['name'] . ' n\'a pas de participants et il est dans 5 jours');
            }
                
        }
    }

}