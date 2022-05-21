<?php

//Config MYSQL
$utilisateur="root";
$passe="root";
$serveur="localhost";
$base="robin3";

//Connexion à la base
try{
    $pdoCnxBase=new PDO('mysql:host='.$serveur.';dbname='.$base,$utilisateur,$passe);
    $pdoCnxBase->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdoCnxBase->query("SET CHARACTER SET utf8");
} catch (Exception $ex) {
    echo $ex->getMessage();
}

// Récupération du pseudo posté
$pseudoSaisi=$_POST['pseudo'];
// Recherche du pseudo dans la base (nombre de tuples renvoyés)
$requete="select count(*) as nbResultats from utilisateur where loginUtilisateur like '".$pseudoSaisi."'";
$pdoStResults=$pdoCnxBase->prepare($requete);
$pdoStResults->execute();
$resultat=$pdoStResults->fetch(PDO::FETCH_OBJ);
// Fermeture de la base
$pdoStResults->closeCursor();
//Affichage du résultat (traité par le code du formulaire : va renseigner le
//paramètre reponse de mon success)
echo $resultat->nbResultats;

?>