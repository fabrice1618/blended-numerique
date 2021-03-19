<?php
require_once("view.php");

function registerView($aAlert)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'register form' );

    $sReturn .= startBody();
    $sReturn .= navbar( [
        ['active' => false, 'href' => 'index.php', 'text' => 'Connexion'],
        ['active' => false, 'href' => 'lostpassword.php', 'text' => 'Mot de passe perdu']
        ]);

    if ( ! is_null( $aAlert ) ) {
        alert($aAlert['color'], $aAlert['text']);
    }

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
        <h1>Enregistrement</h1>
      </div>
      <div class="col"></div>
    </div>

    <form action="register.php" method="post">
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">Prenom</span>
            <input type="text" name="prenom" class="form-control" placeholder="Prenom" aria-label="prenom"
              aria-describedby="basic-addon1">
          </div>
        </div>
        <div class="col"></div>
      </div>
      
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">Nom</span>
            <input type="text" name="nom" class="form-control" placeholder="Nom" aria-label="nom"
              aria-describedby="basic-addon1">
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