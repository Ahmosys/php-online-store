<?php

// require_once '../../configs/mysql_config.class.php';


/**
 *  Classe mère ModelePDO généraliste pour la gestion des BDD
 *  Méthodes génériques et réusitilisable.
 */
class ModelePDO {
    
// <editor-fold defaultstate="collapsed" desc="Champs statiques">

    // Champs en protected sont visible dans la classe de définition (modelePDO)
    // et dans les classes dérivées (fille).
   
    //Attributs utiles pour la connexion
    protected static $serveur = MySqlConfig::SERVEUR;
    protected static $base = MySqlConfig::BASE;
    protected static $utilisateur = MySqlConfig::UTILISATEUR;
    protected static $passe = MySqlConfig::MOT_DE_PASSE;
    
    //Attributs utiles pour la manipulation PDO de la BD
    protected static $pdoCnxBase = null;
    protected static $pdoStResults = null;
    protected static $requete = "";
    protected static $resultat = null;
    
// </editor-fold>
    
// <editor-fold defaultstate="collapsed" desc="Méthodes statiques">

    /**
     * Méthode statique (s'appelle avec nomDeLaClasse::) permettant de se connecter à la BDD.
     */
    protected static function seConnecter() {
        if (!isset(self::$pdoCnxBase)) { //S'il n'y a pas encore eu de connexion
            try {
                self::$pdoCnxBase = new PDO('mysql:host=' . self::$serveur . ';dbname=' . self::$base, self::$utilisateur, self::$passe);
                self::$pdoCnxBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdoCnxBase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                self::$pdoCnxBase->query("SET CHARACTER SET utf8"); //méthode de la classe PDO
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage() . '<br />'; // méthode de la classe Exception
                echo 'Code : ' . $e->getCode(); // méthode de la classe Exception
            }
        }
    }

    protected static function seDeconnecter() {
        // Si on n'appelle pas la méthode, la déconnexion a lieu en fin de script
        self::$pdoCnxBase = null;
    }

// </editor-fold>
    
// <editor-fold defaultstate="collapsed" desc="Méthodes statiques">

    /**
     * Fonction perméttant de recupérer les tuples d'une table d'une base de données.
     * @param string $table Nom de la table.
     * @return object array Occureences de la table en question.
     */
    public static function getLesTuplesByTable($table) {
        self::seConnecter();
        self::$requete = "SELECT * FROM " . $table;
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }

