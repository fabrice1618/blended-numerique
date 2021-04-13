<?php 

function runController( $aParams )
{
  
  $oSession = Session::getInstance();
  
  if ( ! $oSession->connecte() ) {
    http_response_code(401);
    Session::alertError('HTTP 401 Unauthorized - Accès restreint');
    setExitRedirect('/user/login');
  }
  
  loadView( 'contact' );
  setExitView( contactView() );

}
