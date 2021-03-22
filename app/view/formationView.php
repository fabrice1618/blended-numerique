<?php
require_once("view.php");

function formationView($aAlert)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'Contact' );

    $sReturn .= startBody();
    $sReturn .= navbar( [
        ['active' => false, 'href' => 'contact.php', 'text' => 'Contacts'],
        ['active' => true, 'href' => 'formation.php', 'text' => 'Formations'],
        ['active' => false, 'href' => 'motif.php', 'text' => 'Motifs'],
        ['active' => false, 'href' => 'formulaire.php', 'text' => 'Formulaire'],
        ['active' => false,  'href' => 'profile.php', 'text' => 'Profil'],
        ['active' => false, 'href' => 'index.php?action=logout', 'text' => 'Logout']
      ]);

    if ( ! is_null( $aAlert ) ) {
        alert($aAlert['color'], $aAlert['text']);
    }

    $sReturn .= getFormationContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getFormationContent()
{

    $sReturn = <<<'EOD'
    <div class="row mt-5 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Formations</h1>
      </div>
      <div class="col"></div>
    </div>
EOD;

    return($sReturn);
}