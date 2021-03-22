<?php 
/* Modèle contacts v1 - Sans gestion des erreurs et avec faille de sécurité !!!
*/

// Create - creation nouveau contat
function createContactMotifs( $aContactMotif ) 
{
    global $bdd;

    if (
        checkArray( $aContactMotif, ['contact_id','motif_id'] ) &&
        checkId( $aContactMotif['contact_id'] ) &&
        checkId( $aContactMotif['motif_id'] )
        ) {

        $sRequete = "INSERT INTO contact_motifs(contact_id, motif_id) 
                    VALUES ('{$aContactMotif['contact_id']}', 
                            '{$aContactMotif['motif_id']}')";
        $bdd->query( $sRequete );
    }    

}

// Delete - effacement d'un contact
function deleteContactMotifs( $aContactMotif ) 
{
    global $bdd;

    if (
        checkArray( $aContactMotif, ['contact_id','motif_id'] ) &&
        checkId( $aContactMotif['contact_id'] ) &&
        checkId( $aContactMotif['motif_id'] )
        ) {

        $sRequete = "DELETE FROM contact_motifs 
                    WHERE contact_id = '{$aContactMotif['contact_id']}' 
                    AND motif_id = '{$aContactMotif['motif_id']}' ";
        $bdd->query( $sRequete );
        }
}

// Liste de tous les contacts
function indexContactMotifs() 
{
    global $bdd;

    $sRequete = "SELECT * FROM contact_motifs";

    $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
    $aContacts = $stmt->fetchAll();   // Récupération de toutes les lignes

    return( $aContacts );
}