    /**
     * 
     * @param string $table Nom de la table
     * @param string $nomChamp Nom du champ (attribut).
     * @param string $valeurChamp Valeur du champ (attribut).
     * @return object Première occurence de la table.
     */
    protected static function getPremierTupleByChamp($table, $nomChamp, $valeurChamp) {
        self::seConnecter();
        self::$requete = "SELECT * FROM " . $table . " WHERE " . $nomChamp . " = :valeurChamp";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':valeurChamp', $valeurChamp);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat; //un seul tuple retourné : utilisation de fetch()
    }
    
        /**
     * 
     * @param string $table Nom de la table
     * @param string $nomChamp Nom du champ (attribut).
     * @param string $valeurChamp Valeur du champ (attribut).
     * @return object Première occurence de la table.
     */
    protected static function getPremierAttributByChamp($table, $attribut, $nomChamp, $valeurChamp) {
        self::seConnecter();
        self::$requete = "SELECT $attribut FROM " . $table . " WHERE " . $nomChamp . " = :valeurChamp";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':valeurChamp', $valeurChamp);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        return self::$resultat->$attribut; //un seul tuple retourné : utilisation de fetch()
    }

        /**
     * 
     * @param string $table Nom de la table
     * @param string $nomChamp Nom du champ (attribut).
     * @param string $valeurChamp Valeur du champ (attribut).
     */
    protected static function supprimerTupleByChamp($table, $nomChamp, $valeurChamp) {
        self::seConnecter();
        self::$requete = "DELETE FROM " . $table . " WHERE " . $nomChamp . " = :valeurChamp";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':valeurChamp', $valeurChamp);
        self::$pdoStResults->execute();
    }
    
    /**
     * 
     * @param type $table Nom de la table
     * @return type
     */
    public static function getNbTuples($table) {
        self::seConnecter();
        self::$requete = "SELECT COUNT(*) AS nbTuples FROM " . $table ;
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        return self::$resultat->nbTuples;
    }
    
    /**
     * Fonction perméttant d'éffectuer une requête select.
     * @param type $champs Nom des ou du champ.
     * @param type $tables Nom des ou de la table.
     * @param type $conditions Conditions.
     * @return object array Occurences de la table.
     */
    public static function requeteSelect($champs, $tables, $conditions = null) {
        self::seConnecter();
        self::$requete = "SELECT " . $champs . " FROM " . $tables;
        // Si il y'a une condition alors on rajoute à la fin de la requête.
        if ($conditions != null) {
            self::$requete .= " WHERE " . $conditions;
        }
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
    
    protected static function requetePS($nom) {
        self::seConnecter();
        self::$requete = "$nom";
        // Si il y'a une condition alors on rajoute à la fin de la requête.
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
    
    /**
    * Fonction perméttant d'éffectuer une requête insert.
    * @param type $table Nom de la table.
    * @param type $lesValeurs Les valeurs.
    * @param type $lesChamps Les champs.
    */
    protected static function requeteInsert($table, $lesValeurs) {
        self::seConnecter();
        self::$requete = "INSERT INTO " . $table . "(" . self::getNomChampsByTableInsert($table) . ") VALUES (" . $lesValeurs . ")";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
    }
    
    /**
    * Fonction perméttant d'éffectuer une requête delete.
    * @param type $table Nom de la table.
    * @param type $conditions Les conditions.
    */
    protected static function requeteDelete($table, $conditions) {
        self::seConnecter();
        self::$requete = "DELETE FROM " . $table . " WHERE " . $conditions;
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
    }
    
    protected static function getNomChampsByTableInsert($table) {
        self::seConnecter();
        self::$requete = " DESCRIBE " . $table;
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();

        $lesChampsSale = self::$resultat;
        $lesChampsPropre = "";
        foreach ($lesChampsSale as $unChamp) {
            $lesChampsPropre .= $unChamp->Field . ",";
        }
        $lesChampsPropre .= "$";
        $lesChampsPropre = str_replace(",$", "" , $lesChampsPropre);
        return $lesChampsPropre;
    }
    
    /**
    * Retourne les noms des attributs clé primaire.
    * @param type $table Nom de la table
    * @return string Attributs de la table.
    */
    public static function getNomAttributsClePrimaire($table) {
        $theFieldsPK = array();
        self::seConnecter();
        self::$requete = "DESCRIBE " . $table;
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        
        foreach(self::$resultat as $unResultat) {
            if ($unResultat->Key == "PRI") {
                $theFieldsPK[] = $unResultat->Field;
            }
        }
        
        return $theFieldsPK;
    }
    
    /**
    * Retourne le nom des attriuts d'une table.
    * @param string $table nom de la table.
    * @return object les attributs de la table.
    */
    public static function getNomChampsByTable($table) {
        self::seConnecter();
        self::$requete = "DESCRIBE " . $table;
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
    
    /**
    * Permet de récupérer le nom des tables dans la base.
    * @return object Les noms des tables de la BDD.
    */
    public static function getNomTables() {
        self::seConnecter();
        self::$requete = "SHOW TABLES";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }
    
    /**
     * Retourne le nombre d'attributs dans une table.
     * @param type $baseName nom de la BDD.
     * @param type $tableName nom de la table.
     * @return int nombre de colonnes.
     */
    public static function getNbColumnByTable($baseName, $tableName) {
        self::seConnecter();
        self::$requete = "SELECT count(*) as nbColumns FROM information_schema.COLUMNS WHERE table_schema = '$baseName' AND table_name='$tableName'";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        return self::$resultat->nbColumns;
    }
    
    public static function itExist($tableName, $conditions) {
        self::seConnecter();
        self::$requete = "SELECT COUNT(*) as nbOccurence FROM $tableName WHERE $conditions";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        
        if (self::$resultat->nbOccurence > 0) {
            return true;
        } else {
            return false;
        }
    }

    
// </editor-fold>

}

?>
