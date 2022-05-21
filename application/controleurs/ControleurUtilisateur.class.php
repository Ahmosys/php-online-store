<?php

class ControleurUtilisateur {
            
    public function __construct() {
        
    }

    public function showTest() {
        require Chemins::VUES . 'v_test.inc.php';
    }
    
    /**
     * Fonction qui permet d'afficher la page du compte utilisateur.
     *
     * @return void
     */
    public function showIndexUser() {
        if (!isset($_SESSION['login_username'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        }
        else {
            VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
            require Chemins::VUES_UTILISATEUR . 'v_index_user.inc.php';
        }
    }
    
    /**
     * Fonction qui permet d'afficher la page de modification du compte utilisateur.
     *
     * @return void
     */
    public function showEditUser() {
        if (!isset($_SESSION['login_username'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        } else {
        VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
        require Chemins::VUES_UTILISATEUR . 'v_edit_user.inc.php';
        }
    }
    
    /**
     * Fonction permettant d'afficher la page des produits favoris de l'utilisateur.
     *
     * @return void
     */
    public function showFavoriteProductUser() {
        if (!isset($_SESSION['login_username'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        } else {
        VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
        VariablesGlobales::$theFavoriteProductsUser = GestionBoutique::getFavoriteProductsUtilisateur($_SESSION['id_user']);
        require Chemins::VUES_UTILISATEUR . 'v_favorite_product_user.inc.php';
        }
    }
    
    /**
     * Fonction permettant d'afficher la page du contenue de la commandes désigné.
     *
     * @return void
     */
    public function showOrderContent(){
        if (!isset($_SESSION['login_username'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        } else {
            VariablesGlobales::$theOrderContent = GestionBoutique::getOrderContentByOder($_REQUEST['idOrder']);
            VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
            require Chemins::VUES_UTILISATEUR . 'v_order_content_user.inc.php';
        }
    }
    
    /**
     * Fonction permettant d'afficher la page des commandes de l'utilisateur.
     *
     * @return void
     */
    public static function showOrderHistoryUser() {
        if (!isset($_SESSION['login_username'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        } else {
        VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
        VariablesGlobales::$theOrderUser = GestionBoutique::getOrdersUtilisateur($_SESSION['id_user']);
        VariablesGlobales::$theFields = GestionBoutique::getNomChampsByTable("commande");
        require Chemins::VUES_UTILISATEUR . 'v_order_history_user.inc.php';
        }
    }

    /**
     * Fonction permettant de supprimer le compte de l'utilisateur.
     *
     * @return void
     */
    public function deleteUser() {
        VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
        GestionBoutique::deleteByTable($_SESSION['id_user'], "utilisateur", "idUtilisateur");
        $_SESSION = array(); //Initialise le tableau de session vide donc à 0
        session_destroy(); //Destruction de la session en cours
        setcookie('login_username', ''); //Supression du cookie login_admin en supprimant sont contenue.
        setcookie('is_admin', '');
        header("Location:index.php"); //Redirige vers l'index
    }
    
    /**
     * Fonction permettant de modifier les information du compte de l'utilisateur.
     *
     * @return void
     */
    public function editUser() {
       GestionBoutique::updateUser($_SESSION['id_user'], $_POST['edit_last_name'], $_POST['edit_name'], $_POST['edit_username'], $_POST['edit_email'], $_POST['edit_phone_number'], $_POST['edit_address'], $_POST['edit_zip_code'], $_POST['edit_city']);
       header(Utils::getPreviousURI());
    }
}

?>