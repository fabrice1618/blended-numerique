<?php 
require_once( "utilisateursModel.php" );
require_once("registerView.php");

date_default_timezone_set('Europe/Paris');

session_start();

if ( isset($_SESSION['utilisateur_id']) && $_SESSION['utilisateur_id'] > 0 ) {
    // L'utilisateur est connecté
    header("Location:home.php");
} else {
    // L'utilisateur n'est pas connecte
    if ( isset($_POST['email']) && isset($_POST['password']) ) {
      // Enregistrement de l'utilisateur

      // Puis redirection sur page login
      header("Location:index.php");
    }
}

if ( isset($_SESSION['err-register']) && $_SESSION['err-register'] ) {
  unset( $_SESSION['err-register'] );
  $aAlert = [ 'color' => 'alert-danger', 'text' => 'Erreur enregistrement' ];
} else {
  $aAlert = null;
}

print( registerView($aAlert) );

