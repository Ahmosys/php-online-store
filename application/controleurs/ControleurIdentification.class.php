<?php

class ControleurIdentification {

    public function __construct() {
        
    }

    /**
     * Fonction qui permet d'afficher la page de connexion.
     *
     * @return void
     */
    public function showLogin() {
        require Chemins::VUES . 'v_login.inc.php';
    }
    
    /**
     * Fonction qui permet d'afficher la page pour s'enregistrer.
     *
     * @return void
     */
    public function showRegister() {
        require Chemins::VUES . 'v_register.inc.php';
    }
    
    /**
     * Fonction qui permet d'afficher la page de mot de passe oublié.
     *
     * @return void
     */
    public function showForgotPassword() {
        require Chemins::VUES . 'v_forgot_password.inc.php';
    }
    
    /**
     * Fonction permettant de vérifier la connexion.
     *
     * @return void
     */
    public function checkConnection() {
        if (GestionBoutique::isRegistered($_POST['login_username'], $_POST['login_password'])) //Si la méthode retourne "true"
        {
            $_SESSION['login_username'] = $_POST['login_username'];
            $_SESSION['id_user'] = GestionBoutique::getUtilisateurId($_SESSION['login_username']);

            if (isset($_POST['remember']))
            {
                setcookie('login_username', $_SESSION['login_username'], time() + 7*24*3600, null, null, false, true); // Le cookie sera sauvegader une semaine
                
            }
            if (GestionBoutique::isAdminOK($_POST['login_username'], $_POST['login_password'])) {
                $_SESSION['is_admin'] = "yes";
                if (isset($_POST['remember'])) {
                    setcookie('is_admin', $_SESSION['is_admin'], time() + 7*24*3600, null, null, false, true);
                }
                header("Location:index.php");
            }
            else {
                header("Location:index.php");
                // require Chemins::VUES_UTILISATEUR . 'v_index_utilisateur.inc.php';
            }
        }
        else
        {
            VariablesGlobales::$theErrors['wrong_password'] = "Password or username are not valid !";
            require Chemins::VUES . 'v_login.inc.php';
        }
    }
    
    /**
     * Fonction permettant de vérifier la validité de l'OTP code saisie.
     *
     * @return void
     */
    public function checkOtpCode() {
        if (GestionBoutique::checkOtpCode($_SESSION['forgot_email'], $_POST['check_otp_code'])) {
            require Chemins::VUES . 'v_reset_password.inc.php';
        } else {
            VariablesGlobales::$theErrors['wrong_otp_code'] = "The OTP Code entered is not valid.";
            require Chemins::VUES . 'v_check_otp.inc.php';
        }
    }
    
    /**
     * Fonction permettant la déconnexion.
     *
     * @return void
     */
    public function logOff() {
        // Supression des variables de session et de la session
        $_SESSION = array(); //Initialise le tableau de session vide donc à 0
        session_destroy(); //Destruction de la session en cours
        setcookie('login_username', ''); //Supression du cookie login_admin en supprimant sont contenue.
        setcookie('is_admin', '');
        header("Location:index.php"); //Redirige vers l'index
    }
    
    /**
     * Fonction permettant l'enregistrement d'un nouvel utilisateur.
     *
     * @return void
     */
    public function registerUser() {
        if (GestionCaptcha::verifyCaptcha()) {
            if (isset($_POST['checkbox_newsletter'])) {
                GestionBoutique::insertUtilisateur($_POST['register_username'], $_POST['register_password'], $_POST['register_last_name'], $_POST['register_name'], $_POST['register_email'], $_POST['register_phone_number'], $_POST['register_address'], $_POST['register_zip_code'], $_POST['register_city'], 1);
            } else {
                GestionBoutique::insertUtilisateur($_POST['register_username'], $_POST['register_password'], $_POST['register_last_name'], $_POST['register_name'], $_POST['register_email'], $_POST['register_phone_number'], $_POST['register_address'], $_POST['register_zip_code'], $_POST['register_city'], 0);
            }
            require Chemins::VUES.'v_register_succes.inc.php';
            //VariablesGlobales::$theSuccesses['register_succes'] = "You have been registered, you can now log in to the site.";
        } else {
            VariablesGlobales::$theErrors['hcaptcha_fail'] =  "Robot verification failed, please try again.";
            require Chemins::VUES . 'v_register.inc.php';
        }
    }
    
    /**
     * Fonction permettant la réinitialisation du mot de passe.
     *
     * @return void
     */
    public function resetPassword() {
        if($_POST['reset_password'] == $_POST['reset_password_confirm']) {
            GestionBoutique::updatePasswordUtilisateur($_SESSION['forgot_email'], $_POST['reset_password']);
            VariablesGlobales::$theSuccesses['succes_reset_password'] = "Your password has been changed.";
            require Chemins::VUES . 'v_reset_password.inc.php';
            GestionBoutique::updateOtpCodeUtilisateur(0, $_SESSION['forgot_email']);
        }
        else {
            VariablesGlobales::$theErrors['wrong_password'] = "The two passwords are not the same please check.";
            require Chemins::VUES . 'v_reset_password.inc.php';
        }
    }
    
    /**
     * Fonction permettant de demander la réinitialisation du mot de passe.
     *
     * @return void
     */
    public function forgotPassword() {
        if(GestionBoutique::emailExist($_POST['forgot_email'])) {
            $_SESSION['forgot_email'] = $_POST['forgot_email'];
            $otpCode = rand(999999, 111111);
            GestionEmail::sendMailReset($_POST['forgot_email'], $otpCode);
            GestionBoutique::updateOtpCodeUtilisateur($otpCode, $_POST['forgot_email']);
            require Chemins::VUES . 'v_check_otp.inc.php';
            }
        else {
            VariablesGlobales::$theErrors['wrong_email'] = "The email you entered does not match to any account.";
            require Chemins::VUES . 'v_forgot_password.inc.php';
        }
    }
    
}

?>