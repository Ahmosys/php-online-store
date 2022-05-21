<?php

class ControleurContact {

    public function __construct() {
        
    }

    /**
     * Fonction qui permet d'afficher la page de contact.
     *
     * @return void
     */
    public function showContact() {
         require Chemins::VUES . 'v_contact.inc.php';
    }
    
    /**
     * Fonction qui permet d'envoyer un message à partir du formulaire de contact.
     *
     * @return void
     */
    public function sendMessageFromForm() {
        if (($_POST['h-captcha-response']) == null) {
            VariablesGlobales::$theErrors['hcaptcha_not_solved_fail'] =  "Robot verification failed, please solve the captcha.";
        }
        else {
            if (GestionCaptcha::verifyCaptcha()) {
                GestionEmail::sendMailContact($_POST['contact_name'], $_POST['contact_email'] , $_POST['contact_message'], "hugo.robin34500@gmail.com");
                VariablesGlobales::$theSuccesses['send_email_succes'] = "Your message has been sent, usually you will get an answer within 24 hours.";
            } else {
                VariablesGlobales::$theErrors['hcaptcha_fail'] =  "Robot verification failed, please try again.";
            }
        }
        require Chemins::VUES . 'v_contact.inc.php';
    }
    
    
}

?>