<?php

class ControleurProduit {

    public function __construct() {
        
    }

    /**
     * Fonction qui permet d'afficher la page des produits.
     *
     * @return void
     */
    public function showProduct() {
        
        VariablesGlobales::$theCategories = GestionBoutique::getLesCategories();
        VariablesGlobales::$theProducts = GestionBoutique::getLesProduitsAndCategories();
        VariablesGlobales::$lastProduct = GestionBoutique::getDernierProduit(1);

        if (isset($_REQUEST['categorie'])) {
            VariablesGlobales::$theLabelsCatergory = $_REQUEST['categorie']; //Récupere le nom de la catérogie (besoin pour image & type)
            VariablesGlobales::$theProducts = GestionBoutique::getLesProduitsByCategorie(VariablesGlobales::$theLabelsCatergory); //Récupère tout les produits de la catégories
        }
        if (VariablesGlobales::$theProducts == NULL) { //Si aucun produit n'est trouvé alors
            require Chemins::VUES . 'v_error_404.inc.php'; //Affiché la page d'erreur
        } else {
            require Chemins::VUES . 'v_category.inc.php'; //Afficher les produits de la catégorie déterminé
        }
    }
    
    /**
     * Fonction permettant d'afficher la page du produit recherché.
     *
     * @return void
     */
    public function searchProduct() {
        $_SESSION['keyword'] = $_POST['recherche'];
        VariablesGlobales::$theResearchProducts = GestionBoutique::rechercherProduit($_SESSION['keyword']);
        if (VariablesGlobales::$theResearchProducts == null) {
            require Chemins::VUES . 'v_error_search.inc.php';
        }
        else {
            require Chemins::VUES . 'v_product_search.inc.php';
        }
    }
    
    /**
     * Fonction permettant d'ajouter un produit aux favoris de l'utilisateur.
     *
     * @return void
     */
    public function addProductToListFavorite() {
        if(!isset($_SESSION['login_username'])) {
            require Chemins::VUES . 'v_login.inc.php';
        } else {
            if (GestionBoutique::checkProductFavorite($_SESSION['id_user'], $_REQUEST['idProduct'])) {
                GestionBoutique::removeProductToFavorite($_SESSION['id_user'], $_REQUEST['idProduct']);
                header(Utils::getPreviousURI());
            } else {
                GestionBoutique::addProductToFavorite($_SESSION['id_user'], $_REQUEST['idProduct']);
                header(Utils::getPreviousURI());
            }         
        }
    }
    
}

?>