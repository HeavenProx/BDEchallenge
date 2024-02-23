<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Event;

class IndexController
{
    // Charge la page Home qui est la page d'accueil    
    // Permet de charger les 3 évènements les plus récents pour la partie "Nos évènements"
    public function home(): string
    {   
        $event = new Event();
        $allEvents = $event->getAllEvents();

        $eventsToCome = [];
        $eventCount = 0;
        $i = 0;

        // Trier le tableau par la date
        usort($allEvents, function($a, $b) {
            return strtotime($a['eventDate']) - strtotime($b['eventDate']);
        });

        // Garder seulement les 3 premiers
        foreach ($allEvents as $e) {
            if (strtotime($e['eventDate']) >= strtotime(date('Y-m-d'))) {
                $eventsToCome[] = $e;
                if (count($eventsToCome) == 3) {
                    break;  // Arrêter la boucle après avoir ajouté les trois premiers événements.
                }
            }
        }
        $events = $eventsToCome;

        // Affiche la page Home
        ob_start();
        require 'src/View/Home/index.php';
        $content = ob_get_clean();
        return $content;
    }

    // Affiche la page contact
    public function contact(): string
    {
        // Afficher la page et le formulaire de contact
        ob_start();
        require 'src/View/Contact/index.php';
        $content = ob_get_clean();
        return $content;
    }

    // Permet d'envoyer un mail avec le mail utilisateur au mail de Mathis 
    public function send() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $objet = $_POST['objet'] ?? '';
            $message = $_POST['message'] ?? '';

            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                
                // Construction du mail
                $content = '
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>' . $objet . '</title>
                    </head>
                    <body>
                        <h1>' . $objet . '</h1>
                        <p>Nouveau message de ' . $_SESSION['user']['lastName'] . ' ' . $_SESSION['user']['firstName'] . ' :</p>
                        <p>' . $message . '</p>
                    </body>
                    </html>
                ';
                
                // Envoyer le mail à Mathis grâce aux bonnes informations de l'utilisateur
                $mailController = new MailController();
                $mailController->sendMail($_SESSION['user']['email'], $_SESSION['user']['lastName'] . $_SESSION['user']['firstName'], 'mathis.enrici@gmail.com', 'BEEDE', $objet, $content);

                header('Location: /');
                exit;
            } else{
                $_SESSION['error'] = "Vous n'êtes pas connecté";
                header('Location: /contact');
            }
        }
    }
}
