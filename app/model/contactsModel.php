<?php 
/* Modèle contacts v1 - Sans gestion des erreurs et avec faille de sécurité !!!
*/
require_once( "util_check.php" );

// Create - creation nouveau contat
function createContacts( $aContact ) 
{
    global $bdd;

    $nId = 0;

    if ( checkArray( $aContact, ['date_contact','email','nom','prenom','telephone','adresse','code_postal','ville','contact_message'] ) &&
        checkDateTime( $aContact['date_contact'] ) &&
        checkStr( $aContact['email'], 6, 250 ) &&
        checkStr( $aContact['nom'], 1, 250 ) &&
        checkStr( $aContact['prenom'], 1, 250 ) &&
        checkStr( $aContact['telephone'], 10, 250 ) &&
        checkStr( $aContact['adresse'], 1, 250 ) &&
        checkStr( $aContact['code_postal'], 4, 250 ) &&
        checkStr( $aContact['ville'], 1, 250 ) &&
        checkStr( $aContact['contact_message'], 0, 4096 )
    ) {
    
        $sRequete = "INSERT INTO contacts(date_contact, email, nom, prenom, telephone, adresse, code_postal, ville, `contact_message`) 
                    VALUES ( '{$aContact['date_contact']}', 
                            '{$aContact['email']}', 
                            '{$aContact['nom']}', 
                            '{$aContact['prenom']}', 
                            '{$aContact['telephone']}', 
                            '{$aContact['adresse']}', 
                            '{$aContact['code_postal']}', 
                            '{$aContact['ville']}', 
                            '{$aContact['contact_message']}')";
        $bdd->query($sRequete);
        $nId = intVal( $bdd->lastInsertId() );
    }

    return( $nId );
}

// Read - lecture d'un contact
function readContacts( $contact_id ) 
{
    global $bdd;

    $aContact = [];

    if ( checkId( $contact_id ) ) {
        $sRequete = "SELECT * 
                    FROM contacts 
                    WHERE contact_id = $contact_id"; 
        $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
        $aContact = $stmt->fetch();   // recuperer un seul enregistrement
    }

    return($aContact);
}
    
// Update - modification d'un contact
function updateContacts( $contact_id, $aContact ) 
{
    global $bdd;

    if ( checkId( $contact_id ) &&
        checkArray( $aContact, ['date_contact','email','nom','prenom','telephone','adresse','code_postal','ville','contact_message'] ) &&
        checkDateTime( $aContact['date_contact'] ) &&
        checkStr( $aContact['email'], 6, 250 ) &&
        checkStr( $aContact['nom'], 1, 250 ) &&
        checkStr( $aContact['prenom'], 1, 250 ) &&
        checkStr( $aContact['telephone'], 10, 250 ) &&
        checkStr( $aContact['adresse'], 1, 250 ) &&
        checkStr( $aContact['code_postal'], 4, 250 ) &&
        checkStr( $aContact['ville'], 1, 250 ) &&
        checkStr( $aContact['contact_message'], 0, 4096 )
    ) {

        $sRequete = "UPDATE contacts 
                    SET date_contact = '{$aContact['date_contact']}', 
                        email = '{$aContact['email']}', 
                        nom = '{$aContact['nom']}', 
                        prenom = '{$aContact['prenom']}', 
                        telephone = '{$aContact['telephone']}', 
                        adresse = '{$aContact['adresse']}', 
                        code_postal = '{$aContact['code_postal']}', 
                        ville = '{$aContact['ville']}', 
                        contact_message = '{$aContact['contact_message']}' 
                    WHERE contact_id = $contact_id";
    $bdd->query( $sRequete );
    }
}

// Delete - effacement d'un contact
function deleteContacts( $contact_id ) 
{
    global $bdd;

    if ( checkId( $contact_id ) ) {
        $sRequete = "DELETE FROM contacts WHERE contact_id = $contact_id";
        $bdd->query( $sRequete );
    }
}

// Liste de tous les contacts
function indexContacts() 
{
    global $bdd;

    $sRequete = "SELECT * FROM contacts";
    $stmt = $bdd->query( $sRequete, PDO::FETCH_ASSOC );
    $aContacts = $stmt->fetchAll();   // Récupération de toutes les lignes

    return( $aContacts );
}