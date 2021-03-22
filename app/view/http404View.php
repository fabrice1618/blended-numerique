<?php
require_once("view/view.php");

function http404View($aMenus)
{
    $sReturn = startHtml();

    $sReturn .= headHtml( 
      '404 Page not found', [
        '<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">',
        '<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">',
        '<link type="text/css" rel="stylesheet" href="/css/error.css" />'
        ] );

    $sReturn .= startBody();
    $sReturn .= navbar( $aMenus );

    $sReturn .= getHttp404Content();

    $sReturn .= endBody();
    $sReturn .= endHtml();

    return($sReturn);
}

function getHttp404Content()
{

    $sReturn = <<<'EOD'
    <div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h3>Oops! Page not found</h3>
				<h1><span>4</span><span>0</span><span>4</span></h1>
			</div>
			<h2>we are sorry, but the page you requested was not found</h2>
		</div>
	</div>
EOD;

    return($sReturn);
}