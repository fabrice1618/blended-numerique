<?php 

/*

index/(vide)    :   index
create:
read:
update:
delete:

*/


function runController( $aParams )
{
    $sAction = $aParams[0] ?? 'list';
    $oSession = Session::getInstance();

    if ( ! $oSession->connecte() || ! $oSession->autorisation('admin') ) {
        http_response_code(401);
        Session::alertError('HTTP 401 Unauthorized - Accès restreint');
        setExitRedirect('/user/login');
      }
    


    switch ($sAction) {
        case 'index':
            $oFormation = new FormationModel();
            $aFormations = $oFormation->index();

            // Charge et affiche la vue
            loadView( 'formation' );
            setExitView( formationView($aFormations) );
            break;

        case 'create':
            //registerAction();
            break;

        case 'read':
            //registerAction();
            break;

        case 'update':
            //registerAction();  formationmodifView

            if ( 
                isset($_POST['formation_id']) && 
                isset($_POST['formation']) && 
                isset($_POST['form_active']) 
            ) {
                // Mise BDD
                if ( 
                    $oSession->autorisation('admin') && 
                    intval($_POST['formation_id']) != 0 
                    ) {
    
                    $oFormation = new FormationModel();
                    $oFormation->formation_id = $_POST['formation_id'];
                    $oFormation->formation = htmlspecialchars( $_POST['formation'] );
                    $oFormation->form_active = $_POST['form_active'];
    
                    if ( $oFormation->update() ) {
                        Session::alertSuccess( 'Modification effectuée' );
                    } else {
                        Session::alertError( 'Modification échouée' );
                    }
                }
                setExitRedirect('/formation/index');
    
            } else {
                // Affichage formulaire
                if ( 
                    $oSession->autorisation('admin') && 
                    isset($aParams[1]) && 
                    intval($aParams[1]) != 0 
                    ) {
    
                    $oFormation = new FormationModel();
                    $oFormation->read(intval($aParams[1]));

                    // Affichage formulaire
                    loadView( 'formationmodif' );
                    setExitView( formationmodifView( $oFormation->toArray() ) );
                }


            }




            break;

        case 'delete':
            if ( 
                $oSession->autorisation('admin') && 
                isset($aParams[1]) && 
                intval($aParams[1]) != 0 
                ) {

                $oFormation = new FormationModel();
                if ( $oFormation->delete( intval($aParams[1]) ) ) {
                    Session::alertSuccess( 'Suppression effectuée' );
                } else {
                    Session::alertError( 'Suppression échouée' );
                }
            }
            setExitRedirect('/formation/index');
            break;

        case 'active':
        case 'inactive':
            if ( 
                $oSession->autorisation('admin') && 
                isset($aParams[1]) && 
                intval($aParams[1]) != 0 
                ) {

/*
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
*/
            }
            

            setExitRedirect('/formation/index');
            break;


        default:
            loadView( 'http404' );
            setExitView( http404View() );
            break;
}
}

