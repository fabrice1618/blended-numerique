<?php
require_once("autoload.php");

define( 'ROUTE_GUEST', 'user' );
define( 'ROUTE_LOGIN_ADMIN', 'contact' );
define( 'ROUTE_LOGIN_USER', 'formulaire' );

date_default_timezone_set('Europe/Paris');

if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
    throw new \Exception("Fatal error: This application must be run in a web environnement.", 1);
}
// Chemin de la base de l'application avec un slash final
$sBasepath=$_SERVER['DOCUMENT_ROOT'].'/';

$oSession = Session::getInstance();

$aRoute = analyseURL( $_SERVER ['REDIRECT_URL'] );

// Charger et executer le controleur
$aExit = array();
require_once( controllerFile( $aRoute['controller'] ) );
runController( $aRoute['params'] );

if ( isset( $aExit['redirect'] ) ) {
    header("Location: ".$aExit['redirect']);
//    exit(0);
} else {
    print( $aExit['view'] );
}


///////// Fonctions
function loadView( $sView )
{
    require_once("view/view.php");
    require_once("view/".$sView."View.php");
}

function setExitView( $sView )
{
    global $aExit;

    $aExit['view'] = $sView;
}

function setExitRedirect( $sUrl )
{
    global $aExit;

    $aExit['redirect'] = $sUrl;
}

function analyseURL( $sUrl )
{
    $aReturnRoute = [ 'controller' => '', 'params' => [] ];

    $url_split = explode("/", substr( $sUrl, 1) );

    $oSession = Session::getInstance();
    if (empty($url_split[0])) {

        if ( $oSession->connecte() && $oSession->autorisation('admin') ) {
            // L'utilisateur est connecté et est admin
            $aReturnRoute['controller'] = ROUTE_LOGIN_ADMIN;
        }
        elseif ( $oSession->connecte() && $oSession->autorisation('user') ) {
            // L'utilisateur est connecté et est un "user"
            $aReturnRoute['controller'] = ROUTE_LOGIN_USER;
        } else {
            // L'utilisateur n'est pas connecte
            $aReturnRoute['controller'] = ROUTE_GUEST;
        }

    } else {
        $aReturnRoute['controller'] = $url_split[0];

        for( $i=1; $i < count($url_split); $i++ ) {
            array_push( $aReturnRoute['params'], $url_split[$i] );
        }
    }
    
    if ( !file_exists(controllerFile( $aReturnRoute['controller'] )) ) {
        $aReturnRoute['controller'] = 'http404';
        $aReturnRoute['params'] = [];
    }
    
    return($aReturnRoute);
}

function controllerFile($sController)
{
    global $sBasepath;

    return($sBasepath . 'controller/' . $sController . 'Controller.php');
}