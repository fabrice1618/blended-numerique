<?php 
require_once( "utilisateursModel.php" );
require_once("lostpasswordView.php");

date_default_timezone_set('Europe/Paris');

session_start();

if ( isset($_SESSION['utilisateur_id']) && $_SESSION['utilisateur_id'] > 0 ) {
    // L'utilisateur est connecté
    header("Location:home.php");
} else {
    // L'utilisateur n'est pas connecte
    if ( isset($_POST['email']) ) {
      // Envoi du mot de passe à l'utilisateur

      // Puis redirection sur page login
      header("Location:index.php");
    }
}

if ( isset($_SESSION['err-lostpassword']) && $_SESSION['err-lostpassword'] ) {
  unset( $_SESSION['err-lostpassword'] );
  $aAlert = [ 'color' => 'alert-danger', 'text' => 'Erreur envoi de mot de passe' ];
} else {
  $aAlert = null;
}

print( lostpasswordView($aAlert) );
