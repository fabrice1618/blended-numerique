<?php
require_once("view.php");

function profileView($aAlert)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'Profil' );

    $sReturn .= startBody();
    $sReturn .= navbar( [
        ['active' => false, 'href' => 'home.php', 'text' => 'Home'],
        ['active' => false, 'href' => 'log.php', 'text' => 'Commentaires'],
        ['active' => true,  'href' => 'profile.php', 'text' => 'Profil']
      ]);

    if ( ! is_null( $aAlert ) ) {
        alert($aAlert['color'], $aAlert['text']);
    }

    $sReturn .= getProfileContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getProfileContent()
{

    $sReturn = <<<'EOD'
    <div class="row mt-5 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Profil</h1>
      </div>
      <div class="col"></div>
    </div>

    <form action="profile.php" method="post">
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
          <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
        <div class="col"></div>
      </div>
    </form>
EOD;

    return($sReturn);
}