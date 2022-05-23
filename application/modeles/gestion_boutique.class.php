<?php

require_once 'modelePDO.class.php';

class GestionBoutique extends ModelePDO {
      
    
    // <editor-fold defaultstate="collapsed" desc="Méthodes/Fonctions statiques - catégorie">
    
    /**
    * Ajoute un tuple dans la table catégorie.
    * @param int $idCategorie id de la catégorie.
    * @param string $libelleCategorie libellé de la catégorie.
    */
   public static function ajouterCategorie($idCategorie, $libelleCategorie) {
       self::seConnecter();
       self::$requete = "INSERT INTO categorie VALUES(:idCategorie, :LibelleCategorie)";
       self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
       self::$pdoStResults->bindValue('idCategorie', $idCategorie);
       self::$pdoStResults->bindValue('LibelleCategorie', $libelleCategorie);
       self::$pdoStResults->execute();
   }
   
    /**
    * Retourne les occurences de la table catégorie.
    */
    public static function getLesCategories() {
        return self::getLesTuplesByTable("categorie");
    }
    
    /**
     * Retourne les occurences des produits selon la catégorie choisi.
     * @param string $libelleCategorie libellé de la catégorie ciblés.
     * @return object Occurences des produits de la catégorie.
     */
    public static function getLesProduitsByCategorie($libelleCategorie) {
        self::seConnecter();
        self::$requete = "SELECT * FROM produit P, categorie C WHERE P.idCat = C.idCategorie AND C.libelleCategorie = :libelleCategorie";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue('libelleCategorie', $libelleCategorie);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Méthodes/Fonctions statiques - produits">
 
    /**
    * Retourne les occurences de la table produit.
    * @return object Occurences des produits de la table produit.
    */
    public static function getLesProduits() {
        return self::getLesTuplesByTable("produit");
    }
    
    /**
    * @param int $idProduit l'id du produit.
    * Retourne l'occurence de la table produit selon l'id désiré.
    * @return object Occurence du produit.
    */
    public static function getProduitById($idProduit) {
        self::seConnecter();
        self::$requete = "SELECT * FROM produit P, categorie C where P.idCat = C.idCategorie
                          AND P.idProduit = :idProduit";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue('idProduit', $idProduit);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
    
    /**
    * Retourne la liste des produits ainsi que la catégorie qu'il lui ai associé.
    * @return object Occurences des produits de la catégorie. 
    */
    public static function getLesProduitsAndCategories() {
        return self::requeteSelect("*", "produit, categorie", "(produit.idCat = categorie.idCategorie)");
    }

    /*
    * @param int $nbTuples le nombre d'occurence désirer.
    * Retourne la/les dernière occurence de la table produit.
    * @return object Occurences des derniers produits. 
    */
    public static function getDernierProduit($nbTuples) {
        return self::requeteSelect("*", "produit, categorie", "(produit.idCat = categorie.idCategorie) ORDER BY idProduit DESC LIMIT $nbTuples");
    }
    
    
    /*
    * @param int $nbTuples le nombre d'occurence désirer.
    * Retourne la/les  occurence de la table produit selon leur nombres de ventes.
    * @return object Occurences des derniers produits. 
    */
    public static function getMeilleurProduit($nbTuples) {
        return self::requeteSelect("*", "produit, categorie", "(produit.idCat = categorie.idCategorie) ORDER BY nbVenteProduit DESC LIMIT $nbTuples");
    }
    
    
    /*
    * @param string motCle Le mot clé de la recherche.
    * Retourne la/les  occurence de la table produit selon le mot clé.
    * @return object Occurences des produits correspondant au mot clé. 
    */
    public static function rechercherProduit($motCle) {
        self::seConnecter();
        self::$requete = "SELECT * FROM produit, categorie  WHERE (produit.idCat = categorie.idCategorie) AND LibelleProduit LIKE CONCAT('%', :motCle, '%')";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':motCle', $motCle);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
            
    /**
    * Retourne le nombre de produits.
    * @return int nombre d'occurences de la table produit.  
    */ 
    public static function getNbProduits() {
        return self::getNbTuples("produit");
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Méthodes/Fonctions statiques - utilisateur/indenfication">

    /**
     * Vérifie si l'utilisateur est un administrateur présent dans la base.
     * @param type $login Login de l'utilisateur
     * @param type $passe Passe de l'utilisateur
     * @return type Booléen
     */  
    public static function isAdminOK($login, $passe) {     
        self::seConnecter();
        self::$requete = "SELECT * FROM utilisateur where loginUtilisateur=:login and passUtilisateur=:passe";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue('login', $login);
        self::$pdoStResults->bindValue('passe', sha1($passe));
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        
        if((self::$resultat!=null) and (self::$resultat->isAdmin)) { 
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * Vérifie si l'utilisateur est présent dans la base.
     * @param type $login Login de l'utilisateur
     * @param type $passe Passe de l'utilisateur
     * @return type Booléen
    */  
    public static function isRegistered($login, $passe) {  
        self::seConnecter();
        self::$requete = "SELECT * FROM utilisateur where loginUtilisateur=:login and passUtilisateur=:passe";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue('login', $login);
        self::$pdoStResults->bindValue('passe', sha1($passe));
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        
        return (self::$resultat!=null);
    }
    
    /**
     * Permet d'insérer un utilisateur dans la table.
     * @param type $login
     * @param type $pass
     * @param type $nom
     * @param type $prenom
     * @param type $email
     * @param type $tel
     * @param type $adresseRue
     * @param type $adresseCp
     * @param type $adresseVille
     * @param type $isSubcribed
     */
    public static function insertUtilisateur($login, $pass, $nom, $prenom, $email, $tel, $adresseRue, $adresseCp, $adresseVille, $isSubcribed) {
        self::seConnecter();
        self::$requete = "INSERT INTO utilisateur (loginUtilisateur, passUtilisateur, nomUtilisateur, prenomUtilisateur, emailUtilisateur, telUtilisateur, adresseRueUtilisateur, adresseCpUtilisateur, adresseVilleUtilisateur, adresseIpUtilisateur, isSubcribed) "
                . "VALUES (:loginUtilisateur, :passUtilisateur, :nomUtilisateur, :prenomUtilisateur, :emailUtilisateur, :telUtilisateur, :adresseRueUtilisateur, :adresseCpUtilisateur, :adresseVilleUtilisateur, :adresseIpUtilisateur, :isSubcribed)";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue('loginUtilisateur', $login);
        self::$pdoStResults->bindValue('passUtilisateur', sha1($pass));
        self::$pdoStResults->bindValue('nomUtilisateur', $nom);
        self::$pdoStResults->bindValue('prenomUtilisateur', $prenom);
        self::$pdoStResults->bindValue('emailUtilisateur', $email);
        self::$pdoStResults->bindValue('telUtilisateur', $tel);
        self::$pdoStResults->bindValue('adresseRueUtilisateur', $adresseRue);
        self::$pdoStResults->bindValue('adresseCpUtilisateur', $adresseCp);
        self::$pdoStResults->bindValue('adresseVilleUtilisateur', $adresseVille);
        self::$pdoStResults->bindValue('adresseIpUtilisateur', $_SERVER['REMOTE_ADDR']);
        self::$pdoStResults->bindValue(':isSubcribed', $isSubcribed);
        self::$pdoStResults->execute();
    }

    /**
     * Permet de savoir si un utilisateur existe ou non.
     * @param string email voulant être vérifier.
     * @return boolean Retourne si oui ou non l'email est présente en BDD.
     */
    public static function emailExist($email) {
    self::seConnecter();
    self::$requete = "SELECT * FROM utilisateur WHERE emailUtilisateur=:email";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->bindValue('email', $email);
    self::$pdoStResults->execute();
    self::$resultat = self::$pdoStResults->fetch();
    self::$pdoStResults->closeCursor();

    return (self::$resultat!=null);
    }
    
    /**
     * Permet de mettre à jour le code otp d'un utilisateur.
     * @param int $otpCode le code OTP.
     * @param string $email l'email.
     */
    public static function updateOtpCodeUtilisateur($otpCode, $email) {
    self::seConnecter();
    self::$requete = "UPDATE utilisateur SET otpCode = :otpCode WHERE emailUtilisateur = :emailUtilisateur";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->bindValue('otpCode', $otpCode);
    self::$pdoStResults->bindValue('emailUtilisateur', $email);
    self::$pdoStResults->execute();
    self::$pdoStResults->closeCursor();
    }

    /**
     * Permet de mettre à jour le mot de passe d'un utilisateur.
     * @param type $email l'email.
     * @param type $password le mot de passe.
     */
    public static function updatePasswordUtilisateur($email, $password) {
    self::seConnecter();
    self::$requete = "UPDATE utilisateur SET passUtilisateur = :passwordUtilisateur WHERE emailUtilisateur = :emailUtilisateur";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->bindValue('passwordUtilisateur', sha1($password));
    self::$pdoStResults->bindValue('emailUtilisateur', $email);
    self::$pdoStResults->execute();
    self::$pdoStResults->closeCursor();
    }

    /**
     * Permet de vérifier si le code OTP entrer est correct ou non.
     * @param type $email l'email.
     * @param type $otpCode le code otp
     * @return boolean Retourne true si le code otp est le bon sinon false.
     */
    public static function checkOtpCode($email ,$otpCode) {
    self::seConnecter();
    self::$requete = "SELECT * FROM utilisateur WHERE (emailUtilisateur=:email AND otpCode=:otpCode)";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->bindValue('email', $email);
    self::$pdoStResults->bindValue('otpCode', $otpCode);
    self::$pdoStResults->execute();
    self::$resultat = self::$pdoStResults->fetch();
    self::$pdoStResults->closeCursor();

    return (self::$resultat!=null);
    }
    
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Méthodes/Fonctions statiques - partie admin">

    public static function deleteByTable($primaryKey, $tableName, $fieldName) {
    self::seConnecter();
    self::$requete = "DELETE FROM $tableName WHERE $fieldName = $primaryKey";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->execute();
    self::$pdoStResults->closeCursor();
    }

    public static function addByTable($tableName, $values) {
        self::requeteInsert($tableName, $values);
    }
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Méthodes/Fonctions statiques - partie utilisateur">

    public static function getDetailsUtilisateur($loginUtilisateur) {
        return self::requeteSelect("*", "utilisateur", "loginUtilisateur = '$loginUtilisateur'");
    }
    
    public static function updateUser($id, $prenom, $nom, $login, $email, $tel, $rue, $cp, $ville) {
        self::seConnecter();
        self::$requete = "UPDATE utilisateur "
                . "SET loginUtilisateur = :loginUtilisateur, "
                . "nomUtilisateur = :nomUtilisateur, "
                . "prenomUtilisateur = :prenomUtilisateur, "
                . "emailUtilisateur = :emailUtilisateur, "
                . "telUtilisateur = :telUtilisateur, "
                . "adresseRueUtilisateur = :rueUtilisateur, "
                . "adresseCpUtilisateur = :cpUtilisateur, "
                . "adresseVilleUtilisateur = :villeUtilisateur "
                . "WHERE idUtilisateur = :idUtilisateur";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue('loginUtilisateur', $login);
        self::$pdoStResults->bindValue('nomUtilisateur', $nom);
        self::$pdoStResults->bindValue('prenomUtilisateur', $prenom);
        self::$pdoStResults->bindValue('emailUtilisateur', $email);
        self::$pdoStResults->bindValue('telUtilisateur', $tel);
        self::$pdoStResults->bindValue('rueUtilisateur', $rue);
        self::$pdoStResults->bindValue('cpUtilisateur', $cp);
        self::$pdoStResults->bindValue('villeUtilisateur', $ville);
        self::$pdoStResults->bindValue('idUtilisateur', $id);
        self::$pdoStResults->execute();
        self::$pdoStResults->closeCursor();
    }
    
    public static function addProductToFavorite($idUtilisateur, $idProduit) {
        self::requeteInsert("favorisutilisateur", "$idUtilisateur, $idProduit");
    }
    
    public static function removeProductToFavorite($idUtilisateur, $idProduit) {
        self::requeteDelete("favorisutilisateur", "idUtilisateur = $idUtilisateur AND idProduit = $idProduit");
    }
    
    public static function checkProductFavorite($idUtilisateur, $idProduit) {
        return self::itExist("favorisutilisateur", "idUtilisateur = $idUtilisateur AND idProduit = $idProduit");
    }
    
    public static function checkProductFavoriteColorHeart($idUtilisateur, $idProduit) {
        $bool = self::itExist("favorisutilisateur", "idUtilisateur = $idUtilisateur AND idProduit = $idProduit");
        if ($bool) {
            return 'color: red;';
        } else {
            return 'color: white;';
        }
    }
    
    public static function getUtilisateurId($loginUtilisateur) {
        return self::getPremierAttributByChamp("utilisateur", "idUtilisateur", "loginUtilisateur", $loginUtilisateur);
    }
    
    public static function getFavoriteProductsUtilisateur($idUtilisateur) {
        return self::requeteSelect("*", "favorisutilisateur, produit, categorie", "(produit.idProduit = favorisutilisateur.idProduit) AND (categorie.idCategorie = produit.idCat) AND (favorisutilisateur.idUtilisateur = $idUtilisateur)");
    }
    
    public static function getOrdersUtilisateur($idUtilisateur) {
        return self::requetePS("CALL `!GetHistoriqueCommandeById`('$idUtilisateur')");
    }
    
    public static function getOrderContentByOder($idCommande) {
        return self::requeteSelect("lignedecommande.idCommande, produit.LibelleProduit, lignedecommande.QuantiteCom", "lignedecommande, produit", 
        "(lignedecommande.idProduit = produit.idProduit) AND (lignedecommande.idCommande = $idCommande)");
    }
    
    public static function getUtilisateurNewsletter() {
        return self::requeteSelect("*", "utilisateur", "(isSubcribed = 1)");
    }
    
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Méthodes/Fonctions statiques - panier">

    public static function checkPromotionCode($idCodePromotion) {
        return self::itExist("codepromotion", "(idCodePromotion = '$idCodePromotion')");
    }

    public static function getPromotionCodeById($idCodePromotion) {
        return self::requeteSelect("*", "codepromotion", "(idCodePromotion = '$idCodePromotion')");
    }

    // </editor-fold>
    
}
// </editor-fold> 

?>



<?php 

// ---------------------------------------------------------
// Test des services (méthodes) de la classe GestionBoutique
// ---------------------------------------------------------

// Test de connexion
// GestionBoutique::seConnecter();

// ---------------------------------------------------------

// Test de la fonctio getLesCategories()
// $lesCategories = GestionBoutique::getLesCategories();
// var_dump($lesCategories); // Affiche le contenu de ma variable

// ---------------------------------------------------------

// Test de la fonction getLesProduitsByCategorie()
// $lesProduits = GestionBoutique::getLesProduitsByCategorie("Materiel");
// svar_dump($lesProduits); // Affiche le contenu de ma variable

// ---------------------------------------------------------

// Test de la fonction getProduitById()
// $leProduit = GestionBoutique::getProduitById('14');
// var_dump($leProduit); // Affiche le contenu de ma variable

// ---------------------------------------------------------

// Test de la fonction getNbProduits()
// $nbProduit = GestionBoutique::getNbProduits();
// var_dump("Il y a ".$nbProduit.' produits dans la BDD'); // Affiche le contenu de ma variable
// var_dump($nbProduit)

// ---------------------------------------------------------

// Test de la méthode ajouterCategorie()
// GestionBoutique::ajouterCategorie('test');
// var_dump(GestionBoutique::getLesCategories());

// ---------------------------------------------------------

// Test de la méthode ajouterProduit()
// GestionBoutique::ajouterProduit("Test","Testdesc", 22, "test.png", 1);
// var_dump(GestionBoutique::getLesProduits());

// ---------------------------------------------------------

// Test de la méthode getLesTuplesByTable()
// ModelePDO::getLesTuplesByTable("categorie")

// ---------------------------------------------------------

// Test de la méthode getProduitByCategorie()
// $lesProduit = GestionBoutique::getProduitByCategorie('Materiel');
// var_dump($lesProduit); // Affiche le contenu de ma variable

// ---------------------------------------------------------

//                  MISE EN FORME DES DONNEES 

// ---------------------------------------------------------

// Test retour de type " Simple " (entier, chaine, booléen,..)
//var_dump(GestionBoutique::getNbProduits());
//$nbProduits = GestionBoutique::getNbProduits(); // Rédcupère et stocke le nombre de produit dans la variable nbProdutis
//echo "Il y a $nbProduits produit(s) dans la boutique..."; // Affichage du résultat

// ---------------------------------------------------------

// Test retour de type " objet "
//$leProduit = GestionBoutique::getProduitById(1);
//var_dump($leProduit);
//header('Cotent-Type: text/html; charseet=UTF-8');
//echo 'Produit retourné : </br>';
//echo '--------------------</br>';
//echo 'ID : ' . $leProduit->id . '</br>';
//echo 'Nom : ' . $leProduit->nom . '</br>';
//echo 'Description : ' . $leProduit->description . '</br>';
//echo 'Prix : ' . $leProduit->prix . '</br>';
//echo "Fichier de l'image : " . $leProduit->image . '</br>';

// ---------------------------------------------------------

// Test retour de type " Tableau d'objets "
//$lesCategories = GestionBoutique::getLesCategories();
//var_dump($lesCategories);
//
////echo 'Il y a ' . GestionBoutique::getNb("categorie") . ' catégories dans la base :</br>';
//echo 'Il y a ' . count($lesCategories) . ' catégories dans la base : </br>';
//echo '---------------------------------------------------------------------------</br>';
//$i = 1;
//foreach ($lesCategories as $uneCategorie) {
//    echo $uneCategorie->libelle . ' (catégorie ' . $i . ')</br>';
//    $i = $i + 1;
//}

//echo $lesCategories[0]-> libelle . ' (catégorie 1)</br>';
//echo $lesCategories[1]-> libelle . ' (catégorie 2)</br>';
//echo $lesCategories[2]-> libelle . ' (catégorie 3)</br>';
//echo $lesCategories[3]-> libelle . ' (catégorie 4)</br>';
//echo $lesCategories[4]-> libelle . ' (catégorie 5)</br>';

// ---------------------------------------------------------

//Test de la méthode isAdminOK
// var_dump(GestionBoutique::isAdminOK("grandChef", "passeGrandChef"));
// var_dump(GestionBoutique::isAdminOK("petitChef", "passePetitChef"));

// ---------------------------------------------------------
// Test de la méthode getNomTables()
//var_dump(GestionBoutique::getNomTables())

?>