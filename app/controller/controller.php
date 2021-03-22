<?php
require_once( "model/utilisateursModel.php" );

// Charger le menu: public (login false) et admin
$aMenu = loadMenu();

function loadMenu()
{
    global $nUtilisateurId;

    $aMenuComplet = [
        ['active' => false, 'href' => '/contact', 'text' => 'Contacts', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/formation', 'text' => 'Formations', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/motif', 'text' => 'Motifs', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/formulaire', 'text' => 'Formulaire', 'admin' => false, 'login' => true],
        ['active' => false, 'href' => '/login/users', 'text' => 'Utilisateurs', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/login/profile', 'text' => 'Profil', 'admin' => false, 'login' => true],
        ['active' => false, 'href' => '/login/logout', 'text' => 'Logout', 'admin' => false, 'login' => true],
        ['active' => false, 'href' => '/login', 'text' => 'Connexion', 'login' => false],
        ['active' => false, 'href' => '/login/register', 'text' => 'Inscription', 'login' => false],
        ['active' => false, 'href' => '/login/lostpassword', 'text' => 'Mot de passe perdu', 'login' => false]
    ];
    
    $aMenu = array();
    $aUtilisateur = array();

    if ($nUtilisateurId != 0) {
        $aUtilisateur = readUtilisateur($nUtilisateurId);
    }

    foreach ($aMenuComplet as $aOption) {

        if ( $nUtilisateurId > 0 && $aUtilisateur['usr_type'] == 'admin' ) {
            // L'utilisateur est connecté et est admin
            if ($aOption['login'] == true) {
                $aMenu[] = $aOption;
            }    
        }
        elseif ( $nUtilisateurId > 0 && $aUtilisateur['usr_type'] != 'admin' ) {
            // L'utilisateur est connecté et n'est pas admin
            if ( $aOption['login'] == true && $aOption['admin'] == false ) {
                $aMenu[] = $aOption;
            }    
        } else {
            // L'utilisateur n'est pas connecte
            if ($aOption['login'] == false) {
                $aMenu[] = $aOption;
            }    
        }
    }
    
    return($aMenu);
}
