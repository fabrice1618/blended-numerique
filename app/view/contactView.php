<?php
require_once("view/view.php");

function contactView()
{
  global $aMenu;

    $sReturn = startHtml();

    $sReturn .= headHtml( 'Contact' );

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

    $sReturn .= getContactContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getContactContent()
{

    $sReturn = <<<'EOD'
    <div class="row mt-5 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Contacts</h1>
      </div>
      <div class="col"></div>
    </div>
EOD;

    return($sReturn);
}