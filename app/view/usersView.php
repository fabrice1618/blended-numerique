<?php

function usersView($aUtilisateurs)
{

    $sReturn = startHtml();

    $sReturn .= headHtml( 'Users' );

    $sReturn .= startBody();
    $sReturn .= navbar();

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

    $sReturn .= getUsersContent($aUtilisateurs);

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getUsersContent($aUtilisateurs)
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
          <a class="nav-link %s" aria-current="page" href="/user/list/inactive">Inactifs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link %s" href="/user/list/user">Utilisateurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link %s" href="/user/list/admin">Administrateurs</a>
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
              <h5 class="card-title"><a href='%s'>%s</a></h5>
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
    $sLinkPwd = "/user/pwd/" . $aUtilisateur['utilisateur_id'];
    $sLinkDel = "/user/delete/" . $aUtilisateur['utilisateur_id'];
    $sLinkProfile = "/user/profile/" . $aUtilisateur['utilisateur_id'];

    if ($aUtilisateur['usr_type'] == 'user' ) {
      $sLinkType = "/user/admin/" . $aUtilisateur['utilisateur_id'];
      $sLinkTypeText = "Type admin";
    } else {
      $sLinkType = "/user/user/" . $aUtilisateur['utilisateur_id'];
      $sLinkTypeText = "Type user";
    }
    
    if ($aUtilisateur['usr_active'] == 'active' ) {
      $sLinkActive = "/user/inactive/" . $aUtilisateur['utilisateur_id'];
      $sLinkActiveText = "Désactiver";
    } else {
      $sLinkActive = "/user/active/" . $aUtilisateur['utilisateur_id'];
      $sLinkActiveText = "Activer";
    }

    $sLinesHtml .= sprintf(
      $sLineTemplate, 
      $sLinkProfile,
      $aUtilisateur['usr_email'],
      UtilisateursModel::descUsrType( $aUtilisateur['usr_type'] ),
      $aUtilisateur['usr_prenom'] . ' ' . $aUtilisateur['usr_nom'],
      $sLinkPwd,
      $sLinkType,
      $sLinkTypeText,
      $sLinkActive,
      $sLinkActiveText,
      $sLinkDel      
      );
  }

  $sTabName = Session::getSession( "LIST_TABNAME" );
  $sReturn = sprintf(
    $sFormTemplate,
    ($sTabName=='inactive')?'active':'',
    ($sTabName=='user')?'active':'',
    ($sTabName=='admin')?'active':'',
    $sLinesHtml
  );
  return($sReturn);
}