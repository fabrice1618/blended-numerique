<?php 
/* Modèle formations v1 - Sans gestion des erreurs et avec faille de sécurité !!!
*/

// Create - creation nouvelle formation
function createFormations( $formation ) 
{
    global $bdd;

    $nId = 0;

    if ( checkStr( $formation, 2, 250 ) ) {
        $sRequete = "INSERT INTO formations (formation) 
                    VALUES ('$formation')";
        $bdd->query( $sRequete );
        $nId = intVal( $bdd->lastInsertId() );
    }

    return( $nId );
}

// Read - lecture d'une formation
function readFormations( $formation_id ) 
{
    global $bdd;
    
    $aFormation = [];

    if ( checkId( $formation_id ) ) {
        $sRequete = "SELECT * 
                FROM formations 
                WHERE formation_id = $formation_id"; 
        $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
        $aFormation = $stmt->fetch();   // recuperer un seul enregistrement
    }

    return($aFormation);
}
    
// Update - modification d'une formation
function updateFormations( $formation_id, $formation ) 
{
    global $bdd;

    if ( checkId( $formation_id ) && checkStr( $formation, 2, 250 ) ) {
        $sRequete = "UPDATE formations 
                SET formation = '$formation' 
                WHERE formation_id = $formation_id";
        $bdd->query( $sRequete );
    }
}

// Delete - effacement d'une formation
function deleteFormations( $formation_id ) 
{
    global $bdd;

    if ( checkId( $formation_id ) ) {
        $sRequete = "DELETE FROM formations 
                    WHERE formation_id = $formation_id";
        $bdd->query( $sRequete );
    }
}

// Liste de toutes les formations
function indexFormations() 
{
    global $bdd;

    $sRequete = "SELECT * FROM formations";

    $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
    $aFormations = $stmt->fetchAll();   // Récupération de toutes les lignes

    return( $aFormations );
}
        
