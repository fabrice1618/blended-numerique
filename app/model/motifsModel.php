<?php 
/* Modèle motifs v1 - Sans gestion des erreurs et avec faille de sécurité !!!
*/
include_once( "util_check.php" );

// Create - creation nouveau motif
function createMotifs( $motif ) 
{
    global $bdd;

    $nId = 0;

    if ( checkStr( $motif, 3, 250 ) ) {
        $sRequete = "INSERT INTO motifs (motif) 
                    VALUES ('$motif')";
        $bdd->query( $sRequete );
        $nId = intval( $bdd->lastInsertId() );
    }

    return( $nId );
}

// Read - lecture d'un motif
function readMotifs( $motif_id ) 
{
    global $bdd;
     
    $aMotif = [];

    print("motif_id:".$motif_id);

    if ( checkId( $motif_id ) ) {
        $sRequete = "SELECT * 
                    FROM motifs 
                    WHERE motif_id = $motif_id"; 
        print("requete:".$sRequete);
        var_dump(PDO::FETCH_ASSOC);
        $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
        $aMotif = $stmt->fetch();   // recuperer un seul enregistrement
        }

    return($aMotif);
}
    
// Update - modification d'un motif
function updateMotifs( $motif_id, $motif ) 
{
    global $bdd;

    if ( checkId( $motif_id ) && checkStr( $motif, 3, 250 ) ) {
        $sRequete = "UPDATE motifs 
                    SET motif = '$motif' 
                    WHERE motif_id = $motif_id";
        $bdd->query( $sRequete );
    }

}

// Delete - effacement d'un motif
function deleteMotifs( $motif_id ) 
{
    global $bdd;

    if ( checkId( $motif_id ) ) {
        $sRequete = "DELETE FROM motifs 
                    WHERE motif_id = $motif_id";
        $bdd->query( $sRequete );
    }

}

// Liste de tous les motifs
function indexMotifs() 
{
    global $bdd;

    $sRequete = "SELECT * FROM motifs";
    $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
    $aMotifs = $stmt->fetchAll();   // Récupération de toutes les lignes

    return( $aMotifs );
}
