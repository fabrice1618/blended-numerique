<?php 

function runController( $aParams )
{
    $sAction = $aParams[0] ?? 'login';
    $oSession = Session::getInstance();

    switch ($sAction) {
        case 'active':
        case 'inactive':
            if ( 
                $oSession->autorisation('admin') && 
                isset($aParams[1]) && 
                intval($aParams[1]) != 0 
                ) {

                $oUser = new UtilisateursModel();
                $nUsrId = intval($aParams[1]);
                if ( $oUser->readWhere( [ 'utilisateur_id' => $nUsrId ] ) ) {
                    $oUser->usr_active = ($sAction=='active')? "active": "inactive";
                    if ( $sAction == 'active' ) {
                        $oUser->usr_active = "active";
                        if ( $oUser->usr_type == 'guest' ) {
                            $oUser->usr_type = 'user';
                        }
                    } else {
                        $oUser->usr_active = "inactive";
                    }

                    if ( $oUser->updateWhere(['usr_active', 'usr_type'], [ 'utilisateur_id' => intval($aParams[1]) ] ) ) {
                        Session::alertSuccess('Mise à jour effectuée');
                    } else {
                        Session::alertError('Mise à jour échouée');
                    }
                }
            }

            $sTabName = Session::getSession( "LIST_TABNAME" );
            setExitRedirect('/user/list/'.$sTabName);
            break;

        case 'admin':
        case 'user':
            if ( 
                $oSession->autorisation('admin') && 
                isset($aParams[1]) && 
                intval($aParams[1]) != 0 
                ) {

                $oUser = new UtilisateursModel();
                $oUser->usr_type = $sAction;
                    
                if ( $oUser->updateWhere(['usr_type'], [ 'utilisateur_id' => intval($aParams[1]) ] ) ) {
                    Session::alertSuccess('Type utilisateur mis à jour');
                } else {
                    Session::alertError('Mise à jour échouée');
                }
            }

            $sTabName = Session::getSession( "LIST_TABNAME" );
            setExitRedirect('/user/list/'.$sTabName);
            break;

        case 'delete':
            if ( 
                $oSession->autorisation('admin') && 
                isset($aParams[1]) && 
                intval($aParams[1]) != 0 
                ) {

                $oUser = new UtilisateursModel();
                if ( $oUser->deleteWhere([ 'utilisateur_id' => intval($aParams[1]) ]) ) {
                    Session::alertSuccess( 'Suppression effectuée' );
                } else {
                    Session::alertError( 'Suppression échouée' );
                }
            }

            $sTabName = Session::getSession( "LIST_TABNAME" );
            setExitRedirect('/user/list/'.$sTabName);
            break;

        case 'pwd':
            if ( 
                $oSession->autorisation('admin') && 
                isset($aParams[1]) && 
                intval($aParams[1]) != 0 
                ) {

                changePassword( intval($aParams[1]) );
            }

            $sTabName = Session::getSession( "LIST_TABNAME" );
            setExitRedirect('/user/list/'.$sTabName);
            break;

        case 'list':
            $sTabName = $aParams[1] ?? 'inactive';
            if ( ! in_array($sTabName, ['admin', 'user', 'inactive']) ) {
                $sTabName == 'inactive';
            }
            Session::setSession( "LIST_TABNAME", $sTabName );

            $oUser = new UtilisateursModel();
            if ($sTabName == 'admin') {
                $aUtilisateurs = $oUser->indexWhere( null, [
                    'usr_active' => 'active', 
                    'usr_type' => 'admin'
                    ] );
            } elseif ($sTabName == 'user') {
                $aUtilisateurs = $oUser->indexWhere( null, [
                    'usr_active' => 'active', 
                    'usr_type' => 'user'
                    ] );
            } else {
                $aUtilisateurs = $oUser->indexWhere( null, [ 'usr_active' => 'inactive' ] );
            }

            // Charge et affiche la vue
            loadView( 'users' );
            setExitView( usersView($aUtilisateurs) );
            break;

        case 'profile':
            if ( $oSession->autorisation('admin') ) {

                if ( isset($aParams[1]) && intval($aParams[1]) != 0  ) {
                    $nUsrId = intval($aParams[1]);
                } else {
                    $oSession = Session::getInstance();    
                    $nUsrId = $oSession->user_data['utilisateur_id'];
                }    

            } elseif ($oSession->autorisation('user')) {

                $oSession = Session::getInstance();
                if ( isset($_POST['email']) && $_POST['email'] !== $oSession->user_data['usr_email'] ) {
                    // Un usr_type = user ne peux modifier que son propre compte
                    unset($_POST['email']);
                    unset($_POST['password']);
                    unset($_POST['prenom']);
                    unset($_POST['nom']);
                }
                $nUsrId = $oSession->user_data['utilisateur_id'];

            } else {
                setExitRedirect('/user/login');
            }

            profileAction($nUsrId);
            break;

        case 'register':
            registerAction();
            break;

        case 'lostpassword':
            lostpasswordAction();
            break;

        case 'login':
            loginAction();
            break;

        case 'logout':
            $oSession->logout();
            setExitRedirect('/user/login');
            break;
        
        default:
            loadView( 'http404' );
            setExitView( http404View() );
            break;
    }
}

