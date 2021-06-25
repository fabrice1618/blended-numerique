<?php
require_once("view.php");

function formationView($aFormations)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'Formations' );

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

    $sReturn .= getFormationContent($aFormations);

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getFormationContent($aFormations)
{


  $sFormTemplate = <<<'EOD'
  <div class="row mt-2 mb-3">
    <div class="col"></div>
    <div class="col-6">
      <h1>Formations</h1>
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
            <p class="card-text">%s</p>
            <a href="%s" class="card-link">Modifier</a>
            <a href="%s" class="card-link">%s</a>
            <a href="%s" class="card-link">Supprimer</a>              
          </div>
          </div>
      
        </li>
EOD;

$sLinesHtml = '';
foreach ($aFormations as $aFormation) {

  $sLinkUpdate = "/formation/update/" . $aFormation['formation_id'];
  $sLinkDel = "/formation/delete/" . $aFormation['formation_id'];

  if ($aFormation['form_active'] == 'active' ) {
    $sLinkActive = "/formation/inactive/" . $aFormation['formation_id'];
    $sLinkActiveText = "Désactiver";
  } else {
    $sLinkActive = "/formation/active/" . $aFormation['formation_id'];
    $sLinkActiveText = "Activer";
  }

  $sLinesHtml .= sprintf(
    $sLineTemplate, 
    $aFormation['formation'],
    $aFormation['form_active'],
    $sLinkUpdate,
    $sLinkActive,
    $sLinkActiveText,
    $sLinkDel      
    );
}

$sReturn = sprintf( $sFormTemplate, $sLinesHtml );

return($sReturn);


}