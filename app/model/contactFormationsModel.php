<?php 
/* Modèle contacts v1 - Sans gestion des erreurs et avec faille de sécurité !!!
*/

// Create - creation nouveau contat
function createContactFormations( $aContactFormation ) 
{
    global $bdd;

    if (
        checkArray( $aContactFormation, ['contact_id','formation_id'] ) &&
        checkId( $aContactFormation['contact_id'] ) &&
        checkId( $aContactFormation['formation_id'] )
        ) {

        $sRequete = "INSERT INTO contact_formations(contact_id, formation_id) 
                    VALUES ( '{$aContactFormation['contact_id']}' , 
                            '{$aContactFormation['formation_id']}')";
        $bdd->query( $sRequete );
        }
}

// Delete - effacement d'un contact
function deleteContactFormations( $aContactFormation ) 
{
    global $bdd;

    if (
        checkArray( $aContactFormation, ['contact_id','formation_id'] ) &&
        checkId( $aContactFormation['contact_id'] ) &&
        checkId( $aContactFormation['formation_id'] )
        ) {

        $sRequete = "DELETE FROM contact_formations 
                    WHERE contact_id = '{$aContactFormation['contact_id']}' 
                    AND formation_id = '{$aContactFormation['formation_id']}'";
        $bdd->query( $sRequete );
        }
}

// Liste de tous les contacts
function indexContactFormations() 
{
    global $bdd;

    $sRequete = "SELECT * FROM contact_formations";

    $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
    $aContactFormations = $stmt->fetchAll();   // Récupération de toutes les lignes

    return( $aContactFormations );
}