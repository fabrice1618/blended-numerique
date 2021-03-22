<?php 
require_once("controller/controller.php");
require_once("view/contactView.php");

function contactController($sControllerAction)
{
  global $aMenu;
  global $nUtilisateurId;

  if ( $nUtilisateurId == 0 ) {
    http_response_code(401);
    $_SESSION['alert-color'] = 'alert-danger';
    $_SESSION['alert-text'] = 'HTTP 401 Unauthorized - Accès restreint';
    header("Location:/login");
    exit(0);
  }
  
  print( contactView($aMenu) );
}
