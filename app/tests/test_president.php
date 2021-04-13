<?php
 
  // Import de la classe
  require(dirname(__FILE__).'/PresidentDeLaRepublique.php');
 
  // Instanciation de l'objet
  $oPresident = PresidentDeLaRepublique::getInstance('Linus','Tux');
  $oPresident2 = PresidentDeLaRepublique::getInstance('Brian','Kernighan');
  // Appel implicite à la méthode __toString()
  echo $oPresident.PHP_EOL;
  echo $oPresident2.PHP_EOL;  

  var_dump($oPresident);
  var_dump($oPresident2);
?>