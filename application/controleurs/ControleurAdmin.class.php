<?php

class ControleurAdmin {

    public function __construct() {
        
    }

    /**
     * Fonction qui permet d'afficher la page d'administration.
     *
     * @return void
     */
    public function showIndexAdmin() {
        if (!isset($_SESSION['is_admin'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        }
        else {
            VariablesGlobales::$theTables = GestionBoutique::getNomTables();
            require Chemins::VUES_ADMIN . 'v_index_admin.inc.php';
        }
    }
    
    /**
     * Fonction qui permet d'afficher la page d'envoi newsletters.
     *
     * @return void
     */
    public function showNewsletter() {
        if (!isset($_SESSION['is_admin'])) {
            require Chemins::VUES . 'v_error_403.inc.php';
        }
        else {
            VariablesGlobales::$theTables = GestionBoutique::getNomTables();
            require Chemins::VUES_ADMIN . 'v_newsletter.inc.php';
        }
    }
    
    /**
     * Fonction permettant d'envoyer le message à la liste des abonnées de la newsletter.
     *
     * @return void
     */
    public function sendMessageNewsletter() {
        VariablesGlobales::$theUserNewsletter = GestionBoutique::getUtilisateurNewsletter();
        GestionEmail::sendMailNewsletter($_POST['email_object'], $_POST['email_message']);
        VariablesGlobales::$theSuccesses['send_email_succes'] = "Your message has been sent to all users subscribed to the newsletter.";
        require Chemins::VUES_ADMIN . 'v_newsletter.inc.php';
    }
    
    /**
     * Fonction qui permet d'afficher la page de la table désignée.
     *
     * @return void
     */
    public function showFromTable() {
        VariablesGlobales::$theFields = GestionBoutique::getNomChampsByTable($_REQUEST['tableName']);
        VariablesGlobales::$theOccurrences = GestionBoutique::getLesTuplesByTable($_REQUEST['tableName']);
        require Chemins::VUES_ADMIN . 'v_show_table.inc.php';
    }
    
    /**
     * Fonction qui permet d'afficher la page de suppression de la table désignée.
     * 
     * @return void
     */
    public function deleteFromTable() {
        VariablesGlobales::$theFields = GestionBoutique::getNomChampsByTable($_REQUEST['tableName']);
        VariablesGlobales::$theOccurrences = GestionBoutique::getLesTuplesByTable($_REQUEST['tableName']);
        VariablesGlobales::$theFieldsPrimaryKey = GestionBoutique::getNomAttributsClePrimaire($_REQUEST['tableName']);
        require Chemins::VUES_ADMIN . 'v_delete_table.inc.php';
    }
    
    /**
     * Fonction qui permet d'afficher la page d'ajout de la table désignée.
     *
     * @return void
     */
    public function addFromTable() {
        VariablesGlobales::$theFields = GestionBoutique::getNomChampsByTable($_REQUEST['tableName']);
        VariablesGlobales::$theOccurrences = GestionBoutique::getLesTuplesByTable($_REQUEST['tableName']);
        VariablesGlobales::$theFieldsPrimaryKey = GestionBoutique::getNomAttributsClePrimaire($_REQUEST['tableName']);
        require Chemins::VUES_ADMIN . 'v_add_table.inc.php';
    }
    
    /**
     * Fonction qui permet de supprimer une occurrence de la table désignée.
     * 
     * @return void
     */
    public function deleteOccurence() {
        GestionBoutique::deleteByTable($_POST['choicePrimaryKey'], $_SESSION['tableName'], $_SESSION['theFieldPrimaryKey']);
        header(Utils::getPreviousURI());
    }
    
    /**
     * Fonction qui permet d'ajouter une occurrence de la table désignée.
     *
     * @return void
     */
    public function addOccurence() {
        $lesValeurs = "";
        for ($i = 0; $i < GestionBoutique::getNbColumnByTable(MysqlConfig::BASE, $_SESSION['tableName']); $i++) {
            if (is_string($_POST['attribut' . $i])) {
                $lesValeurs .= "'" .$_POST['attribut' . $i] . "',";
            } else {
                $lesValeurs .= $_POST['attribut' . $i] . ",";
            }
        }
        $lesValeurs .= "$";
        $lesValeurs = str_replace(",$", "" , $lesValeurs);
            GestionBoutique::addByTable($_SESSION['tableName'], $lesValeurs);  
            header(Utils::getPreviousURI());
    }
}

?>