<?php 
require_once("controller/controller.php");
require_once("view/http404View.php");

function http404Controller($sControllerAction)
{
  global $aMenu;

  print( http404View($aMenu) );
}
