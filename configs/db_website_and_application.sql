-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.11 - MySQL Community Server (GPL)
-- SE du serveur:                Win32
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour robin3
CREATE DATABASE IF NOT EXISTS `robin3` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `robin3`;

-- Listage de la structure de la procédure robin3. !DeleteCommande
DELIMITER //
CREATE PROCEDURE `!DeleteCommande`(
	IN `paramIdCommande` INT
)
BEGIN
	DELETE FROM commande WHERE (idCommande = paramIdCommande);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !DeleteProduit
DELIMITER //
CREATE PROCEDURE `!DeleteProduit`(
	IN `paramIdProduit` INT
)
BEGIN
	DELETE FROM produit
	WHERE (produit.idProduit = paramIdProduit);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !DeleteProduitByCommande
DELIMITER //
CREATE PROCEDURE `!DeleteProduitByCommande`(
	IN `paramIdCommande` INT,
	IN `paramIdProduit` INT
)
BEGIN
DELETE FROM lignedecommande WHERE (idCommande = paramIdCommande) AND (idProduit = paramIdProduit);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetCAbyProduit
DELIMITER //
CREATE PROCEDURE `!GetCAbyProduit`(
	IN `idProduit` INT
)
BEGIN
	SELECT (QteStockProduit * PrixHTProduit) AS caByProduit
	FROM produit
	WHERE produit.idProduit = idProduit;
END//
DELIMITER ;

-- Listage de la structure de la fonction robin3. !GetCapitalize
DELIMITER //
CREATE FUNCTION `!GetCapitalize`(`x` CHAR(150)
) RETURNS char(150) CHARSET utf8
BEGIN
SET @str="";
SET @l_str="";
WHILE x REGEXP ' ' DO
SELECT SUBSTRING_INDEX(x, ' ', 1) INTO @l_str;
SELECT SUBSTRING(x, LOCATE(' ', x)+1) INTO x;
SELECT CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(@l_str,1,1)),LOWER(SUBSTRING(@l_str,2)))) INTO @str;
END WHILE;
RETURN LTRIM(CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(x,1,1)),LOWER(SUBSTRING(x,2)))));
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetCommandesByClient
DELIMITER //
CREATE PROCEDURE `!GetCommandesByClient`(
	IN `numCli` INT
)
BEGIN
	SELECT idCommande, DateCommande, CONCAT(nomUtilisateur, ' ', prenomUtilisateur) AS client 
	FROM commande, utilisateur 
	WHERE (commande.idUtilisateur = utilisateur.idUtilisateur) 
	AND (utilisateur.idUtilisateur = numCli)
	ORDER BY idCommande ASC;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetCommandesByPeriode
DELIMITER //
CREATE PROCEDURE `!GetCommandesByPeriode`(
	IN `paramDate` CHAR(10)
)
BEGIN
	SELECT idCommande, DateCommande, CONCAT(nomUtilisateur, ' ',prenomUtilisateur) AS Client 
	FROM commande, utilisateur 
	WHERE (commande.idUtilisateur = utilisateur.idUtilisateur) 
	AND (commande.DateCommande LIKE CONCAT('%/', paramDate))
	ORDER BY idCommande ASC;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetHistoriqueCommandeById
DELIMITER //
CREATE PROCEDURE `!GetHistoriqueCommandeById`(
	IN `myIdUtilisateur` INT
)
BEGIN
	SELECT commande.idCommande, DateCommande, CONCAT(prenomUtilisateur, ' ', nomUtilisateur) AS Patronyme, CONCAT(SUM(QuantiteCom*PrixHTProduit), ' $') AS MontantHT 
	FROM commande, utilisateur, lignedecommande, produit 
	WHERE(commande.idCommande = lignedecommande.idCommande)
	AND(lignedecommande.idProduit = produit.idProduit)
	AND(commande.idUtilisateur = utilisateur.idUtilisateur)
	AND(commande.idUtilisateur = myIdUtilisateur)
	GROUP BY commande.idCommande;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLaCommandeById
DELIMITER //
CREATE PROCEDURE `!GetLaCommandeById`(
	IN `paramIdCommande` INT
)
BEGIN
	SELECT commande.idCommande, DateCommande, CONCAT(nomUtilisateur, ' ', prenomUtilisateur) AS Patronyme, SUM(QuantiteCom * PrixHTProduit) AS MontantHT 
	FROM utilisateur, commande, produit, lignedecommande 
	WHERE (utilisateur.idUtilisateur = commande.idUtilisateur) 
	AND (commande.idCommande = lignedecommande.idCommande) 
	AND (lignedecommande.idProduit = produit.idProduit) 
	AND (commande.idCommande = paramIdCommande)
	GROUP BY commande.idCommande;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLesClients
DELIMITER //
CREATE PROCEDURE `!GetLesClients`()
BEGIN
	SELECT idUtilisateur, CONCAT(nomUtilisateur, ' ', prenomUtilisateur) AS Patronyme 
	FROM utilisateur;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLesClientsCommande
DELIMITER //
CREATE PROCEDURE `!GetLesClientsCommande`()
BEGIN
	SELECT DISTINCT utilisateur.idUtilisateur, CONCAT(nomUtilisateur, ' ', prenomutilisateur) AS Patronyme 
	FROM utilisateur, commande 
	WHERE (utilisateur.idUtilisateur = commande.idUtilisateur);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLesCommandes
DELIMITER //
CREATE PROCEDURE `!GetLesCommandes`()
BEGIN
	SELECT idCommande, DateCommande, CONCAT(nomUtilisateur,' ',prenomUtilisateur) AS client 
	FROM commande, utilisateur 
	WHERE (commande.idUtilisateur = utilisateur.idUtilisateur) 
	ORDER BY idCommande ASC;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLesCommandesDG
DELIMITER //
CREATE PROCEDURE `!GetLesCommandesDG`()
BEGIN
	SELECT commande.idCommande, DateCommande, CONCAT(nomUtilisateur, ' ', prenomUtilisateur) AS Patronyme, SUM(QuantiteCom*PrixHTProduit) AS MontantHT 
	FROM utilisateur, commande, produit, lignedecommande 
	WHERE (utilisateur.idUtilisateur = commande.idUtilisateur) 
	AND (commande.idCommande = lignedecommande.idCommande) 
	AND (lignedecommande.idProduit = produit.idProduit) 
	GROUP BY commande.idCommande;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLesTuplesByTable
DELIMITER //
CREATE PROCEDURE `!GetLesTuplesByTable`(
	IN `paramNomTable` VARCHAR(50)
)
BEGIN
	SET @req = CONCAT('SELECT * FROM ', paramNomTable);
	PREPARE exe FROM @req;
	EXECUTE exe;
	DEALLOCATE PREPARE exe;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetLesTuplesByTableCondition
DELIMITER //
CREATE PROCEDURE `!GetLesTuplesByTableCondition`(
	IN `paramNomTable` VARCHAR(50),
	IN `paramCondition` VARCHAR(300)
)
BEGIN
	SET @req = CONCAT('SELECT * FROM ', paramNomTable, ' WHERE ', paramCondition);
	PREPARE exe FROM @req;
	EXECUTE exe;
	DEALLOCATE PREPARE exe;
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetMontantHTByCommande
DELIMITER //
CREATE PROCEDURE `!GetMontantHTByCommande`(
	IN `paramIdCommande` INT
)
BEGIN
	SELECT SUM(QuantiteCom*PrixHTProduit) AS MontantHT 
	FROM lignedecommande, commande, produit 
	WHERE (lignedecommande.idCommande = commande.idCommande) 
	AND (lignedecommande.idProduit = produit.idProduit) 
	AND (lignedecommande.idCommande = paramIdCommande);
END//
DELIMITER ;

-- Listage de la structure de la fonction robin3. !GetMontantMoyenneAllCommande
DELIMITER //
CREATE FUNCTION `!GetMontantMoyenneAllCommande`(`paramIdUtilisateur` INT
) RETURNS int(11)
    NO SQL
BEGIN

DECLARE moyenneMontantCommande FLOAT;

SET moyenneMontantCommande = (SELECT ROUND(AVG(QuantiteCom*PrixHTProduit), 2) AS MontantHT 
FROM lignedecommande, commande, produit 
WHERE (lignedecommande.idCommande = commande.idCommande) 
AND (lignedecommande.idProduit = produit.idProduit) 
AND (commande.idUtilisateur = paramIdUtilisateur));

RETURN moyenneMontantCommande;                  
                              
END//
DELIMITER ;

-- Listage de la structure de la fonction robin3. !GetMontantTotalAllCommande
DELIMITER //
CREATE FUNCTION `!GetMontantTotalAllCommande`(`paramIdUtilisateur` INT) RETURNS float
    NO SQL
BEGIN

DECLARE montantTotalToutesCommande FLOAT;

