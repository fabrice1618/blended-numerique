<?php
require_once( "database.php" );

define( "SQL_MESSAGES_INDEX", "SELECT * FROM messages" );

define( 
    "SQL_MESSAGE_CREATE",
    "INSERT INTO messages(`email_to`, `sujet`, `message`, `headers`) 
    VALUES(':email_to', ':sujet', ':message', ':headers')"
);



function ajouterMessage( $sEmailTo, $sSujet, $sMessage, $aHeaders )
{
    global $bdd;

    $sJSON = json_encode($aHeaders);

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_MESSAGE_CREATE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':email_to', $sEmailTo, PDO::PARAM_STR) &&
        $stmt->bindValue(':sujet', $sSujet, PDO::PARAM_STR) &&
        $stmt->bindValue(':message', $sMessage, PDO::PARAM_STR) &&
        $stmt->bindValue(':headers', $sJSON, PDO::PARAM_STR)
        ) {
        $stmt->execute();
    }
}

function indexMessages()
{
    global $bdd;

    $aMessages = array();

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_MESSAGES_INDEX );
    if ( $stmt !== false && $stmt->execute() ) {
        // La requete est correctement executee
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $aMessages = $resultat;
        }
    }

    return($aMessages);
}