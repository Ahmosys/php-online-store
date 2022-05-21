<?php

class ControleurPanier {
    
    public function __construct() {
        
    }
    
    /**
     * Fonction qui permet d'afficher la page de panier.
     *
     * @return void
     */
    public function showCart() {
        if (GestionPanier::isEmpty()) {
            require Chemins::VUES . 'v_error_cart_empty.inc.php';
        } else {
            require Chemins::VUES . 'v_cart.inc.php';
        }
    }

    /**
     * Fonction qui permet d'afficher la page de validation.
     *
     * @return void
     */
    public function showCheckout() {
        if (GestionPanier::isEmpty()) {
            require Chemins::VUES . 'v_error_cart_empty.inc.php';
        } else {
            if (!isset($_SESSION['login_username'])) {
                require Chemins::VUES . 'v_login.inc.php';
            } else {
                VariablesGlobales::$theUser = GestionBoutique::getDetailsUtilisateur($_SESSION['login_username']);
                require Chemins::VUES . 'v_checkout.inc.php';
            }
            
        }
    }
    
    /**
     * Fonction qui permet d'ajouter un article au panier.
     *
     * @return void
     */
    public function addToCart() {
        GestionPanier::addProduct($_REQUEST['idProduct'], 1);
        header(Utils::getPreviousURI());
    }
    
    /**
     * Fonction qui permet de supprimer un article du panier.
     *
     * @return void
     */
    public function removeFromCart() {
        GestionPanier::deleteProduct($_REQUEST['idProduct']);
        header(Utils::getPreviousURI());
    }
    
    /**
     * Fonction qui permet de décrémenté la quantité d'un article du panier.
     *
     * @return void
     */
    public function decrementedQuantity() {
        if (GestionPanier::getQtyByProduct($_REQUEST['idProduct']) == 1) {
            GestionPanier::deleteProduct($_REQUEST['idProduct']);
            if (GestionPanier::isEmpty()) {
                require Chemins::VUES . 'v_error_cart_empty.inc.php';
            } else {
                header(Utils::getPreviousURI());
            }
        } else {
        GestionPanier::editQtyProduct($_REQUEST['idProduct'], ((int)$_REQUEST['qteProduct'] - 1));
        header(Utils::getPreviousURI());
        }
    }
    
    /**
     * Fonction qui permet d'incrémenter la quantité d'un article du panier.
     *
     * @return void
     */
    public function incrementedQuantity() {
        GestionPanier::editQtyProduct($_REQUEST['idProduct'], ((int)$_REQUEST['qteProduct'] + 1));
        header(Utils::getPreviousURI());
    }

    /**
     * Fonction qui permet de vérifier le code promotion entré par l'utilisateur.
     *
     * @return void
     */
    public function checkPromotionCode() {
        if(GestionBoutique::checkPromotionCode($_POST["promo_code_checkout"])) {
            $_SESSION["promo_code"] = GestionBoutique::getPromotionCodeById($_POST["promo_code_checkout"]);
        } else {
            unset($_SESSION["promo_code"]);
        }
        header(Utils::getPreviousURI());
    }
}

?>