SET montantTotalToutesCommande = (SELECT SUM(QuantiteCom*PrixHTProduit) AS MontantHT FROM lignedecommande, commande, produit 
WHERE (lignedecommande.idCommande = commande.idCommande) 
AND (lignedecommande.idProduit = produit.idProduit) 
AND (commande.idUtilisateur = paramIdUtilisateur));

RETURN montantTotalToutesCommande;

END//
DELIMITER ;

-- Listage de la structure de la fonction robin3. !GetNbCommandeByClient
DELIMITER //
CREATE FUNCTION `!GetNbCommandeByClient`(`paramIdUtilisateur` INT) RETURNS int(11)
    NO SQL
BEGIN

DECLARE totalCommandeByClient INTEGER;

SET totalCommandeByClient = (SELECT COUNT(idCommande) FROM commande WHERE (commande.idUtilisateur = paramIdUtilisateur));

RETURN totalCommandeByClient;

END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetNbTuples
DELIMITER //
CREATE PROCEDURE `!GetNbTuples`(
	IN `paramNomTable` VARCHAR(50)
)
BEGIN
	SET @req = CONCAT('SELECT COUNT(*) AS nbTuples FROM ', paramNomTable);
	PREPARE exe FROM @req;
	EXECUTE exe;
	DEALLOCATE PREPARE exe;
END//
DELIMITER ;

-- Listage de la structure de la fonction robin3. !GetProduitPlusCommanderByClient
DELIMITER //
CREATE FUNCTION `!GetProduitPlusCommanderByClient`(`paramIdUtilisateur` INT) RETURNS int(11)
    NO SQL
BEGIN

DECLARE idProduitPlusCommanderByClient INT;

SET idProduitPlusCommanderByClient = (SELECT idProduit
FROM lignedecommande, commande
WHERE (lignedecommande.idCommande = commande.idCommande)
AND (commande.idUtilisateur = paramIdUtilisateur)
GROUP BY idProduit
ORDER BY SUM(QuantiteCom) DESC
LIMIT 1);

RETURN idProduitPlusCommanderByClient;

END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetProduitsByCommande
DELIMITER //
CREATE PROCEDURE `!GetProduitsByCommande`(
	IN `paramIdCommande` INT
)
BEGIN
	SELECT lignedecommande.idCommande, LibelleProduit, QuantiteCom, CONCAT(QuantiteCom*PrixHTProduit, ' ', '€') AS MontantHT 
	FROM lignedecommande, commande, produit 
	WHERE (lignedecommande.idCommande = commande.idCommande) 
	AND (lignedecommande.idProduit = produit.idProduit) 
	AND (lignedecommande.idCommande = paramIdCommande);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !GetQteStockProduit
DELIMITER //
CREATE PROCEDURE `!GetQteStockProduit`(
	IN `paramIdProduit` INT
)
BEGIN
	SELECT QteStockProduit FROM produit WHERE (idProduit = paramIdProduit);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !InsertClient
DELIMITER //
CREATE PROCEDURE `!InsertClient`(
	IN `paramLoginUtilisateur` VARCHAR(50),
	IN `paramPassUtilisateur` VARCHAR(50),
	IN `paramNomUtilisateur` VARCHAR(100),
	IN `paramPrenomUtilisateur` VARCHAR(100),
	IN `paramEmailUtilisateur` VARCHAR(150),
	IN `paramTelUtilisateur` VARCHAR(15),
	IN `paramAdresseRueUtilisateur` VARCHAR(100),
	IN `paramAdresseCpUtilisateur` INT,
	IN `paramAdresseVilleUtilisateur` VARCHAR(100),
	IN `paramIpUtilisateur` VARCHAR(50)
)
BEGIN
	DECLARE pk INTEGER;
	SET pk = (SELECT MAX(utilisateur.idUtilisateur) FROM utilisateur) + 1;
	INSERT INTO utilisateur (idUtilisateur, loginUtilisateur, passUtilisateur, nomUtilisateur, prenomUtilisateur, emailUtilisateur, telUtilisateur, adresseRueUtilisateur, adresseCpUtilisateur, adresseVilleUtilisateur, adresseIpUtilisateur) VALUES (pk, paramLoginUtilisateur, paramPassUtilisateur, paramNomUtilisateur, paramPrenomUtilisateur, paramEmailUtilisateur, paramTelUtilisateur, paramAdresseRueUtilisateur, paramAdresseCpUtilisateur, paramAdresseVilleUtilisateur, paramIpUtilisateur);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !InsertCommande
DELIMITER //
CREATE PROCEDURE `!InsertCommande`(
	IN `paramDate` VARCHAR(50),
	IN `paramIdClient` INT
)
BEGIN
	DECLARE pk INTEGER;
	SET pk = (SELECT MAX(commande.idCommande) FROM commande) + 1;
	INSERT INTO commande (idCommande, DateCommande, idUtilisateur) VALUES (pk, paramDate, paramIdClient);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !InsertProduitByCommande
DELIMITER //
CREATE PROCEDURE `!InsertProduitByCommande`(
	IN `paramIdCommande` INT,
	IN `paramIdProduit` INT,
	IN `paramQteCommande` INT
)
BEGIN
INSERT INTO lignedecommande VALUES (paramIdCommande, paramIdProduit, paramQteCommande);
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !RechercheClient
DELIMITER //
CREATE PROCEDURE `!RechercheClient`(
	IN `paramValeur` CHAR(20)
)
BEGIN
	SELECT * FROM utilisateur 
	WHERE (
		idUtilisateur LIKE CONCAT('%', paramValeur) 
		OR loginUtilisateur LIKE CONCAT('%', paramValeur)
		OR passUtilisateur LIKE CONCAT('%', paramValeur) 
		OR nomUtilisateur LIKE CONCAT('%', paramValeur) 
		OR prenomUtilisateur LIKE CONCAT('%', paramValeur) 
		OR emailUtilisateur LIKE CONCAT('%', paramValeur)
		OR telUtilisateur LIKE CONCAT('%', paramValeur)
		OR adresseRueUtilisateur LIKE CONCAT('%', paramValeur)
		OR adresseCpUtilisateur LIKE CONCAT('%', paramValeur)
		OR adresseVilleUtilisateur LIKE CONCAT('%', paramValeur)
		OR adresseIpUtilisateur LIKE CONCAT('%', paramValeur));
END//
DELIMITER ;

-- Listage de la structure de la procédure robin3. !UpdateQteStockByCommande
DELIMITER //
CREATE PROCEDURE `!UpdateQteStockByCommande`(
	IN `paramIdCommande` INT,
	IN `paramIdProduit` INT,
	IN `paramQte` INT
)
BEGIN
	UPDATE lignedecommande  
	SET QuantiteCom = QuantiteCom + paramQte
	WHERE (idCommande = paramIdCommande) 
	AND (idProduit = paramIdProduit);
END//
DELIMITER ;

