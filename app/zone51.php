<?php 
require_once("messagesModel.php");

$aMessages = indexMessages();
foreach ($aMessages as $aMessage) {
    // Valeurs par defaut
    $aHeaders = array(
        'From' => 'webmaster@top-security.mips.science',
        'Reply-To' => 'webmaster@top-security.mips.science',
        'X-Mailer' => 'BogoMail 1.15'
    );
    // Ajouter valeur specifiques
    $aHeadersMessage = json_decode($aMessage['headers']);
    if ( ! is_null($aHeadersMessage) ) {
        foreach ($aHeadersMessage as $sKey => $sValue) {
            $aHeaders[$sKey] = $sValue;
        }
    }

    // envoyer email
    mail($aMessage['email_to'], $aMessage['sujet'], $aMessage['message'], $aHeaders);
}

