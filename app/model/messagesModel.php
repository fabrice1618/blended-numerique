<?php
require_once( "model/database.php" );

define( 
    "SQL_MESSAGE_CREATE",
    "INSERT INTO messages( email_to, sujet, message, headers) 
    VALUES(:email_to, :sujet, :message, :headers)" 
);

define( 
    "SQL_MESSAGE_DELETE",
    "DELETE FROM messages WHERE message_id = :message_id"
);

define( 
    "SQL_MESSAGE_INDEX",
    "SELECT * FROM messages WHERE 1 LIMIT 50"
);


function createMessage( $sEmailTo, $sSujet, $sMessage, $aHeaders )
{
    global $bdd;

    $nReturnId = 0;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_MESSAGE_CREATE );
    $sHeaders = json_encode($aHeaders);
    if (
        $stmt !== false &&
        $stmt->bindValue(':email_to', $sEmailTo, PDO::PARAM_STR) &&
        $stmt->bindValue(':sujet', $sSujet, PDO::PARAM_STR) &&
        $stmt->bindValue(':message', $sMessage, PDO::PARAM_STR) &&
        $stmt->bindValue(':headers', $sHeaders, PDO::PARAM_STR) 
        ) {

        try {
            $stmt->execute();
            $nReturnId = intval( $bdd->lastInsertId() );
        } catch (PDOException $e) {
            $nReturnId = 0;
        }
    }

    return($nReturnId);
}

function deleteMessage( $nMessageId )
{
    global $bdd;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_MESSAGE_DELETE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':message_id', $nMessageId, PDO::PARAM_INT) 
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
    $stmt = $bdd->prepare( SQL_MESSAGE_INDEX );
    if (
        $stmt !== false &&
        $stmt->execute()
        ) {
        // La requete est correctement executee
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $aMessages = $resultat;
        }
    }

    return($aMessages);
}