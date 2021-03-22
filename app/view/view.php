<?php

function alert($sAlertColor, $sAlertText)
{
    $sAlert = <<<'EOD'
    <div class="row mt-3">
    <div class="col"></div>
    <div class="col-10 alert %s" role="alert">%s</div>
    <div class="col"></div>        
  </div>
EOD;

    $sReturn = sprintf( $sAlert, $sAlertColor, $sAlertText);

    return($sReturn);
}

function navbar( $aMenus = null )
{

    $sReturn1 = <<<'EOD'
    <nav class="navbar navbar-expand-lg navbar-light bg-light my-2">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Blended</a>

      <ul class="nav justify-content-end">
EOD;

    $sMenuOption = <<<'EOD'
    <li class="nav-item %s">
      <a class="nav-link" href="%s">%s</a>
    </li>
EOD;

    $sMenu = '';
    if ( ! is_null($aMenus) ) {
        foreach ($aMenus as $aMenu) {
            $sMenu = $sMenu .
                sprintf(
                $sMenuOption, 
                $aMenu['active'] ? 'active': '',
                $aMenu['href'],
                $aMenu['text']
                ) .
                PHP_EOL;
        }
    }

    $sReturn2 = <<<'EOD'
  </ul>          
</div>
</nav>
EOD;

    return($sReturn1 . $sMenu . $sReturn2);
}

function startBody()
{
    $sReturn = <<<'EOD'
    <body>
    <div class="container-lg">
EOD;

    return($sReturn);
}

function endBody()
{
    $sReturn = <<<'EOD'
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  </body>
EOD;

    return($sReturn);
}

function headHtml( $sTitle = '', $aSupplement = null )
{
    $sReturn1 = <<<'EOD'
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
EOD;

    $sTitleHtml = sprintf(
        "    <title>Blended%s</title>",
        empty($sTitle) ? '': ' - ' . $sTitle
    );

    $sSupplementHtml = '';
    if ( ! is_null($aSupplement) ) {
        foreach ($aSupplement as $sLigne) {
            $sSupplementHtml = $sSupplementHtml . $sLigne . "\n";
        }
    }

$sReturn2 = <<<'EOD'
    </head>
EOD;

    return( $sReturn1 . $sTitleHtml . $sSupplementHtml . $sReturn2 );
}


function startHtml()
{
    $sReturn = <<<'EOD'
<!doctype html>
<html lang="en">
EOD;

    return($sReturn);
}

function endHtml()
{
    $sReturn = <<<'EOD'
</html>
EOD;

    return($sReturn);
}