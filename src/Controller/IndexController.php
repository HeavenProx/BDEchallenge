<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Event;

class IndexController
{
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
                // if (count($eventsToCome) == 3) {
                //     break;  // Arrêter la boucle après avoir ajouté les trois premiers événements.
                // }
            }
        }

        $events = $eventsToCome;

        ob_start();
        require 'src/View/Home/index.php';
        $content = ob_get_clean();
        return $content;
    }

    public function contact(): string
    {
        ob_start();
        require 'src/View/Contact/index.php';
        $content = ob_get_clean();
        return $content;
    }

    public function send() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire d'inscription
            $objet = $_POST['objet'] ?? '';
            $message = $_POST['message'] ?? '';

            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                
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
                //$id = $userModel->getUserId($_POST['email']);
                
                //Send a mail
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
