<?php 
require_once("formationView.php");

date_default_timezone_set('Europe/Paris');

session_start();

if ( ! isset($_SESSION['utilisateur_id']) || $_SESSION['utilisateur_id'] == 0 ) {
  http_response_code(401);
  $_SESSION['http-err-401'] = true;
  header("Location:index.php");
}

$aAlert = null;
print( formationView($aAlert) );
