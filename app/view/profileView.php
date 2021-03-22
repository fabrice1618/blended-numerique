<?php
require_once("view/view.php");

function profileView($aUtilisateur)
{
  global $aMenu;

    $sReturn = startHtml();

    $sReturn .= headHtml( 'Profil' );

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

    $sReturn .= getProfileContent($aUtilisateur);

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getProfileContent($aUtilisateur)
{

    $sFormTemplate = <<<'EOD'
    <div class="row mt-5 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Profil</h1>
      </div>
      <div class="col"></div>
    </div>

    <form action="/login/profile" method="post">

      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="email" readonly class="form-control" placeholder="email" aria-label="email"
              aria-describedby="basic-addon1" value="%s">
          </div>
        </div>
        <div class="col"></div>
      </div>

      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="prenom" class="form-control" placeholder="Prenom" value="%s">
          </div>
        </div>
        <div class="col"></div>
      </div>
      
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="nom" class="form-control" placeholder="Nom" value="%s">
          </div>
        </div>
        <div class="col"></div>
      </div>

      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="password" value="%s">
        </div>
        <div class="col"></div>
      </div>
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
        <div class="col"></div>
      </div>
    </form>
EOD;

  $sReturn = sprintf( 
    $sFormTemplate,
    $aUtilisateur['usr_email'] ?? '???????????',
    $aUtilisateur['usr_prenom'] ?? '',
    $aUtilisateur['usr_nom'] ?? '',
    $aUtilisateur['usr_pwd'] ?? ''
    );

    return($sReturn);
}