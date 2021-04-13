<?php

class UtilisateursModel extends Model
{
    const TABLENAME = 'utilisateurs';

    const USR_TYPE = [ 
        'guest' => 'Invité', 
        'user' => 'Utilisateur', 
        'admin' => 'Administrateur'
    ];

    const USR_ACTIVE = [ 'active', 'inactive'];

    const LISTE_CHAMPS = [
        'utilisateur_id' => [ 
            'valid' => 'Valid::checkId',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT,
            'autoincrement' => true,
            'primary' => true
        ],
        'usr_email' => [ 
            'valid' => 'Valid::checkEmail',
            'default' => null,
            'pdo_type' => PDO::PARAM_STR
        ],
        'usr_pwd' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
       ],
        'usr_prenom' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'usr_nom' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'usr_type' => [ 
            'valid' => 'UtilisateursModel::checkUsrType',
            'default' => 'guest',
            'pdo_type' => PDO::PARAM_STR
        ],
        'usr_active' => [ 
            'valid' => 'UtilisateursModel::checkUsrActive',
            'default' => 'inactive',
            'pdo_type' => PDO::PARAM_STR
            ]       
    ];

    public function __construct()
    {
        $aTableDefinition = $this->cleanTableDefinition(self::LISTE_CHAMPS);
        parent::__construct( self::TABLENAME, $aTableDefinition );
    }

    public static function checkUsrType($val)
    {

        if ( ! is_string($val) || empty($val) || ! array_key_exists($val, self::USR_TYPE) ) {
            throw new Exception("Erreur: parametre incorrect - type attendu: usr_type");
        }

        return(true);
    }

    public static function descUsrType($sUsrType)
    {
        if ( ! is_string($sUsrType) || empty($sUsrType) || ! array_key_exists($sUsrType, self::USR_TYPE) ) {
            throw new Exception("Erreur: parametre incorrect - type attendu: usr_type");
        }

        return(self::USR_TYPE[$sUsrType] );
    }

    public static function checkUsrActive($val)
    {

        if ( ! is_string($val) || empty($val) || ! in_array($val, self::USR_ACTIVE) ) {
            throw new Exception("Erreur: parametre incorrect - type attendu: usr_active");
        }

        return(true);
    }

    public function setRandomPassword()
    {

    $sNewPassword = bin2hex(random_bytes(4));
    $sPasswordHash = $sNewPassword;

    $oUSer->usr_pwd = $sPasswordHash;

    return($sNewPassword);
    }
}
