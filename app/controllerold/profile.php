<?php 
require_once( "utilisateursModel.php" );
require_once( "profileView.php" );

date_default_timezone_set('Europe/Paris');

session_start();

if ( isset($_SESSION['utilisateur_id']) && $_SESSION['utilisateur_id'] > 0 ) {
    // L'utilisateur est connecté
    if ( isset($_POST['email']) ) {
      // Enregistrer les données

    }

} else {
    // L'utilisateur n'est pas connecte
    http_response_code(401);
    $_SESSION['http-err-401'] = true;
    header("Location:index.php");    
}

$aAlert = null;
print( profileView($aAlert) );
