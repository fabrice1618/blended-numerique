<?php
require_once("view/view.php");

function registerView()
{
  global $aMenu;

    $sReturn = startHtml();

    $sReturn .= headHtml( 'register form' );

    $sReturn .= startBody();
    $sReturn .= navbar( $aMenu );

    $sReturn .= getRegisterContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getRegisterContent()
{

    $sReturn = <<<'EOD'
    <div class="row mt-5 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Inscription</h1>
      </div>
      <div class="col"></div>
    </div>

    <form action="/login/register" method="post">
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="prenom" class="form-control" placeholder="Prenom">
          </div>
        </div>
        <div class="col"></div>
      </div>
      
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="nom" class="form-control" placeholder="Nom">
          </div>
        </div>
        <div class="col"></div>
      </div>

      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="email" class="form-control" placeholder="email" aria-label="email"
              aria-describedby="basic-addon1">
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
          <button type="submit" class="btn btn-primary">S'enregistrer</button>
        </div>
        <div class="col"></div>
      </div>
    </form>
EOD;

    return($sReturn);
}