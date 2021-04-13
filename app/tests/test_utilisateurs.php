<?php
$sBasepath = "/var/www/html/";

require_once("../autoload.php");

/*
$utilisateur1 = new UtilisateursModel();
$utilisateur1->usr_email = "toto@toto.fr";
//$utilisateur1->usr_nom = "toto";
$utilisateur1->usr_prenom = "titi";
$utilisateur1->usr_type = "guest";
$utilisateur1->usr_active = "active";
//print( $utilisateur1->usr_email . $utilisateur1->usr_nom . $utilisateur1->usr_prenom . $utilisateur1->usr_type . $utilisateur1->usr_active );
print_r($utilisateur1->toArray());
$utilisateur1->create();
*/

/*
$u3 = new UtilisateursModel();
//$u3->readWhere(null, ['utilisateur_id' => 6]);
$u3->readWhere( ['usr_email' => "toto@toto.fr"] );
print_r($u3->toArray());
*/
/*
$u4 = new UtilisateursModel();
//$u4->deleteWhere( ['usr_email' => "toto@toto.fr"] );
$u4->deleteWhere( ['utilisateur_id' => 8] );
*/

$u5 = new UtilisateursModel();
$aChamps = ['utilisateur_id', 'usr_email', 'usr_nom', 'usr_prenom'];
$aFiltres = ['usr_active' => 'active', 'usr_type' => 'user' ];
//print_r( $u5->indexWhere( $aChamps, $aFiltres ) );
//print_r( $u5->indexWhere( null, $aFiltres ) );
//print_r( $u5->indexWhere( null, null ) );
//print_r( $u5->index() );
print_r( $u5->index($aChamps) );

/*
$u2 = new UtilisateursModel();
$u2->readWhere(['usr_email' => 'toto@toto.fr']);
print_r($u2->toArray());
$u2->usr_nom = "TOTO";
$u2->usr_prenom = "toto";
$u2->updateWhere(null, ['usr_email' => 'toto@toto.fr']);
*/
