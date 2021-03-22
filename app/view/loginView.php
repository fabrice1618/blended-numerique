<?php
require_once("view/view.php");

function loginView()
{
  global $aMenu;

    $sReturn = startHtml();

    $sReturn .= headHtml( 'login form' );

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

    $sReturn .= getLoginContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getLoginContent()
{

    $sReturn = <<<'EOD'
      <div class="row mt-2 mb-3">
        <div class="col"></div>
        <div class="col-6"><h1>Connexion</h1></div>
        <div class="col"></div>        
      </div>

      <form action="/login" method="post">
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">    
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="email" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1">
          </div>
        </div>
        <div class="col"></div>        
      </div>
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
        </div>
        <div class="col"></div>        
      </div>
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
        <button type="submit" class="btn btn-primary">Connecter</button>
        </div>
        <div class="col"></div>        
      </div>
      </form>
EOD;

    return($sReturn);
}