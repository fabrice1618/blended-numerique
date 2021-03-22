<?php
require_once("view/view.php");

function usersView($aUtilisateurs, $sTabName)
{
  global $aMenu;

    $sReturn = startHtml();

    $sReturn .= headHtml( 'Users' );

    $sReturn .= startBody();
    $sReturn .= navbar( $aMenu );

    if ( 
      isset($_SESSION['alert-color']) && 
      isset($_SESSION['alert-text']) &&
      ! empty($_SESSION['alert-color']) &&
      ! empty($_SESSION['alert-text']) 
      ) {

      $sReturn .= alert($_SESSION['alert-color'], $_SESSION['alert-text']);

      unset( $_SESSION['alert-color'] );
      unset( $_SESSION['alert-text'] );
    }

    $sReturn .= getUsersContent($aUtilisateurs, $sTabName);

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getUsersContent($aUtilisateurs, $sTabName)
{

    $sFormTemplate = <<<'EOD'
    <div class="row mt-2 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Utilisateurs</h1>
      </div>
      <div class="col"></div>
    </div>

    <div class="row mt-2 mb-3">
      <div class="col-2"></div>
      <div class="col-10">
        <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link %s" aria-current="page" href="/login/users/inactive">Inactifs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link %s" href="/login/users/users">Utilisateurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link %s" href="/login/users/admin">Administrateurs</a>
        </li>
        </ul>
      </div>
      <div class="col"></div>
    </div>

    <div class="row mt-2 mb-3">
      <div class="col-2"></div>
      <div class="col-8">
        <ul class="list-group list-group-flush">
          %s
        </ul>
      </div>
      <div class="col"></div>
    </div>
EOD;

$sLineTemplate = <<<'EOD'
          <li class="list-group-item">
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">%s</h5>
              <h6 class="card-subtitle mb-2 text-muted">%s</h6>
              <p class="card-text">%s</p>
              <a href="%s" class="card-link">Nouveau mot de passe</a>
              <a href="%s" class="card-link">%s</a>
              <a href="%s" class="card-link">%s</a>
              <a href="%s" class="card-link">Supprimer</a>              
            </div>
            </div>
        
          </li>
EOD;

  $sLinesHtml = '';
  foreach ($aUtilisateurs as $aUtilisateur) {
    $sLinkPwd = "/login/users/" . $sTabName . '/pwd/' . $aUtilisateur['utilisateur_id'];
    $sLinkDel = "/login/users/" . $sTabName . '/delete/' . $aUtilisateur['utilisateur_id'];

    if ($aUtilisateur['usr_type'] == 'admin' ) {
      $sLinkType = "/login/users/" . $sTabName . '/user/' . $aUtilisateur['utilisateur_id'];
      $sLinkTypeText = "Type user";
    } else {
      $sLinkType = "/login/users/" . $sTabName . '/admin/' . $aUtilisateur['utilisateur_id'];
      $sLinkTypeText = "Type admin";
    }
    
    if ($aUtilisateur['usr_active'] == 'active' ) {
      $sLinkActive = "/login/users/" . $sTabName . '/inactive/' . $aUtilisateur['utilisateur_id'];
      $sLinkActiveText = "Désactiver";
    } else {
      $sLinkActive = "/login/users/" . $sTabName . '/active/' . $aUtilisateur['utilisateur_id'];
      $sLinkActiveText = "Activer";
    }

    $sLinesHtml .= sprintf(
      $sLineTemplate, 
      $aUtilisateur['usr_email'],
      ($aUtilisateur['usr_type']=='admin')?'Administrateur':'Utilisateur',
      $aUtilisateur['usr_prenom'] . ' ' . $aUtilisateur['usr_nom'],
      $sLinkPwd,
      $sLinkType,
      $sLinkTypeText,
      $sLinkActive,
      $sLinkActiveText,
      $sLinkDel      
      );
  }

//  print("tabname:$sTabName");
  $sReturn = sprintf(
    $sFormTemplate,
    ($sTabName=='inactive')?'active':'',
    ($sTabName=='users')?'active':'',
    ($sTabName=='admin')?'active':'',
    $sLinesHtml
  );
  return($sReturn);
}