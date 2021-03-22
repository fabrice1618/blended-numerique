<?php
date_default_timezone_set('Europe/Paris');

if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
    throw new \Exception("Fatal error: This application must be run in a web environnement.", 1);
}
// Chemin de la base de l'application avec un slash final
$sBasepath=$_SERVER['DOCUMENT_ROOT'].'/';

session_start();
$nUtilisateurId = $_SESSION['utilisateur_id'] ?? 0;

$aExtraParam = array();
// format: /controller/action
$url_split = explode("/", substr( $_SERVER ['REDIRECT_URL'], 1) );
if (empty($url_split[0])) {
    if ( $nUtilisateurId > 0 ) {
        $sController = 'contactController';
    } else {
        $sController = 'loginController';
    }
} else {
    $sController = $url_split[0] . 'Controller';
    $sControllerAction = $url_split[1] ?? '';  
    $aExtraParam = array();
    for($i=2; $i<count($url_split); $i++) {
        $aExtraParam[] = $url_split[$i];
    }
}

if ( !file_exists(controllerFile($sController)) ) {
    $sController = 'http404Controller';
}

// Charger et executer le controleur
require_once(controllerFile($sController));
$sControllerAction = $sControllerAction ?? '';
$sController($sControllerAction,$aExtraParam);   // Run :)

function controllerFile($sController)
{
    global $sBasepath;

    return($sBasepath . 'controller/' . $sController . '.php');
}