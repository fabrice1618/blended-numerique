<?php

function formationmodifView($aFormation)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'Formation' );

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

    $sReturn .= getFormationmodifContent($aFormation);

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getFormationmodifContent($aFormation)
{

    $sFormTemplate = <<<'EOD'
    <div class="row mt-2 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Formation</h1>
      </div>
      <div class="col"></div>
    </div>

    <form action="/formation/update" method="post">

      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="hidden" name="formation_id" value="%s">
          </div>
        </div>
        <div class="col"></div>
      </div>

      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="formation" class="form-control" placeholder="Formation" value="%s">
          </div>
        </div>
        <div class="col"></div>
      </div>
      
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="form_active" class="form-control" placeholder="Active/inactive" value="%s">
          </div>
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
    $aFormation['formation_id'] ?? '0',
    $aFormation['formation'] ?? '',
    $aFormation['form_active'] ?? 'active'
    );

    return($sReturn);
}