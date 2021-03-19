<?php
require_once("view.php");

function lostpasswordView($aAlert)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'lost password form' );

    $sReturn .= startBody();
    $sReturn .= navbar( [
        ['active' => false, 'href' => 'register.php', 'text' => 'Inscription'],
        ['active' => false, 'href' => 'index.php', 'text' => 'Connexion']
        ]);

    if ( ! is_null( $aAlert ) ) {
        alert($aAlert['color'], $aAlert['text']);
    }

    $sReturn .= getLostpasswordContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getLostpasswordContent()
{

    $sReturn = <<<'EOD'
    <div class="row mt-5 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Mot de passe oublié</h1>
      </div>
      <div class="col"></div>
    </div>

    <form action="lostpassword.php" method="post">
      
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
          <button type="submit" class="btn btn-primary">Mot de passe oublié ?</button>
        </div>
        <div class="col"></div>
      </div>
    </form>
EOD;

    return($sReturn);
}