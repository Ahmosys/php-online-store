<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

/**
 * Classe utilisant PHPMailer ayant pour but de gérer l'envoi de mail.
 * @package https://github.com/PHPMailer/PHPMailer
 */
class GestionEmail {

    /**
     * Méthode statique permettant d'envoyer un e-mail pour le formulaire de contact.
     * 
     * @param string $subject Sujet de l'email
     * @param string $email E-mail de l'expéditeur
     * @param string $message Message
     * @param string $recipient Destinataire de l'e-mail
     */
    public static function sendMailContact($subject, $email, $message, $recipient) {
        try {
            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";
            $mail->SMTPOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            );
            $mail->SMTPDebug = 0;
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Username = "YOUR_SMTP_EMAIL";
            $mail->Password = "YOUR_SMTP_PASSWORD";

            $mail->setFrom("administrateur-ecommerce@gmail.com", "Administrateur | E-commerce Website");
            $mail->addAddress($recipient);

            $mail->isHTML(true);
            $mail->Subject = "Subject : " . $subject;
            $mail->Body = "<b>Sender's e-mail :</b><br />" . $email . "<br /><b>Message :</b><br />$message";
            $mail->send();
        } catch (Exception $ex) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    /**
     * Méthode statique permettant d'envoyer un e-mail pour envoyer un code OTP pour réinitialize le mot de passe.
     * 
     * @param string $recipient Destinataire de l'e-mail
     * @param string $otpCode Le code OTP générer aléatoirement
     */
    public static function sendMailReset($recipient, $otpCode) {
        try {
            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";
            $mail->SMTPOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            );
            $mail->SMTPDebug = 0;
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Username = "YOUR_SMTP_EMAIL";
            $mail->Password = "YOUR_SMTP_PASSWORD";

            $mail->setFrom("administrateur-ecommerce@gmail.com", "Administrateur | E-commerce Website");
            $mail->addAddress($recipient);

            $mail->isHTML(true);
            $mail->Subject = "Password reset - E-commerce Website";
            $mail->Body = "<h1>Your OTP Code is : $otpCode</h1>";
            $mail->send();
        } catch (Exception $ex) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    /**
     * Méthode statique permettant d'envoyer un e-mail pour envoyer un code OTP pour réinitialize le mot de passe.
     * 
     * @param string $recipient Destinataire de l'e-mail
     * @param string $message Message à envoyer
     */
    public static function sendMailNewsletter($object, $message) {
        foreach (VariablesGlobales::$theUserNewsletter as $user) {
            try {
                $mail = new PHPMailer(true);
                $mail->CharSet = "UTF-8";
                $mail->SMTPOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                );
                $mail->SMTPDebug = 0;
                $mail->IsSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;
                $mail->Username = "YOUR_SMTP_EMAIL";
                $mail->Password = "YOUR_SMTP_PASSWORD";

                $mail->setFrom("administrateur-ecommerce@gmail.com", "Administrateur | E-commerce Website");
                $mail->addAddress($user->emailUtilisateur);

                $mail->isHTML(true);
                $mail->Subject = "$object";
                $mail->Body = "$message";
                $mail->send();
                
            } catch (Exception $ex) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
    }

}

?>
