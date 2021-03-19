<?php 
require_once("err404View.php");

date_default_timezone_set('Europe/Paris');

session_start();

if ( isset($_SESSION['utilisateur_id']) && $_SESSION['utilisateur_id'] > 0 ) {
    // L'utilisateur est connecté
    $aMenus = [
      ['active' => false, 'href' => 'home.php', 'text' => 'Home'],
      ['active' => false, 'href' => 'log.php', 'text' => 'Commentaires'],
      ['active' => true,  'href' => 'profile.php', 'text' => 'Profil']
    ];
    
} else {
    // L'utilisateur n'est pas connecte
    $aMenus = [
      ['active' => false, 'href' => 'index.php', 'text' => 'Connexion'],
      ['active' => false, 'href' => 'register.php', 'text' => 'Inscription']
      ];

}

print( err404View($aMenus) );

