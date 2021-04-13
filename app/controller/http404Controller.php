<?php 

function runController( $aParams )
{
  loadView( 'http404' );
  setExitView( http404View() );

}