-- Listage de la structure de la table robin3. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(11) NOT NULL,
  `LibelleCategorie` varchar(45) DEFAULT NULL,
  `CaCategorie` float DEFAULT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.categorie : ~4 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`idCategorie`, `LibelleCategorie`, `CaCategorie`) VALUES
	(1, 'Hardware', 8070),
	(2, 'Software', 27300),
	(3, 'Service', 1993.94),
	(4, 'Documentation', 3116.5);
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table robin3. codepromotion
CREATE TABLE IF NOT EXISTS `codepromotion` (
  `idCodePromotion` varchar(50) NOT NULL DEFAULT '',
  `tauxPromotion` int(11) NOT NULL,
  `descriptionPromotion` varchar(50) NOT NULL DEFAULT 'Indéfinie',
  PRIMARY KEY (`idCodePromotion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.codepromotion : ~2 rows (environ)
/*!40000 ALTER TABLE `codepromotion` DISABLE KEYS */;
INSERT INTO `codepromotion` (`idCodePromotion`, `tauxPromotion`, `descriptionPromotion`) VALUES
	('SUMMER2022', 20, 'Reduction de -20% pour l\'été.'),
	('WINTER2023', 15, 'Réduction pour les soldes d\'hiver.');
/*!40000 ALTER TABLE `codepromotion` ENABLE KEYS */;

-- Listage de la structure de la table robin3. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `idCommande` int(11) NOT NULL,
  `DateCommande` varchar(10) DEFAULT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  `isNotSolde` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`idCommande`),
  KEY `FKCli` (`idUtilisateur`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.commande : ~3 rows (environ)
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` (`idCommande`, `DateCommande`, `idUtilisateur`, `isNotSolde`) VALUES
	(1, '19/11/2021', 1, 0),
	(2, '18/11/2021', 27, 0),
	(3, '07/11/2021', 27, 1);
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

-- Listage de la structure de la table robin3. favorisutilisateur
CREATE TABLE IF NOT EXISTS `favorisutilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`,`idProduit`),
  KEY `FK_PRODUIT` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.favorisutilisateur : ~2 rows (environ)
/*!40000 ALTER TABLE `favorisutilisateur` DISABLE KEYS */;
INSERT INTO `favorisutilisateur` (`idUtilisateur`, `idProduit`) VALUES
	(2, 1),
	(2, 3);
/*!40000 ALTER TABLE `favorisutilisateur` ENABLE KEYS */;

-- Listage de la structure de la table robin3. fournisseur
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `idFournisseur` int(11) NOT NULL,
  `NomFournisseur` varchar(100) DEFAULT NULL,
  `VilleFournisseur` varchar(100) DEFAULT NULL,
  `CPFournisseur` int(11) DEFAULT NULL,
  PRIMARY KEY (`idFournisseur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.fournisseur : ~3 rows (environ)
/*!40000 ALTER TABLE `fournisseur` DISABLE KEYS */;
INSERT INTO `fournisseur` (`idFournisseur`, `NomFournisseur`, `VilleFournisseur`, `CPFournisseur`) VALUES
	(1, 'DELL Computers', 'Montpellier', 34000),
	(2, 'IBM', 'Montpellier', 34000),
	(3, 'RC Consulting', 'Sérignan', 34500);
/*!40000 ALTER TABLE `fournisseur` ENABLE KEYS */;

-- Listage de la structure de la table robin3. lignedecommande
CREATE TABLE IF NOT EXISTS `lignedecommande` (
  `idCommande` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `QuantiteCom` int(11) NOT NULL,
  PRIMARY KEY (`idCommande`,`idProduit`),
  KEY `FKCom` (`idCommande`),
  KEY `FKProd` (`idProduit`),
  CONSTRAINT `FKCom` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`idCommande`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FKProd` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.lignedecommande : ~3 rows (environ)
/*!40000 ALTER TABLE `lignedecommande` DISABLE KEYS */;
INSERT INTO `lignedecommande` (`idCommande`, `idProduit`, `QuantiteCom`) VALUES
	(1, 8, 15),
	(2, 1, 3),
	(2, 8, 1);
/*!40000 ALTER TABLE `lignedecommande` ENABLE KEYS */;

-- Listage de la structure de la table robin3. produit
CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int(11) NOT NULL,
  `LibelleProduit` varchar(100) DEFAULT NULL,
  `PrixHTProduit` float(6,2) DEFAULT NULL,
  `QteStockProduit` int(11) DEFAULT NULL,
  `idFourn` int(11) DEFAULT NULL,
  `idCat` int(11) DEFAULT NULL,
  `ImageProduit` varchar(50) DEFAULT NULL,
  `nbVenteProduit` int(11) DEFAULT '0',
  PRIMARY KEY (`idProduit`),
  KEY `FKFourn` (`idFourn`),
  KEY `FKCat` (`idCat`),
  CONSTRAINT `FKCat` FOREIGN KEY (`idCat`) REFERENCES `categorie` (`idCategorie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKFourn` FOREIGN KEY (`idFourn`) REFERENCES `fournisseur` (`idFournisseur`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.produit : ~12 rows (environ)
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` (`idProduit`, `LibelleProduit`, `PrixHTProduit`, `QteStockProduit`, `idFourn`, `idCat`, `ImageProduit`, `nbVenteProduit`) VALUES
	(1, 'Optiplex 3010', 350.00, 3, 2, 1, 'img_produit_optiflex_3010.png', 1),
	(2, 'Nas Server', 890.00, 3, 2, 1, 'img_produit_nas_serveur.png', 138),
	(3, 'Soft. GestCom', 550.00, 81, 3, 2, 'img_produit_logiciel.png', 7),
	(4, 'Form. GestCom', 100.00, 2, 3, 3, 'img_produit_formation.png', 25),
	(5, 'Gaming Mouse', 30.00, 12, 1, 1, 'img_produit_souris_gaming.png', 69),
	(6, 'Support User', 150.00, 5, 2, 4, 'img_produit_support.png', 12),
	(7, 'Form. Photo', 150.00, 17, 3, 3, 'img_produit_formation.png', 6),
	(8, 'Form. Montage', 148.99, 12, 3, 3, 'img_produit_formation.png', 5),
	(9, 'Support Tech', 278.00, 7, 3, 4, 'img_produit_support.png', 13),
	(10, 'Support IT', 125.50, 101, 3, 4, 'img_produit_support.png', 38),
	(11, 'Soft. Photo', 750.00, 0, 3, 2, 'img_produit_logiciel.png', 8),
	(12, 'Soft. Vidéo', 825.00, 0, 3, 2, 'img_produit_logiciel.png', 55);
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;

-- Listage de la structure de la table robin3. statsutilisateur
CREATE TABLE IF NOT EXISTS `statsutilisateur` (
  `idUtilisateur` int(11) DEFAULT NULL,
  `nbTotalCommande` int(11) DEFAULT NULL,
  `idProduitPlusCommander` int(11) DEFAULT NULL,
  `montantTotalDepense` float DEFAULT NULL,
  `motantMoyenneCommande` float DEFAULT NULL,
  `dateHistorique` varchar(50) DEFAULT NULL,
  KEY `FK_PRODUIT` (`idProduitPlusCommander`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.statsutilisateur : ~79 rows (environ)
/*!40000 ALTER TABLE `statsutilisateur` DISABLE KEYS */;
INSERT INTO `statsutilisateur` (`idUtilisateur`, `nbTotalCommande`, `idProduitPlusCommander`, `montantTotalDepense`, `motantMoyenneCommande`, `dateHistorique`) VALUES
	(1, 2, 3, 10184, 1273, '2021-11-28 21:36:25'),
	(1, 2, 3, 10934, 1215, '2021-11-30 16:12:49'),
	(1, 2, 3, 12034, 1203, '2022-03-19 14:18:29'),
	(1, 1, 3, 7787, 1298, '2022-04-03 22:33:49'),
	(1, 1, 3, 9567, 1367, '2022-04-03 23:00:16'),
	(1, 1, 3, 15067, 2152, '2022-04-04 08:38:55'),
	(1, 1, 3, 18567, 2652, '2022-04-04 09:01:53'),
	(1, 1, 3, 20317, 2902, '2022-04-04 09:02:28'),
	(1, 1, 3, 20317, 2902, '2022-04-05 20:20:29'),
	(1, 1, 3, 22097, 3157, '2022-04-05 20:20:59'),
	(27, 2, 4, 248.99, 124, '2022-04-05 20:46:39'),
	(27, 2, 4, 248.99, 124, '2022-04-05 20:46:45'),
	(27, 2, 4, 248.99, 124, '2022-04-05 20:47:06'),
	(27, 2, 1, 598.99, 200, '2022-04-05 20:47:16'),
	(27, 2, 1, 4098.99, 1366, '2022-04-05 20:47:24'),
	(27, 2, 1, 5598.99, 1400, '2022-04-05 20:47:41'),
	(27, 2, 1, 5598.99, 1400, '2022-04-05 20:47:47'),
	(1, 1, 3, 27140, 6785, '2022-04-05 21:20:59'),
	(1, 1, 3, 27418, 5484, '2022-04-05 21:22:09'),
	(1, 1, 3, 28518, 5704, '2022-04-05 21:23:15'),
	(1, 1, 3, 31268, 6254, '2022-04-05 21:25:13'),
	(1, 1, 3, 31618, 6324, '2022-04-05 21:25:24'),
	(1, 1, 1, 10168, 2542, '2022-04-05 21:26:48'),
	(1, 1, 1, 13190, 3298, '2022-04-05 21:30:41'),
	(1, 1, 1, 14260, 4753, '2022-04-05 21:31:47'),
	(1, 1, 3, 9460, 3153, '2022-04-05 21:32:03'),
	(27, 2, 1, 4098.99, 1366, '2022-04-05 21:33:10'),
	(27, 2, 1, 4648.99, 1162, '2022-04-05 21:34:49'),
	(1, 1, 3, 7960, 3980, '2022-04-05 21:37:07'),
	(1, 1, 3, 7960, 3980, '2022-04-05 21:38:08'),
	(1, 1, 3, 8660, 2887, '2022-04-05 21:38:30'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:35:41'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:38:04'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:38:12'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:38:15'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:38:42'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:38:54'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:39:02'),
	(1, 1, 3, 7960, 3980, '2022-04-05 22:40:00'),
	(1, 1, 3, 9360, 3120, '2022-04-05 22:40:08'),
	(1, 1, 3, 9360, 3120, '2022-04-05 22:40:40'),
	(1, 1, 3, 10185, 2546, '2022-04-05 22:40:56'),
	(1, 1, 3, 10275, 2055, '2022-04-05 22:41:09'),
	(1, 1, 3, 10275, 2055, '2022-04-05 22:41:17'),
	(1, 1, 3, 10275, 2055, '2022-04-05 22:41:20'),
	(1, 1, 3, 10275, 2055, '2022-04-05 22:41:25'),
	(1, 1, 3, 10424, 1737, '2022-04-05 22:41:31'),
	(1, 1, 3, 4400, 4400, '2022-04-05 22:42:39'),
	(1, 1, 3, 4400, 4400, '2022-04-05 22:43:01'),
	(1, 1, 3, 4400, 4400, '2022-04-05 22:44:43'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:45:00'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:45:52'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:46:01'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:49:48'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:50:23'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:50:31'),
	(1, 1, 3, 5150, 2575, '2022-04-05 22:52:59'),
	(1, 1, 11, 141790, 47263, '2022-04-06 09:49:22'),
	(1, 1, 3, 37190, 18595, '2022-04-06 09:49:53'),
	(1, 1, 3, 37190, 18595, '2022-04-06 09:50:28'),
	(1, 1, 3, 37190, 18595, '2022-04-06 09:52:33'),
	(1, 1, 3, 37190, 18595, '2022-04-06 09:54:17'),
	(1, 1, 3, 37690, 12563, '2022-04-06 09:54:31'),
	(1, 1, 3, 37690, 12563, '2022-04-06 09:54:36'),
	(1, 1, 3, 37690, 12563, '2022-04-06 09:55:23'),
	(1, 1, 3, 37890, 12630, '2022-04-06 09:55:31'),
	(1, 1, 3, 37890, 12630, '2022-04-06 09:55:34'),
	(1, 1, 3, 37890, 12630, '2022-04-06 09:55:46'),
	(1, 1, 3, 37890, 12630, '2022-04-06 09:56:01'),
	(1, 1, 3, 37990, 12663, '2022-04-06 09:56:08'),
	(1, 1, 3, 37990, 12663, '2022-04-06 09:56:10'),
	(27, 2, 1, 8773.99, 1755, '2022-04-06 10:02:45'),
	(27, 2, 12, 5673.99, 1135, '2022-04-06 10:03:22'),
	(27, 2, 12, 6498.99, 1300, '2022-04-06 10:03:41'),
	(1, 1, 8, 446.97, 447, '2022-04-06 10:05:40'),
	(27, 2, 8, 898.99, 450, '2022-04-06 11:18:06'),
	(27, 2, 8, 898.99, 450, '2022-04-06 11:26:08'),
	(27, 2, 8, 898.99, 450, '2022-04-10 14:00:42'),
	(27, 2, 1, 1598.99, 533, '2022-04-10 14:00:59');
/*!40000 ALTER TABLE `statsutilisateur` ENABLE KEYS */;

-- Listage de la structure de la table robin3. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `loginUtilisateur` varchar(50) DEFAULT NULL,
  `passUtilisateur` varchar(50) DEFAULT NULL,
  `nomUtilisateur` varchar(100) DEFAULT NULL,
  `prenomUtilisateur` varchar(100) DEFAULT NULL,
  `emailUtilisateur` varchar(150) DEFAULT NULL,
  `telUtilisateur` varchar(50) DEFAULT NULL,
  `adresseRueUtilisateur` varchar(100) DEFAULT NULL,
  `adresseCpUtilisateur` int(11) DEFAULT NULL,
  `adresseVilleUtilisateur` varchar(100) DEFAULT NULL,
  `adresseIpUtilisateur` varchar(50) DEFAULT NULL,
  `isAdmin` bit(1) NOT NULL DEFAULT b'0',
  `otpCode` int(11) DEFAULT '0',
  `isSubcribed` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

-- Listage des données de la table robin3.utilisateur : ~103 rows (environ)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` (`idUtilisateur`, `loginUtilisateur`, `passUtilisateur`, `nomUtilisateur`, `prenomUtilisateur`, `emailUtilisateur`, `telUtilisateur`, `adresseRueUtilisateur`, `adresseCpUtilisateur`, `adresseVilleUtilisateur`, `adresseIpUtilisateur`, `isAdmin`, `otpCode`, `isSubcribed`) VALUES
	(1, 'unknow.r', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'UNKNOWN', 'Hugo', 'example@gmail.com', '0685587741', '9 Rue Des Bloch', 77000, 'Paris', '127.0.0.1', b'1', 363445, 1),
	(2, 'sabine.duval', 'db16f51c4fd4788f21a397c2e3cb5b9b684c02f8', 'DUVAL', 'Sabine', 'sabine.duval@laporte.org', '0600086214', '89 Chemin Denise Robert', 31195, 'Langloisnec', '91.103.172.207', b'0', 0, 0),
	(3, 'eleonore.foucher', '7ecdf9243d155363bb716e9a30d927563bb2f0c3', 'FOUCHER', 'Éléonore', 'éléonore.foucher@clerc.fr', '0640305109', '16 Chemin Guillon', 81398, 'Mendès-sur-Barthelemy', '187.113.25.211', b'0', 0, 1),
	(4, 'alexandrie.dias', 'e68a7ecd651ea5ea9904a4e518b02570552554d8', 'DIAS', 'Alexandrie', 'alexandrie.dias@bertin.fr', '0681942747', '09 Chemin De Rossi', 94078, 'BarbeBourg', '134.126.90.44', b'0', 0, 1),
	(5, 'isaac.allard', '6bbe8a16e99edd50cdb34cf70354a02206e1e587', 'ALLARD', 'Isaac', 'isaac.allard@weiss.com', '0608286125', '78 Boulevard Allain', 90064, 'Joseph', '37.62.114.56', b'0', 0, 1),
	(6, 'charlotte.gonzalez', '183ce522125a3cd426b9714d610711e93711f841', 'GONZALEZ', 'Charlotte', 'charlotte.gonzalez@techer.fr', '0644845796', '28 Chemin Pires', 66919, 'Devauxnec', '210.215.182.173', b'0', 0, 1),
	(7, 'sebastien.fournier', 'c3420a9ee0b7924a86ca25ad4104bc01d8d7ae2f', 'FOURNIER', 'Sébastien', 'sébastien.fournier@da.fr', '0602137915', '60 Chemin Colin', 44192, 'Joly-les-Bains', '203.224.61.235', b'0', 0, 0),
	(8, 'margaret.foucher', 'a96a945890e147db3d0b3e4e4e4a4ae190b72574', 'FOUCHER', 'Margaret', 'margaret.foucher@mathieu.com', '0659063945', '78 Rue Patricia Pierre', 36634, 'Saint Valérie', '159.161.229.98', b'0', 0, 0),
	(9, 'eugene.marques', 'c2784b7245028aa2bde670948ba1fdcd8c985c84', 'MARQUES', 'Eugène', 'eugène.marques@petitjean.fr', '0663433831', '98 Rue Joly', 92346, 'Clément-les-Bains', '113.45.15.46', b'0', 0, 1),
	(10, 'jacques.hubert', '8631804414f8492754b72734fe85bbeed19584e7', 'HUBERT', 'Jacques', 'jacques.hubert@hubert.fr', '0611674723', '11 Avenue Lucie Lecomte', 31368, 'Duhamel-sur-Guichard', '161.168.144.131', b'0', 0, 1),
	(11, 'tristan.cohen', 'a056501393ae37cbe8067b7feb97c8991ffdc42c', 'COHEN', 'Tristan', 'tristan.cohen@fouquet.com', '0606867513', '72 Boulevard Dupont', 13539, 'Delannoy', '133.71.114.31', b'0', 0, 1),
	(12, 'arnaude.francois', 'fcb2c5d8603ab246aa9965aca3337fe9eb2c138a', 'FRANÇOIS', 'Arnaude', 'arnaude.françois@leduc.fr', '0691889619', '18 Rue Maurice', 46920, 'Baron', '131.9.214.135', b'0', 0, 1),
	(13, 'auguste.carlier', 'f301cf97f8867a57724bed831c52caf39100e72e', 'CARLIER', 'Auguste', 'auguste.carlier@parent.com', '0686511284', '35 Rue De Philippe', 31045, 'Benoitboeuf', '212.244.2.95', b'0', 0, 1),
	(14, 'denis.denis', '5f43e8b7913c9702b5c825bb1a292850fb05218e', 'DENIS', 'Denis', 'denis.denis@delmas.com', '0604426826', '51 Chemin De Lacroix', 12578, 'Dupréboeuf', '201.126.15.19', b'0', 0, 1),
	(15, 'christophe.marchal', '8074d96cf3bc0a9a612022067e178fd2590f85c2', 'MARCHAL', 'Christophe', 'christophe.marchal@tessier.fr', '0680968332', '77 Chemin Teixeira', 23848, 'Schneider', '197.176.128.100', b'0', 0, 0),
	(16, 'valentine.boutin', 'ede8a609eb17d6b7405d71626419992865b9c64b', 'BOUTIN', 'Valentine', 'valentine.boutin@fischer.org', '0661142610', '02 Rue Caroline Guillot', 30457, 'Huet', '209.254.130.209', b'0', 0, 1),
	(17, 'frederique.normand', 'fe94f7900516bddc0eff5cc19982dbd69d18d129', 'NORMAND', 'Frédérique', 'frédérique.normand@renaud.com', '0668598056', '46 Rue Torres', 25299, 'Chrétien-la-Forêt', '142.111.8.240', b'0', 0, 0),
	(18, 'alice.diallo', 'a77a57bcb218bae489953f23c72bba830bb8d9ee', 'DIALLO', 'Alice', 'alice.diallo@schmitt.com', '0647201058', '98 Rue Adèle Becker', 59519, 'Delattre-sur-Mer', '123.235.55.246', b'0', 0, 1),
	(19, 'etienne.pascal', '19666940219002d60524d627f87b8aba9f908de0', 'PASCAL', 'Étienne', 'étienne.pascal@renard.com', '0683148544', '08 Avenue Anaïs Hebert', 61753, 'Torres', '202.13.58.244', b'0', 0, 0),
	(20, 'louis.vincent', 'e6973cf056f2af2cb2b544d1934430a6c5ac731d', 'VINCENT', 'Louis', 'louis.vincent@rousseau.org', '0693653581', '18 Chemin Arthur François', 16976, 'Voisin-sur-Mer', '217.231.61.99', b'0', 0, 0),
	(21, 'odette.bertrand', '889f6636e72b540ae918b8c7d2a52826ec92532d', 'BERTRAND', 'Odette', 'odette.bertrand@guerin.fr', '0631961287', '31 Chemin Marine Berger', 73803, 'Lacroix-la-Forêt', '199.162.163.180', b'0', 0, 1),
	(22, 'aurore.coulon', '06705a0cf97755ca3f2f9e0589d2a28a0c9c973c', 'COULON', 'Aurore', 'aurore.coulon@robin.org', '0605576725', '66 Boulevard De Gosselin', 62528, 'Dupuis-les-Bains', '211.69.88.120', b'0', 0, 1),
	(23, 'pauline.remy', '0ab8148893b6c16eee72cf360d61930f5c66ec9e', 'RÉMY', 'Pauline', 'pauline.rémy@petitjean.org', '0612594583', '18 Rue Leroux', 6312, 'Brunetdan', '211.4.149.165', b'0', 0, 1),
	(24, 'timothee.guillou', '9d9af7c843608c253178087f67b1e4d2232c2598', 'GUILLOU', 'Timothée', 'timothée.guillou@dias.com', '0633653285', '97 Boulevard Yves Rivière', 18259, 'Meyer', '214.25.116.246', b'0', 0, 0),
	(25, 'simone.le roux', 'd9babc9a55ea5d95c8d652ba0cdfb805e3cbd372', 'LE ROUX', 'Simone', 'simone.le roux@neveu.com', '0695577964', '79 Boulevard Munoz', 10791, 'Maury', '215.89.254.229', b'0', 0, 1),
	(26, 'elodie.lebreton', 'c05f17e7d327a9616df7034cb09b9247952304dc', 'LEBRETON', 'Élodie', 'élodie.lebreton@carpentier.com', '0661823457', '25 Avenue Teixeira', 7457, 'Mace', '172.89.13.158', b'0', 0, 1),
	(27, 'jerome.colin', 'ba217f6afdaaad6c6571973a31ba20603263cb97', 'COLIN', 'Jérôme', 'jérôme.colin@coulon.com', '0699835205', '86 Chemin De Costa', 38994, 'Texier', '199.223.171.75', b'0', 0, 1),
	(28, 'edouard.hamel', '841f6ed63b4f3b78934e1b01b4e802539a148c29', 'HAMEL', 'Édouard', 'édouard.hamel@dubois.fr', '0692485336', '63 Rue De François', 1272, 'Saint Marguerite', '138.49.177.143', b'0', 0, 1),
	(29, 'elise.colas', '44d920329a4882f2eb76e77b16c7f25771f8d834', 'COLAS', 'Élise', 'élise.colas@bigot.fr', '0627298188', '76 Rue Alphonse Pons', 43344, 'Sainte ChristelleBourg', '207.105.194.22', b'0', 0, 0),
	(30, 'jean.pasquier', '10304224bbb5a038dbde61814b2bf727c2d5d88b', 'PASQUIER', 'Jean', 'jean.pasquier@barbier.fr', '0619781424', '72 Rue De Martins', 82643, 'Fouquet-la-Forêt', '8.50.39.12', b'0', 0, 0),
	(31, 'catherine.moreno', '9f2bac1feb9c11b7ddb219356a76a579be2993f7', 'MORENO', 'Catherine', 'catherine.moreno@fontaine.org', '0626294927', '74 Rue De Robert', 36734, 'Munoz', '185.229.218.149', b'0', 0, 0),
	(32, 'augustin.parent', '752f668d87f0ec9d29f5c74a92f24b94aedc5431', 'PARENT', 'Augustin', 'augustin.parent@bonnin.com', '0611265578', '00 Boulevard De Lesage', 34232, 'Lemaître', '203.197.121.86', b'0', 0, 0),
	(33, 'alexandrie.costa', '32319f7fcd253bfdb61317a71ba9376623d0a49e', 'COSTA', 'Alexandrie', 'alexandrie.costa@vaillant.fr', '0650599269', '34 Rue Élodie Germain', 66102, 'Lévy', '99.170.45.25', b'0', 0, 0),
	(34, 'colette.riviere', '4ab60d5d81300257999ba7bbc22e5c9d1b6e6216', 'RIVIÈRE', 'Colette', 'colette.rivière@da.org', '0656628634', '34 Boulevard Benoit', 15238, 'Legrand', '91.147.217.81', b'0', 0, 0),
	(35, 'josette.ruiz', 'bd164009f9592118820d215092e70b7dc1751bd5', 'RUIZ', 'Josette', 'josette.ruiz@martinez.com', '0610604786', '55 Boulevard Guillaume Dumas', 73542, 'Masson', '162.65.254.123', b'0', 0, 1),
	(36, 'christine.rousseau', '78177c8eaa5b28b33613e05ae1a5da2dc397a3d8', 'ROUSSEAU', 'Christine', 'christine.rousseau@huet.fr', '0617773463', '00 Avenue Patrick David', 15168, 'Jolydan', '152.117.97.32', b'0', 0, 0),
	(37, 'daniel.de oliveira', '1850cab1e8782215dbfea4b37f0b5f852aca039b', 'DE OLIVEIRA', 'Daniel', 'daniel.de oliveira@labbe.net', '0607503949', '97 Boulevard François', 7627, 'Valentin', '180.175.217.242', b'0', 0, 0),
	(38, 'lucas.buisson', 'c78f9c8332553807079d5c72b885ccc4999a7b88', 'BUISSON', 'Lucas', 'lucas.buisson@royer.com', '0609998067', '22 Chemin De Seguin', 53261, 'Marin-sur-Guyot', '223.114.49.43', b'0', 0, 0),
	(39, 'margot.blot', '15003eb65a380570fe356ee5c2415fa96cd87800', 'BLOT', 'Margot', 'margot.blot@lemaire.com', '0600329875', '91 Rue Aurore Ferrand', 84493, 'Sainte Claudine-sur-Mer', '159.180.121.86', b'0', 0, 0),
	(40, 'philippine.roger', 'd36d8ddf0b892e142fa0f1736dadc366eb376167', 'ROGER', 'Philippine', 'philippine.roger@bigot.com', '0655159517', '70 Chemin De Cordier', 71328, 'Saint Adélaïde', '88.35.149.204', b'0', 0, 1),
	(41, 'jeannine.barbier', 'd031e574d070eee353db8e42c6bb9c4c4a86fb3f', 'BARBIER', 'Jeannine', 'jeannine.barbier@alves.fr', '0694594273', '72 Chemin De Faivre', 70043, 'Daniel', '166.135.83.155', b'0', 0, 1),
	(42, 'lucie.guillot', '59c846bce6d83a20390c9d4b0fde4b4d2fafe2ef', 'GUILLOT', 'Lucie', 'lucie.guillot@chauvin.fr', '0691165622', '44 Avenue De Bonnin', 4216, 'Verdier-la-Forêt', '216.38.41.97', b'0', 0, 1),
	(43, 'julie.perret', '411e718588197be9533afe763f90e02c8a1835c4', 'PERRET', 'Julie', 'julie.perret@andre.com', '0668744424', '68 Boulevard De Dufour', 12421, 'Leroux', '57.9.96.245', b'0', 0, 0),
	(44, 'guillaume.gros', 'ec0a3f81eb21d425137df9608cff2570087fdc4d', 'GROS', 'Guillaume', 'guillaume.gros@raynaud.fr', '0669402071', '31 Avenue De Lefèvre', 72326, 'Marchandnec', '160.229.214.122', b'0', 0, 1),
	(45, 'yves.faivre', 'a8023ac23246c3d18e878a5eaa263808e4c134cb', 'FAIVRE', 'Yves', 'yves.faivre@dupuis.fr', '0689303666', '56 Avenue Raymond David', 11452, 'Cousin-sur-Renaud', '31.238.176.240', b'0', 0, 0),
	(46, 'gilbert.martinez', '6a5a5d89c54891a2cb4e71cc93f87f243be2af6c', 'MARTINEZ', 'Gilbert', 'gilbert.martinez@labbe.com', '0665281604', '24 Chemin Fouquet', 53809, 'MilletVille', '8.19.245.222', b'0', 0, 1),
	(47, 'alfred.boucher', '122afe08a00e17930ae11f1b025ffc3bb590b628', 'BOUCHER', 'Alfred', 'alfred.boucher@alves.net', '0622115265', '81 Avenue Élisabeth Da Silva', 5258, 'Huet', '181.24.5.13', b'0', 0, 1),
	(48, 'alain.bourgeois', '0cbd7dbbf4aea4bc852eda22f5629f3f21d3ac83', 'BOURGEOIS', 'Alain', 'alain.bourgeois@blanchard.com', '0651875097', '77 Boulevard Torres', 47446, 'Sainte Julien', '16.9.42.214', b'0', 0, 0),
	(49, 'marine.delmas', '9e31f12c9c340943ae27071ad61f9167fd3a002b', 'DELMAS', 'Marine', 'marine.delmas@goncalves.org', '0629424343', '07 Chemin Sophie Evrard', 49333, 'EvrardBourg', '191.166.49.89', b'0', 0, 1),
	(50, 'jeanne.faure', 'c71b020da5d39fdc18868592eea537701a02cd1d', 'FAURE', 'Jeanne', 'jeanne.faure@chartier.net', '0629066804', '92 Chemin De Roy', 17305, 'Barthelemy-sur-Martin', '34.95.76.50', b'0', 0, 0),
	(51, 'rene.courtois', 'a3dbdba606069eea6954bfa616b6078ec2457bc9', 'COURTOIS', 'René', 'rené.courtois@bernard.fr', '0606097071', '97 Rue De Guillot', 47201, 'Cohen', '103.82.160.70', b'0', 0, 0),
	(52, 'celina.benoit', '4b324da21bddf98d56689097bbdc1111ff482e52', 'BENOIT', 'Célina', 'célina.benoit@arnaud.net', '0672038340', '88 Avenue Bernard', 99457, 'Saint Adélaïde', '107.128.133.15', b'0', 0, 1),
	(53, 'josephine.robert', '5bc8588e1fc7470a9ab9c5c137aa93bc695acf89', 'ROBERT', 'Joséphine', 'joséphine.robert@dijoux.fr', '0657662078', '23 Avenue De Normand', 86916, 'Berger', '211.39.214.113', b'0', 0, 0),
	(54, 'margot.caron', '3681ff831caf338a2d29a25e8cdf4be39ae43396', 'CARON', 'Margot', 'margot.caron@lecomte.com', '0628329575', '03 Avenue Nicolas Raymond', 71709, 'Fernandeznec', '40.229.170.102', b'0', 0, 0),
	(55, 'corinne.maurice', '851a8311b0e0bceec7a3367ac09d38fd51ded567', 'MAURICE', 'Corinne', 'corinne.maurice@michaud.com', '0620360616', '34 Avenue De Bruneau', 55044, 'Michaud', '168.219.87.129', b'0', 0, 0),
	(56, 'susan.bonnin', 'e22704e588bd95ff342b44dc539d5afc04d57bfe', 'BONNIN', 'Susan', 'susan.bonnin@blanchard.net', '0666552690', '54 Avenue De Lagarde', 9048, 'Pichon', '73.179.107.206', b'0', 0, 1),
	(57, 'marcelle.herve', '0f29b4e323fd91e6d15df4f280ba05a28477b60f', 'HERVÉ', 'Marcelle', 'marcelle.hervé@mary.com', '0679024055', '49 Avenue Ollivier', 509, 'Chauvetnec', '199.6.22.221', b'0', 0, 0),
	(58, 'noemi.boyer', 'd28a47feda6fd0c72897eb00052f8ae198899ab7', 'BOYER', 'Noémi', 'noémi.boyer@marion.org', '0683303679', '43 Avenue Simone Bruneau', 85522, 'Deschamps', '135.10.227.91', b'0', 0, 1),
	(59, 'aimee.leclercq', 'a96e29766f2bc9a55c3072f8ed00bd28f8656a59', 'LECLERCQ', 'Aimée', 'aimée.leclercq@louis.com', '0626750154', '72 Avenue Bodin', 93926, 'Leblanc', '86.175.131.11', b'0', 0, 0),
	(60, 'jerome.etienne', 'bc9a10c1ee7d64d362dbe8717a1a0c412a57765c', 'ÉTIENNE', 'Jérôme', 'jérôme.étienne@clerc.fr', '0626206561', '00 Chemin Caron', 88853, 'DialloVille', '2.121.218.199', b'0', 0, 1),
	(61, 'claire.legendre', '543e16c7fda0ad21f62085df55c83b0b26b4e919', 'LEGENDRE', 'Claire', 'claire.legendre@dumas.org', '0656763316', '56 Avenue Bernadette Vallée', 41146, 'Guyot', '53.195.190.50', b'0', 0, 0),
	(62, 'odette.lopes', '0379618247b86a8de1206747cf293fdde381f8e2', 'LOPES', 'Odette', 'odette.lopes@chevallier.com', '0697493269', '94 Avenue Renaud', 73616, 'Daviddan', '214.66.214.62', b'0', 0, 0),
	(63, 'margaret.bourgeois', '4f3cc82cfaa4ee79a6434165f30a47725a546e27', 'BOURGEOIS', 'Margaret', 'margaret.bourgeois@pascal.com', '0610962667', '14 Rue Didier', 56130, 'Guibert', '21.164.66.195', b'0', 0, 1),
	(64, 'sabine.lemoine', 'f44d2078a10215d1e81f2966df3eb93d9db5c8b1', 'LEMOINE', 'Sabine', 'sabine.lemoine@marechal.fr', '0620792946', '51 Chemin Paul', 28194, 'Blinnec', '214.252.81.248', b'0', 0, 1),
	(65, 'aimee.bourgeois', '76667627217dc5672ec31f135a639a4a555a3a14', 'BOURGEOIS', 'Aimée', 'aimée.bourgeois@roux.com', '0698298627', '79 Rue De Renaud', 11118, 'Sainte Luc', '178.227.118.132', b'0', 0, 1),
	(66, 'david.jacquet', 'f22c1ba32de4ca85876c12cab05c3d4ee912faed', 'JACQUET', 'David', 'david.jacquet@schneider.com', '0667695123', '54 Avenue Victoire Gros', 67827, 'Dupré', '189.99.32.158', b'0', 0, 1),
	(67, 'antoine.pierre', 'fb3cd5c8017d4203c4cf52a2363f3c388e5841f1', 'PIERRE', 'Antoine', 'antoine.pierre@dos.com', '0670841919', '49 Chemin Dubois', 1347, 'Saint Louise', '150.102.76.226', b'0', 0, 1),
	(68, 'josephine.descamps', '8c9509bff338dad02eb0fce824fc82c88bf7de41', 'DESCAMPS', 'Joséphine', 'joséphine.descamps@fischer.org', '0680016914', '35 Avenue De Voisin', 23183, 'PiresVille', '23.71.207.50', b'0', 0, 0),
	(69, 'philippine.hamel', '5ce37341cda248b122eede9d2e69a383c1b7f7b0', 'HAMEL', 'Philippine', 'philippine.hamel@marchand.net', '0600853332', '38 Rue De Fontaine', 36055, 'Clerc', '169.204.133.147', b'0', 0, 0),
	(70, 'josette.delattre', '2bed337ae1f194f3b57d17c349adbe1ef6a5184e', 'DELATTRE', 'Josette', 'josette.delattre@aubry.com', '0643531656', '53 Rue Christiane Paris', 8684, 'Hamelnec', '145.159.193.101', b'0', 0, 1),
	(71, 'sylvie.chartier', '96afa9280b43cc9d7dadd96252c60f93f492fa9e', 'CHARTIER', 'Sylvie', 'sylvie.chartier@gerard.com', '0651010155', '69 Rue De Klein', 13205, 'Lecomteboeuf', '103.165.239.116', b'0', 0, 0),
	(72, 'susan.perez', '91c89b56e32a51249a4a705a88befbbe349d02f3', 'PEREZ', 'Susan', 'susan.perez@laroche.com', '0630509220', '15 Chemin Étienne', 43376, 'Picard', '198.60.201.252', b'0', 0, 0),
	(73, 'antoine.lacombe', 'c024786498855ac60da55b82d1c61404af2a79e0', 'LACOMBE', 'Antoine', 'antoine.lacombe@martel.com', '0605045223', '54 Rue Morvan', 57076, 'Leblanc', '181.18.223.173', b'0', 0, 1),
	(74, 'aurore.coste', '2ea541bbf7e82b9af5e1e3034f6d8e063f57a1c5', 'COSTE', 'Aurore', 'aurore.coste@merle.com', '0660751405', '79 Chemin De Brun', 21780, 'Giraud', '54.180.24.114', b'0', 0, 1),
	(75, 'charlotte.sanchez', '2c65ea59c0646270b5514b68ba87114a85114683', 'SANCHEZ', 'Charlotte', 'charlotte.sanchez@masson.net', '0653105492', '08 Boulevard Barbe', 14900, 'Henry', '199.89.225.124', b'0', 0, 1),
	(76, 'adele.gay', 'd51448738890d2ec806c27c7737549d4cb01e73b', 'GAY', 'Adèle', 'adèle.gay@imbert.org', '0692623394', '73 Rue Martel', 95958, 'JacobVille', '61.88.133.238', b'0', 0, 1),
	(77, 'frederique.weber', '9ffbff538542495ea91f136d0c0a82b1f2845660', 'WEBER', 'Frédérique', 'frédérique.weber@vallee.org', '0640894468', '92 Rue Mendès', 61464, 'Rémy-sur-Collet', '112.23.135.102', b'0', 0, 0),
	(78, 'eric.verdier', 'de982c51a36e4fc9518ab0d214352dd80e466f6d', 'VERDIER', 'Éric', 'éric.verdier@verdier.org', '0659426330', '81 Chemin De Berthelot', 1665, 'ValléeBourg', '192.25.189.97', b'0', 0, 1),
	(79, 'jeanne.maurice', 'db65d39cc80e8ed60a6c382e6fa573b2d13fca66', 'MAURICE', 'Jeanne', 'jeanne.maurice@dupuis.fr', '0637019960', '71 Rue Leduc', 74259, 'DupuisBourg', '189.119.19.217', b'0', 0, 0),
	(80, 'nicole.gay', '58cd2af6388be19a85d0d4b031a6fa0b04e8c6a1', 'GAY', 'Nicole', 'nicole.gay@francois.com', '0618513860', '53 Chemin Grenier', 68771, 'Sainte Annenec', '186.220.119.9', b'0', 0, 1),
	(81, 'agathe.poirier', 'd22691ace54fbb890db1557ab4d8e59ec794af21', 'POIRIER', 'Agathe', 'agathe.poirier@vaillant.fr', '0620815516', '50 Chemin Joseph Dijoux', 62836, 'Lemaître-sur-Mer', '86.124.169.201', b'0', 0, 0),
	(82, 'margaud.gomes', 'a47db93f6594e3a750777c76313c264b54a3a28f', 'GOMES', 'Margaud', 'margaud.gomes@huet.com', '0686305084', '54 Rue Le Goff', 91411, 'Sainte Élodie-la-Forêt', '96.54.133.231', b'0', 0, 1),
	(83, 'anouk.tanguy', 'eda3ac6cf6483a42e42a00684ee6f4002c7f4271', 'TANGUY', 'Anouk', 'anouk.tanguy@legrand.com', '0618760742', '16 Avenue De Nicolas', 8076, 'Marchal', '151.252.186.152', b'0', 0, 0),
	(84, 'alix.lemaitre', '3a01a18c2026170e3448fbe2b1049c6de66f8a1c', 'LEMAÎTRE', 'Alix', 'alix.lemaître@andre.org', '0643816402', '76 Rue Richard', 76494, 'Grégoiredan', '219.142.40.213', b'0', 0, 1),
	(85, 'philippine.diaz', 'fd1f6cb4783507c7ef6ef38c4d123e7679166bd4', 'DIAZ', 'Philippine', 'philippine.diaz@lacombe.com', '0659223322', '08 Avenue De Leconte', 84649, 'Maury', '159.234.97.189', b'0', 0, 0),
	(86, 'eric.blanc', '9c04000a7b5575ed40927980dd2ee441f1155937', 'BLANC', 'Éric', 'éric.blanc@paris.fr', '0685634348', '69 Avenue Thibault Ruiz', 89740, 'Lebreton', '66.45.134.2', b'0', 0, 1),
	(87, 'tristan.lefort', '8a4ec2721487299983e9cb8eb45153b3dc8faa87', 'LEFORT', 'Tristan', 'tristan.lefort@aubry.com', '0629240038', '53 Boulevard Maillard', 84783, 'Saint StéphanieBourg', '218.244.60.23', b'0', 0, 1),
	(88, 'agnes.charles', '1c830a6cba01b27fd8e87c0814444eb90ca83fc0', 'CHARLES', 'Agnès', 'agnès.charles@sauvage.fr', '0671988581', '07 Boulevard Gauthier', 77498, 'Labbé', '86.111.196.109', b'0', 0, 1),
	(89, 'valentine.petitjean', '8fcfd18fe98a420fe794c640c59db427babc693e', 'PETITJEAN', 'Valentine', 'valentine.petitjean@lamy.fr', '0643986693', '79 Rue Bourgeois', 38703, 'Verdier', '144.232.168.205', b'0', 0, 1),
	(90, 'eugene.ramos', '3a59cd11dbe72e49cee1cc77e04a00ae87f55003', 'RAMOS', 'Eugène', 'eugène.ramos@peron.com', '0601395819', '66 Avenue Léger', 73176, 'Sainte AliceBourg', '130.208.180.61', b'0', 0, 0),
	(91, 'genevieve.duhamel', 'c38234a44e46fb887c96023e16721446d29f3638', 'DUHAMEL', 'Geneviève', 'geneviève.duhamel@chevalier.fr', '0612676923', '81 Boulevard De Sanchez', 82451, 'Renard', '185.142.50.38', b'0', 0, 1),
	(92, 'emile.girard', 'a8ff3f222161d6cae5129215e81659690b779727', 'GIRARD', 'Émile', 'émile.girard@raynaud.fr', '0650908183', '83 Rue Constance Masse', 42114, 'Joubert', '164.235.88.211', b'0', 0, 1),
	(93, 'maurice.dumas', '63fa0a7d194e6788b2d3a41f45028bf9c432a77d', 'DUMAS', 'Maurice', 'maurice.dumas@gallet.fr', '0640467527', '24 Rue De Bonnin', 10121, 'MarieBourg', '212.192.86.131', b'0', 0, 0),
	(94, 'bernadette.maury', '7d0fd17e04a176c472c2a5f56230dc5ee10046af', 'MAURY', 'Bernadette', 'bernadette.maury@leroux.com', '0675052894', '41 Boulevard Maryse Baudry', 59122, 'Gérard', '172.119.220.247', b'0', 0, 1),
	(95, 'isabelle.torres', 'f005db2f9ae557807dd45d5ea7e553467de9e688', 'TORRES', 'Isabelle', 'isabelle.torres@raymond.net', '0603491776', '69 Chemin Barbier', 80368, 'Berger-les-Bains', '215.230.234.109', b'0', 0, 1),
	(96, 'maryse.jacquot', '65f76e2411cc24b632fec29f1c07b254d1df21f3', 'JACQUOT', 'Maryse', 'maryse.jacquot@picard.fr', '0665560875', '49 Chemin Andrée Grenier', 31898, 'Bodin-les-Bains', '222.103.127.48', b'0', 0, 1),
	(97, 'claude.paul', '34a5f2c4f7fed132cc974504bb38089164e808d8', 'PAUL', 'Claude', 'claude.paul@le.fr', '0601541309', '22 Avenue Nicole Delmas', 31937, 'Hardy-sur-Mer', '179.42.184.86', b'0', 0, 0),
	(98, 'gabrielle.laroche', 'b309f68871101cdad272bc5b461d4082f9dbd64e', 'LAROCHE', 'Gabrielle', 'gabrielle.laroche@mercier.fr', '0677906176', '43 Avenue Frédérique Joubert', 87749, 'RossiBourg', '110.164.94.165', b'0', 0, 0),
	(99, 'marine.gregoire', '75056a4e0ef12eeff4d12d9c520139bd21f686dd', 'GRÉGOIRE', 'Marine', 'marine.grégoire@marie.com', '0614273431', '67 Rue Diallo', 78645, 'Toussaint', '168.69.245.220', b'0', 0, 1),
	(100, 'adele.legros', 'bf517fb70f5c766f2980369e001693746ae1799f', 'LEGROS', 'Adèle', 'adèle.legros@laporte.net', '0637204168', '02 Rue Delahaye', 59052, 'Sainte Jeanninedan', '212.159.195.242', b'0', 0, 0),
	(101, 'christine.charpentier', '4f5c105d906bf3c16bf0993989dc053e8f11e185', 'CHARPENTIER', 'Christine', 'christine.charpentier@thierry.com', '0698789192', '36 Boulevard Breton', 88503, 'Saint Thibaut-la-Forêt', '203.125.13.246', b'0', 0, 1),
	(102, 'olivier.albert', 'e267060b0f8b973b5afac2c08aeaf3a91bf51d2e', 'ALBERT', 'Olivier', 'olivier.albert@gmail.com', '0620045069', '30 Rue De La Girouette', 34410, 'Sérignan', '127.0.0.1', b'1', 0, 1),
	(103, 'bruno.rouchon', '696ffbfdc395bbbba48dd7932f23d031b657a596', 'ROUCHON', 'Bruno', 'bruno.rouchon@gmail.com', '0658962512', '437 Rue Des Apothicaires', 34090, 'Montpellier', '127.0.0.1', b'1', 0, 1);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

-- Listage de la structure de déclencheur robin3. !incrementeCaCategorieInsert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER';
DELIMITER //
CREATE TRIGGER `!incrementeCaCategorieInsert` BEFORE INSERT ON `lignedecommande`
 FOR EACH ROW ### Déclencheur incrémentant à chaque nouvelle commande de produit un chiffre d’affaires pour la catégorie du produit concerné.

BEGIN
DECLARE myIdCategorie INT;
DECLARE myPrixHTProduit DOUBLE;
DECLARE myQteProduit INT;

SET myIdCategorie = (SELECT idCat FROM produit WHERE (idProduit = NEW.idProduit));
SET myPrixHTProduit = (SELECT PrixHTProduit FROM produit WHERE (idProduit = NEW.idProduit));
SET myQteProduit = NEW.QuantiteCom;

UPDATE categorie SET CaCategorie = (CaCategorie + (myPrixHTProduit*myQteProduit)) WHERE (idCategorie = myIdCategorie);

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !updateQteStockByProduit
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER';
DELIMITER //
CREATE TRIGGER `!updateQteStockByProduit` BEFORE INSERT ON `lignedecommande` FOR EACH ROW ### Déclencheur modifiant la quantité en stock lors de l'insertion d'un nouveau produit dans une commande, soustrait enlève à la quantité en stock du produit la quantité commander.

BEGIN

DECLARE myQteCom INT;
DECLARE myIdProduit INT;

SET myQteCom = NEW.QuantiteCom;
SET myIdProduit = NEW.idProduit;

UPDATE produit SET QteStockProduit = (QteStockProduit - myQteCom) WHERE (idProduit = myIdProduit);

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !updateStatsUtilisateur
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER';
DELIMITER //
CREATE TRIGGER `!updateStatsUtilisateur` BEFORE INSERT ON `lignedecommande` FOR EACH ROW ## Déclencheur fesant un update dans la table statsutilisateur à chaque insert dans la table lignedecommande.

BEGIN

DECLARE myIdUtilisateur INTEGER;
DECLARE myIdProduitPlusCommander INTEGER;
DECLARE myMontantTotalCommander FLOAT;
DECLARE myMontantMoyenneCommande FLOAT;
DECLARE myNbCommandeTotal INT;
DECLARE myDate VARCHAR(20);

## Récupère l'id utilisateur associé à la ligne de commande insérer.
SET myIdUtilisateur = (SELECT commande.idUtilisateur FROM commande WHERE commande.idCommande = NEW.idCommande);

## Récupère l'id du produit le plus commander par l'utilisateur (Appel la fonction stockée)
SET myIdProduitPlusCommander =`!GetProduitPlusCommanderByClient`(myIdUtilisateur);

## Récupère le montant total de toutes ces commandes (somme) par l'utilisateur (Appel la fonction stockée)
SET myMontantTotalCommander = `!GetMontantTotalAllCommande`(myIdUtilisateur);

## Récupère le nombre total du commande par l'utilisateur. (Appel de la fonction stockée)
SET myNbCommandeTotal = `!GetNbCommandeByClient`(myIdUtilisateur);


## Récupère la moyenne dépensé pour une commande par l'utilisateur.
SET myMontantMoyenneCommande = `!GetMontantMoyenneAllCommande`(myIdUtilisateur);


## Récupère la date du jour (nécéssaire pour effectuer un historique)
SET myDate = (SELECT NOW());

## Insertion dans la table statsutilisateur
INSERT INTO statsutilisateur VALUES (myIdUtilisateur, myNbCommandeTotal, myIdProduitPlusCommander, myMontantTotalCommander, myMontantMoyenneCommande, myDate);

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !verifClientInsert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER';
DELIMITER //
CREATE TRIGGER `!verifClientInsert` BEFORE INSERT ON `utilisateur` FOR EACH ROW ### Déclencheur gérant les majuscules et minuscules sur certains champs lors d’une insertion.

SET
NEW.nomUtilisateur = UPPER(NEW.nomUtilisateur),
NEW.prenomUtilisateur = CONCAT( UPPER( LEFT(NEW.prenomUtilisateur,1)) , LOWER( SUBSTR( NEW.prenomUtilisateur,2))),
NEW.adresseRueUtilisateur = `!GetCapitalize`(NEW.adresseRueUtilisateur)//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !verifClientUpdate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER';
DELIMITER //
CREATE TRIGGER `!verifClientUpdate` BEFORE UPDATE ON `utilisateur` FOR EACH ROW ### Déclencheur gérant les majuscules et minuscules sur certains champs lors d’une insertion.

SET
NEW.nomUtilisateur = UPPER(NEW.nomUtilisateur),
NEW.prenomUtilisateur = CONCAT( UPPER( LEFT(NEW.prenomUtilisateur,1)) , LOWER( SUBSTR( NEW.prenomUtilisateur,2))),
NEW.adresseRueUtilisateur = `!GetCapitalize`(NEW.adresseRueUtilisateur)//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !verifDateCommande
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER';
DELIMITER //
CREATE TRIGGER `!verifDateCommande` BEFORE INSERT ON `commande` FOR EACH ROW ### Déclencheur vérifiant l'intégrité de la date et le respect du nommage au format JJ/MM/AAAA.

BEGIN

DECLARE myDate VARCHAR(200);
DECLARE myMessage VARCHAR(200);

SET myDate = NEW.DateCommande;

IF (LENGTH(myDate) < 10 OR LENGTH(myDate) > 10)  THEN
SET myMessage = 'Désolé, la commande ne peut pas être insérer car la date que vous avez entré ne  respecte pas le format JJ/MM/AAAA';
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = myMessage;
END IF;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !verifQteCommander
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `!verifQteCommander` BEFORE INSERT ON `lignedecommande` FOR EACH ROW ## Déclencheur permettant de verifier que la quantité commander ne soit pas supérieure à la quantité en stock du produit, sinon déclenche une erreur et n'effectue pas l'insertion.

BEGIN
##DECLARE myQteCom INTEGER;
##DECLARE myQteProduit INTEGER;
##DECLARE myIdProduit INTEGER;
##DECLARE myMessage VARCHAR(200);

##SET myQteCom = NEW.QuantiteCom;
##SET myIdProduit = NEW.idProduit;
##SET myQteProduit = (SELECT produit.QteStockProduit FROM produit WHERE (produit.idProduit = myIdProduit));

##IF (myQteCom > myQteProduit + 1) THEN
##SET myMessage = 'Désolé, vous ne pouvez pas commander ce produit car la quantité que vous voulez commander est supérieure au stock du produit.'; 
##SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = myMessage;
##END IF;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur robin3. !verifSoldeInsert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `!verifSoldeInsert` BEFORE INSERT ON `commande` FOR EACH ROW ### Déclencheur vérifiant que le client à bien payé sa précédente commande avant d'en refaire une nouvelle.

BEGIN
DECLARE myIdClient INTEGER;
DECLARE myCompteur INTEGER;
DECLARE myMessage VARCHAR(100);

SET myIdClient = NEW.idUtilisateur;
SET myCompteur = (SELECT COUNT(commande.isNotSolde) FROM commande WHERE (commande.idUtilisateur = myIdClient) AND (isNotSolde = 1));

IF (myCompteur > 0) THEN
SET myMessage = 'Désolé, vous ne pouvez pas commander car vous n''avez pas fini de payer vos précédentes commandes.';
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = myMessage;
END IF;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
