<?php

/**
 * Classe statique permettant de gérer les paniers.
 */
class GestionPanier {

    /**
     * Fonction statique permettant d'initialiser le tableau panier.
     */
    public static function initialize() {
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = array();           
        } 
    }
    
    /**
     * Fonction statique permettant de vider le tableau des produits du panier.
     *
     * @return void
     */
    // public static function empty() {
    //     $_SESSION['products'] = array();
    // }

    /**
     * Fonction statique permettant de détruire le tableau des produits du panier.
     *
     * @return void
     */
    public static function destroy() {
        unset($_SESSION['products']);
    }    

    /**
     * Fonction statique permettant d'ajouter un produit au tableau des produits du panier.
     * 
     * @param int $idProduct Identifiant du produit
     * @param string $qty Quantité du produit
     * @return void
     */
    public static function addProduct($idProduct,$qty) {
        if (self::contains($idProduct)) {
            $_SESSION['products'][$idProduct]+= $qty;
        }
        else {
            $_SESSION['products'][$idProduct] = $qty;        
        }
    }

    /**
     * Fonction statique permettant de modifier la quantité d'un produit du tableau des produits du panier.
     * 
     * @param int $idProduct Identifiant du produit
     * @param string $qty Quantité du produit
     * @return void
     */
    public static function editQtyProduct($idProduct,$qty) {
       if (array_key_exists($idProduct, self::getProducts()))
            $_SESSION['products'][$idProduct] = $qty;
    }
    
    /**
     * Fonction statique permettant de supprimer un produit du tableau des produits du panier.
     * 
     * @param int $idProduct Identifiant du produit
     * @return void
     */
    public static function deleteProduct($idProduct) {
        if (array_key_exists($idProduct, self::getProducts()))
            unset ($_SESSION['products'][$idProduct]);
    }        

    /**
     * Fonction statique permettant de retourner le tableau des produits du panier.
     * @return array Tableau des produits du panier
     */
    public static function getProducts() {
        return $_SESSION['products'];
    }
    
    /**
     * Fonction statique permettant de retourner le nombre de produits du tableau des produits du panier.
     *
     * @return int Nombre de produits
     */
    public static function getNbProducts() {
        return isset($_SESSION['products']) ? count($_SESSION['products']) : 0;
    }

    /**
     * Fonction statique permettant de retourne la quantité d'un produit du tableau des produits du panier.
     *
     * @param int $idProduct Identifiant du produit
     * @return int Quantité du produit
     */
    public static function getQtyByProduct($idProduct) {
        return array_key_exists($idProduct, self::getProducts()) ? $_SESSION['products'][$idProduct] : 0;
    }
    
    /**
     * Fonction statique permettant de retourner un boolean indiquant si le tableau des produits du panier est vide.
     *
     * @return boolean
     */
    public static function isEmpty() {
        return (self::getNbProducts() == 0);
    }

    /**
     * Fonction statique permettant de retourner un boolean indiquant si un produit est dans le tableau des produits du panier.
     * @return boolean
     */
    public static function contains($idProduct) {
        return (array_key_exists($idProduct, self::getProducts()));
    }
   
}

?>
