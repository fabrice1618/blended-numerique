<?php

function contactView()
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 'Contact' );

    $sReturn .= startBody();
    $sReturn .= navbar();

    if ( Session::haveAlert() ) {
      $aAlert = Session::getAlert();
      $sReturn .= alert($aAlert['alert-color'], $aAlert['alert-text']);
    }

    $sReturn .= getContactContent();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getContactContent()
{

    $sReturn = <<<'EOD'
    <div class="row mt-2 mb-3">
      <div class="col"></div>
      <div class="col-6">
        <h1>Contacts</h1>
      </div>
      <div class="col"></div>
    </div>
EOD;

    return($sReturn);
}