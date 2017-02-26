<?php

/**** POUR LES REQUETES SQL ****/
function envoyerRequeteSQL ($requeteSQL, $tabToken)
{
    // SE CONNECTER A LA BASE DE DONNEES
    $hostnameDB  = $GLOBALS["hostnameDB"];
    $databaseDB  = $GLOBALS["databaseDB"];
    $userDB      = $GLOBALS["userDB"];
    $passwordDB  = $GLOBALS["passwordDB"];
    $dsn         = "mysql:host=$hostnameDB;dbname=$databaseDB;charset=utf8";
        
    try 
    {
        $objetPDO    = new PDO($dsn, $userDB, $passwordDB);
        
        $objetPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
        $objetPDOStatement = $objetPDO->prepare($requeteSQL);
        
        $objetPDOStatement->execute($tabToken);
        
        $objetPDOStatement->setFetchMode(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
        // AFFICHE LES MESSAGES D'ERREUR DE MYSQL
        echo $e->getMessage();
    }
    
    return $objetPDOStatement;
}


function ajouterLigneTable($nomTable, $tabColVal)
{
    $listeColonne = "";
    $listeToken   = "";

    $separateur   = "";
    foreach($tabColVal as $nomCol => $valeurCol)
    {
        $listeColonne .= "$separateur `$nomCol`";
        $listeToken   .= "$separateur :$nomCol";

        $separateur   = ",";
    }
    $requeteSQL =
<<<CODESQL

INSERT INTO `$nomTable` 
( $listeColonne ) 
VALUES
( $listeToken )
;
CODESQL;


    // ENVOYER LA REQUETE SQL
    $objetPDOStatement = envoyerRequeteSQL($requeteSQL, $tabColVal);

    return $objetPDOStatement;
}

function modifierLigneTable($nomTable, $tabColVal, $valSelecteur, $colSelecteur = 'id')
{
    $listeColToken = "";

    $separateur   = "";
    foreach($tabColVal as $nomCol => $valeurCol)
    {
        $listeColToken .= "$separateur `$nomCol` = :$nomCol";
        
        $separateur = ",";
    }
    
    // ON AJOUTE LE TOKEN POUR LE SELECTEUR DE LA CLAUSE WHERE
    $tabColVal[":w_$colSelecteur"] = $valSelecteur;
    
    $requeteSQL =
<<<CODESQL

UPDATE `$nomTable`
SET
$listeColVal
WHERE
    `$colSelecteur` = :w_$colSelecteur
CODESQL;
    
    // ENVOYER LA REQUETE SQL
    $objetPDOStatement = envoyerRequeteSQL($requeteSQL, $tabColVal);

    return $objetPDOStatement;
}

// PAR DEFAUT, ON VA UTILISER LA FONCTION SUR LA VALEUR DE LA COLONNE id
// MAIS IL EST AUSSI POSSIBLE DE SELECTIONNER SUR LA VALEUR D'UNE AUTRE COLONNE
function deleteLigneTable ($nomTable, $valSelecteur, $colSelecteur = "id")
{
    $requeteSQL =
<<<CODESQL

DELETE `$nomTable`
WHERE
    `$colSelecteur` = :$colSelecteur
CODESQL;
    
    $tabToken = [ "$colSelecteur" => $valSelecteur ];
    
    // ENVOYER LA REQUETE SQL
    $objetPDOStatement = envoyerRequeteSQL($requeteSQL, $tabToken);

    return $objetPDOStatement;

}

function lireLigneTable ($nomTable, $valSelecteur, $colSelecteur = "id")
{
    $requeteSQL =
<<<CODESQL

SELECT * FROM `$nomTable`
WHERE
    `$colSelecteur` = :$colSelecteur
CODESQL;
    
    $tabToken = [ "$colSelecteur" => $valSelecteur ];
    
    // ENVOYER LA REQUETE SQL
    $objetPDOStatement = envoyerRequeteSQL($requeteSQL, $tabToken);

    return $objetPDOStatement;

}


// POUR APPELER LA FONCTION
// $nbTotal = calculerNombreLigne("annonce");
function calculerNombreLigne ($nomTable)
{
    $resultat = 0;
    
    // ON VA CALCULER LE NOMBRE DE LIGNE DANS LA TABLE $nomTable
    // https://sql.sh/fonctions/agregation/count
    $requeteSQL = "SELECT COUNT(id) FROM $nomTable";
    $tabToken = [];
    
    $objetPDOStatement = envoyerRequeteSQL($requeteSQL, $tabToken);
    // http://php.net/manual/fr/pdostatement.fetchcolumn.php
    $resultat = $objetPDOStatement->fetchColumn();
    $resultat = intval($resultat);
    
    return $resultat;
}