function lostpasswordAction()
{
    if ( isset($_POST['email']) ) {

        $oUser = new UtilisateursModel();
        $oUser->readWhere(['usr_email' => $_POST['email'] ]);

        changePassword( $oUser->utilisateur_id );

        setExitRedirect('/user/login');
    }

    // Charge et affiche la vue
    loadView( 'lostpassword' );
    setExitView( lostpasswordView() );
}

function changePassword( $nUsrId )
{
    $oUser = new UtilisateursModel();
    $oUser->readWhere(['utilisateur_id' => $nUsrId]);
    $sNewPassword = $oUser->setRandomPassword();

    if ( $oUser->updateWhere(['usr_pwd'], ['utilisateur_id' => $nUserId] ) ) {

        $oMessage = new MessagesModel();
        $oMessage->email_to = $oUSer->usr_email;
        $oMessage->sujet = 'Nouveau mot de passe';
        $oMessage->message = "Nouveau mot de passe " . $sNewPassword;
        $oMessage->create();

        Session::alertSuccess('Nouveau mot de passe transmis par email');
    } else {
        Session::alertError('Mise à jour échouée');
    }
}

function profileAction($nUsrId)
{
    $oUser = new UtilisateursModel();
    if ( 
        isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['prenom']) && 
        isset($_POST['nom']) 
        ) {

        if ( $oUser->readWhere(['usr_email' => $_POST['email'] ]) ) {

            $sPasswordHash = $_POST['password'];
            $oUser->usr_pwd = $sPasswordHash;
            $oUser->usr_prenom = htmlspecialchars($_POST['prenom']);
            $oUser->usr_nom = htmlspecialchars($_POST['nom']);
            $oUser->updateWhere(  
                [ 'usr_pwd', 'usr_prenom', 'usr_nom' ], 
                [ 'utilisateur_id' => $oUser->utilisateur_id ]
                );

            Session::alertSuccess('Mise à jour effectuée');

        } else {
            Session::alertError('Mise à jour échouée');
        }
    }

    $oUser->readWhere(['utilisateur_id' => $nUsrId ]);
    $aUtilisateur = $oUser->toArray();

    // Charge et affiche la vue
    loadView( 'profile' );
    setExitView( profileView($aUtilisateur) );
}

function registerAction()
{
    if ( 
        isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['prenom']) && 
        isset($_POST['nom']) 
        ) {

        $oUser = new UtilisateursModel();
        $oUser->usr_email = htmlspecialchars($_POST['email']);
        $oUser->usr_nom = htmlspecialchars($_POST['nom']);
        $oUser->usr_prenom = htmlspecialchars($_POST['prenom']);
        $oUser->usr_pwd = htmlspecialchars($_POST['password']);
        $nId = $oUser->create();
            
        if ($nId !=0 ) {
            Session::alertSuccess('Utilisateur inscrit');
        } else {
            Session::alertError('Inscription échouée');
        }

        setExitRedirect('/user/login');
    }

    loadView( 'register' );
    setExitView( registerView() );
}

function loginAction()
{
    $nAuth = Session::AUTH_GUEST;
    if ( isset($_POST['email']) && isset($_POST['password']) ) {
        // Verification authentification
        $oSession = Session::getInstance();
        $nAuth = $oSession->checkAuth($_POST['email'], $_POST['password']);

        switch ($nAuth) {
            case Session::AUTH_LOGIN:
                setExitRedirect('/');
                break;

            case Session::AUTH_INACTIVE:
                http_response_code(401);
                Session::alertError('Compte inactif');
                break;

            case Session::AUTH_FAILED:
            default:
                http_response_code(401);
                Session::alertError('HTTP 401 Unauthorized - Accès restreint');
                break;
        }
    }

    if ( $nAuth !== Session::AUTH_LOGIN ) {
        // Charge et affiche la vue
        loadView( 'login' );
        setExitView( loginView() );
    }
}

