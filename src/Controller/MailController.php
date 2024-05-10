<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController
{
    
    public function getPhpMailer(): PHPMailer
    {
    // Config PHP Mailer
    $phpmailer = new PHPMailer(true);

    // Paramètres SMTP pour Gmail
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Username = 'mathis.enrici@gmail.com'; // Votre adresse e-mail Gmail
    $phpmailer->Password = 'tahl yssl wlpb bctm'; // Votre mot de passe Gmail
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Port = 587;
    
    return $phpmailer;
    }

    // Prepare l'envoie du mail
    public function sendMail($emailFrom, $nameFrom, $emailTo, $nameTo, $subject, $body)
    {
        $phpmailer = $this->getPhpMailer();
        try{
            $phpmailer->setFrom($emailFrom, $nameFrom);
            $phpmailer->addAddress($emailTo, $nameTo);
            $phpmailer->isHTML(true);
            $phpmailer->Subject = $subject;
            $phpmailer->Body = $body;

            $err = $phpmailer->send();
        } catch(Exception $e) {
            echo 'Erreur lors de l\'envoi de l\'e-mail : ', $phpmailer->ErrorInfo;
        }
        
    }
}
