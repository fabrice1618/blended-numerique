<?php 
require_once( "controller/controller.php" );
require_once( "model/utilisateursModel.php" );
require_once( "model/messagesModel.php" );

function loginController($sControllerAction,$aExtraParam)
{
    global $aMenu;
    global $nUtilisateurId;

    switch ($sControllerAction) {
        case 'users':
            $sTabName = $aExtraParam[0] ??'inactive';
            if ( ! in_array($sTabName, ['admin', 'users', 'inactive']) ) {
                $sTabName == 'inactive';
            }

            $sUserAction = $aExtraParam[1] ?? '';
            $nUserId = intval($aExtraParam[2] ?? 0);

            if ( ! empty($sUserAction) && ($nUserId > 0) ) {

                switch ($sUserAction) {
                    case 'delete':
                        $aUtilisateur = readUtilisateur( $nUserId );
                        if (isset($aUtilisateur['utilisateur_id'])) {
        
                            deleteUtilisateur( $aUtilisateur['utilisateur_id'] );
                        
                            $_SESSION['alert-color'] = 'alert-success';
                            $_SESSION['alert-text'] = 'Suppression effectuée';

                        } else {
                            $_SESSION['alert-color'] = 'alert-danger';
                            $_SESSION['alert-text'] = 'Suppression échouée';
                        }
                        header("Location: /login/users/".$sTabName);
                        exit(0);
                        break;                    

                    case 'active':
                    case 'inactive':
                        $aUtilisateur = readUtilisateur( $nUserId );
                        if (isset($aUtilisateur['utilisateur_id'])) {
        
                            updateUtilisateur( 
                                $aUtilisateur['utilisateur_id'], 
                                $aUtilisateur['usr_email'], 
                                $aUtilisateur['usr_pwd'], 
                                $aUtilisateur['usr_prenom'], 
                                $aUtilisateur['usr_nom'], 
                                $aUtilisateur['usr_type'], 
                                ($sUserAction=='active')? "active":""
                                );
                        
                            $_SESSION['alert-color'] = 'alert-success';
                            $_SESSION['alert-text'] = 'Mise à jour effectuée';

                        } else {
                            $_SESSION['alert-color'] = 'alert-danger';
                            $_SESSION['alert-text'] = 'Mise à jour échouée';
                        }
                        header("Location: /login/users/".$sTabName);
                        exit(0);
                        break;

                    case 'admin':
                    case 'user':
                        $aUtilisateur = readUtilisateur( $nUserId );
                        if (isset($aUtilisateur['utilisateur_id'])) {
        
                            updateUtilisateur( 
                                $aUtilisateur['utilisateur_id'], 
                                $aUtilisateur['usr_email'], 
                                $aUtilisateur['usr_pwd'], 
                                $aUtilisateur['usr_prenom'], 
                                $aUtilisateur['usr_nom'], 
                                $sUserAction, 
                                $aUtilisateur['usr_active'] 
                                );
                        
                            $_SESSION['alert-color'] = 'alert-success';
                            $_SESSION['alert-text'] = 'Type utilisateur mis à jour';

                        } else {
                            $_SESSION['alert-color'] = 'alert-danger';
                            $_SESSION['alert-text'] = 'Mise à jour échouée';
                        }
                        header("Location: /login/users/".$sTabName);
                        exit(0);
                        break;

                    case 'pwd':
                        $aUtilisateur = readUtilisateur( $nUserId );
                        if (isset($aUtilisateur['utilisateur_id'])) {
        
                            changePassword($aUtilisateur);
                            // Envoi email mot de passe
                            $_SESSION['alert-color'] = 'alert-success';
                            $_SESSION['alert-text'] = 'Nouveau mot de passe transmis par email';

                        } else {
                            $_SESSION['alert-color'] = 'alert-danger';
                            $_SESSION['alert-text'] = 'Nouveau mot de passe échoué';
                        }
                        header("Location: /login/users/".$sTabName);
                        exit(0);
                        break;
                    
                    default:
                        $_SESSION['alert-color'] = 'alert-danger';
                        $_SESSION['alert-text'] = 'Action inconnue';
                        header("Location: /login/users/".$sTabName);
                        exit(0);
                        break;
                }


            }

            if ($sTabName == 'admin') {
                $aUtilisateurs = indexAdminUtilisateur();
            } elseif ($sTabName == 'users') {
                $aUtilisateurs = indexUsersUtilisateur();
            } else {
                $aUtilisateurs = indexInactiveUtilisateur();
            }

            // Charge et affiche la vue
            require_once("view/usersView.php");
            print( usersView($aUtilisateurs, $sTabName) );
            break;

        case 'profile':
            if ( 
                isset($_POST['email']) && 
                isset($_POST['password']) && 
                isset($_POST['prenom']) && 
                isset($_POST['nom']) 
                ) {

                $aUtilisateur = findUtilisateur( $_POST['email'] );
                if (
                    isset($aUtilisateur['utilisateur_id']) &&
                    $aUtilisateur['utilisateur_id'] == $nUtilisateurId
                    ) {
                    updateUtilisateur( 
                        $aUtilisateur['utilisateur_id'], 
                        $aUtilisateur['usr_email'], 
                        $_POST['password'], 
                        htmlspecialchars($_POST['prenom']), 
                        htmlspecialchars($_POST['nom']), 
                        $aUtilisateur['usr_type'], 
                        $aUtilisateur['usr_active']
                    );

                    $_SESSION['alert-color'] = 'alert-success';
                    $_SESSION['alert-text'] = 'Mise à jour effectuée';

                } else {
                    $_SESSION['alert-color'] = 'alert-danger';
                    $_SESSION['alert-text'] = 'Mise à jour échouée';
                }
            }

            $aUtilisateur = readUtilisateur( $nUtilisateurId );

            // Charge et affiche la vue
            require_once("view/profileView.php");
            print( profileView($aUtilisateur) );
            break;

        case 'lostpassword':
            if ( isset($_POST['email']) ) {

                $aUtilisateur = findUtilisateur( $_POST['email'] );
                if (isset($aUtilisateur['utilisateur_id'])) {

                    changePassword($aUtilisateur);

                    // Envoi email mot de passe
                    $_SESSION['alert-color'] = 'alert-success';
                    $_SESSION['alert-text'] = 'Nouveau mot de passe transmis par email';
                    header("Location: /login");
                    exit(0);
                } else {
                    $_SESSION['alert-color'] = 'alert-danger';
                    $_SESSION['alert-text'] = 'Utilisateur inexistant';
                    header("Location: /login");
                    exit(0);
                }
            }

            // Charge et affiche la vue
            require_once("view/lostpasswordView.php");
            print( lostpasswordView() );
            break;

        case 'register':
            if ( 
                isset($_POST['email']) && 
                isset($_POST['password']) && 
                isset($_POST['prenom']) && 
                isset($_POST['nom']) 
                ) {

                $nId = createUtilisateur( 
                    htmlspecialchars($_POST['email']), 
                    htmlspecialchars($_POST['password']), 
                    htmlspecialchars($_POST['prenom']), 
                    htmlspecialchars($_POST['nom']), 
                    'user', 
                    '' 
                );

                if ($nId !=0 ) {
                    $_SESSION['alert-color'] = 'alert-success';
                    $_SESSION['alert-text'] = 'Utilisateur inscrit';
                } else {
                    $_SESSION['alert-color'] = 'alert-danger';
                    $_SESSION['alert-text'] = 'Inscription échouée';
                }
                header("Location: /login");
                exit(0);
            }

            // Charge et affiche la vue
            require_once("view/registerView.php");
            print( registerView() );
            break;

        case '':
        case 'login':
            if ( isset($_POST['email']) && isset($_POST['password']) ) {
                // Verification authentification
                $nAuth = checkAuth($_POST['email'], $_POST['password']);

                if ( $nAuth > 0 ) {
                    // La connexion est reussie, redirection homepage
                    $_SESSION['utilisateur_id'] = $nAuth;
                    header("Location: /contact");
                    exit(0);
                } elseif ($nAuth < 0) {
                    // Connexion echouee
                    http_response_code(401);
                    $_SESSION['alert-color'] = 'alert-danger';
                    $_SESSION['alert-text'] = 'Compte inactif';
                } else {
                    // Connexion echouee
                    http_response_code(401);
                    $_SESSION['alert-color'] = 'alert-danger';
                    $_SESSION['alert-text'] = 'HTTP 401 Unauthorized - Accès restreint';
                }  
            }
  
            // Charge et affiche la vue
            require_once("view/loginView.php");
            print( loginView() );
            break;
        case 'logout':
            $_SESSION['utilisateur_id'] = 0;
            // Charge et affiche la vue
            header("Location: /login");
            exit(0);
        default:
            require_once("view/http404View.php");
            print( http404View($aMenu) );

  }
}

function changePassword($aUtilisateur)
{

    $sNewPassword = getPassword();

    $sMessage = "Nouveau mot de passe " . $sNewPassword;

    $aHeaders = array(
        'From' => 'webmaster@blended.mips.science',
        'Reply-To' => 'webmaster@blended.mips.science',
        'X-Mailer' => 'BogoMail 1.15'
    );

    createMessage( 
        $aUtilisateur['usr_email'], 
        'Nouveau mot de passe', 
        $sMessage, 
        $aHeaders 
        );

    updateUtilisateur( 
        $aUtilisateur['utilisateur_id'], 
        $aUtilisateur['usr_email'], 
        $sNewPassword, 
        $aUtilisateur['usr_prenom'], 
        $aUtilisateur['usr_nom'], 
        $aUtilisateur['usr_type'], 
        $aUtilisateur['usr_active'] 
        );

}


function getPassword()
{
    $sPassword = bin2hex(random_bytes(4));

    return($sPassword);
}