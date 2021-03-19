<?php
require_once("view.php");

function loginView($aAlert)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'login form' );

    $sReturn .= startBody();
    $sReturn .= navbar( [
        ['active' => false, 'href' => 'register.php', 'text' => 'Inscription'],
        ['active' => false, 'href' => 'lostpassword.php', 'text' => 'Mot de passe perdu']
        ]);

    if ( ! is_null( $aAlert ) ) {
        alert($aAlert['color'], $aAlert['text']);
    }

    $sReturn .= getLoginContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getLoginContent()
{

    $sReturn = <<<'EOD'
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6"><h1>Please sign in</h1></div>
        <div class="col"></div>        
      </div>

      <form action="index.php" method="post">
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
        <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
        <div class="col"></div>        
      </div>
      </form>
EOD;

    return($sReturn);
}