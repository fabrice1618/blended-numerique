<?php 
require_once( "utilisateursModel.php" );
require_once("loginView.php");

date_default_timezone_set('Europe/Paris');

session_start();

// Recuperation des erreurs 401 qui viennent d'une autre page
if ( isset($_SESSION['http-err-401']) && $_SESSION['http-err-401'] ) {
  $bErreur401 = true;  
} else {
  $bErreur401 = false;
}

if ( isset($_SESSION['utilisateur_id']) && $_SESSION['utilisateur_id'] > 0 ) {
  // L'utilisateur est connecté
  $sAction = $_GET['action'] ?? '';
  if ( $sAction == 'logout' ) {
    // Deconnecter utilisateur
    $_SESSION['utilisateur_id'] = 0;
  } else {
    // Deja connecte -> retour home page
    header("Location:home.php");
  }
} else {
  // L'utilisateur n'est pas connecte
  if ( isset($_POST['email']) && isset($_POST['password']) ) {
    // Verification authentification
    $auth = checkAuth($_POST['email'], $_POST['password']);

    if ( $auth === false ) {
      $_SESSION['utilisateur_id'] = 0;
      http_response_code(401);
      $bErreur401 = true;
    } else {
      $_SESSION['utilisateur_id'] = $auth;
      header("Location:contact.php");
    }
  }
}

$aAlert = null;
if ( $bErreur401 ) {
  unset( $_SESSION['http-err-401'] );
  $aAlert = [ 'color' => 'alert-danger', 'text' => 'HTTP 401 Unauthorized - Accès restreint' ];
}

print( loginView($aAlert) );
