<?php

class Session
{
    const AUTH_LOGIN = 0;
    const AUTH_INACTIVE = -1;
    const AUTH_FAILED = -2;
    const AUTH_GUEST = -3;

    const MENU_COMPLET = [
        ['active' => false, 'href' => '/contact', 'text' => 'Contacts', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/formation', 'text' => 'Formations', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/motif', 'text' => 'Motifs', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/formulaire', 'text' => 'Formulaire', 'admin' => false, 'login' => true],
        ['active' => false, 'href' => '/user/list/inactive', 'text' => 'Utilisateurs', 'admin' => true, 'login' => true],
        ['active' => false, 'href' => '/user/profile', 'text' => 'Profil', 'admin' => false, 'login' => true],
        ['active' => false, 'href' => '/user/logout', 'text' => 'Logout', 'admin' => false, 'login' => true],
        ['active' => false, 'href' => '/user/login', 'text' => 'Connexion', 'login' => false],
        ['active' => false, 'href' => '/user/register', 'text' => 'Inscription', 'login' => false],
        ['active' => false, 'href' => '/user/lostpassword', 'text' => 'Mot de passe perdu', 'login' => false]
    ];


    private static $instance = null;
   
    private $session = null;   // variables session 

    public $user_data = null;
    public $menu = null;

   private function __construct()
   {
    session_start();
    $this->session = $_SESSION;

    $this->initUser( $_SESSION['utilisateur_id'] ?? 0 );

    $this->menu = $this->loadMenu();
   }
 
   public static function getInstance()
   {
 
     if (is_null(self::$instance)) {
       self::$instance = new Session();  
     }
 
     return( self::$instance );
   }

    // Verifie si email et password sont OK et retourne utilisateur_id, sinon false
    public function checkAuth($sEmail, $sPassword)
    {
        $nAuth = self::AUTH_FAILED;

        $sPasswordHash = $sPassword;

        $oUser = new UtilisateursModel();
        $oUser->readWhere( ['usr_email' => $sEmail ] );

        if ( $oUser->usr_email == $sEmail && $oUser->usr_pwd == $sPasswordHash ) {
            if ( $oUser->usr_active == "active" ) {
                $nAuth = self::AUTH_LOGIN;
                $this->initUser( $oUser->utilisateur_id );
                self::setSession( "utilisateur_id", $oUser->utilisateur_id );
            } else {
                $nAuth = self::AUTH_INACTIVE;
                $this->initUser( 0 );
            }
        } else {
            $nAuth = self::AUTH_FAILED;
            $this->initUser( 0 );
        }

        return($nAuth);
    }

   public function logout()
   {
        self::setSession( 'utilisateur_id', 0 );
        $this->initUser(0);
   }

   public function connecte()
   {
       if ( $this->user_data['utilisateur_id'] > 0 ) {
           return(true);
       }
       return(false);
   }

   public function autorisation( $sUsrType )
   {
        $lAutorisation = false;

        switch ($sUsrType) {
            case 'guest':
                $lAutorisation = true;
                break;

            case 'user':
                if ( 
                    $this->user_data['usr_type'] == 'user' || 
                    $this->user_data['usr_type'] == 'admin' 
                    ) {
                    $lAutorisation = true;
                }
                break;

            case 'admin':
                if ( $this->user_data['usr_type'] == 'admin' ) {
                    $lAutorisation = true;
                }
                break;
            
            default:
                throw new Exception("Erreur usr_type inconnu : ".$sUsrType);
                break;
        }

       return($lAutorisation);
   }

    public static function setSession( $param, $value )
    {
        $_SESSION[$param] = $value;
    }

    public static function getSession( $param )
    {
        return( $_SESSION[$param] );
    }

    public static function emptySession( $param )
    {
        if ( isset($_SESSION[$param]) && ! empty($_SESSION[$param]) ) {
            return(false);
        }
        return( true );
    }

    public static function alertError( $sMessage )
    {
        self::setSession( 'alert-color', 'alert-danger' );
        self::setSession( 'alert-text', $sMessage );
    }

    public static function alertSuccess( $sMessage )
    {
        self::setSession( 'alert-color', 'alert-success' );
        self::setSession( 'alert-text', $sMessage );
    }

   public static function haveAlert()
   {
        if ( ! self::emptySession('alert-color') && ! self::emptySession('alert-text') ) {
            return(true);
        }

        return(false);
   }

    public static function getAlert()
    {
       $aAlert = array();

        if ( ! self::emptySession('alert-color') && ! self::emptySession('alert-text') ) {
            $aAlert['alert-color'] = $_SESSION['alert-color'];
            $aAlert['alert-text'] = $_SESSION['alert-text'];
            unset( $_SESSION['alert-color'] );
            unset( $_SESSION['alert-text'] );
        }

        return($aAlert);
    }

   private function initUser($nUserId)
   {
    $oUser = new UtilisateursModel();
    if ($nUserId != 0) {
        $oUser->readWhere( ['utilisateur_id' => $nUserId] );
    } else {
        $oUser->setDefault();
    }
    $this->user_data = $oUser->toArray();
   }
   
    private function loadMenu()
    {
    $aMenu = array();

    foreach (self::MENU_COMPLET as $aOption) {

        if ( $this->connecte() && $this->autorisation('admin') ) {
            // L'utilisateur est connecté et est admin
            if ($aOption['login'] == true) {
                $aMenu[] = $aOption;
            }    
        }
        elseif ( $this->connecte() && $this->autorisation('user') ) {
            // L'utilisateur est connecté et est un "user"
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

}
 
?>