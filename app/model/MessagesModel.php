<?php

class MessagesModel extends Model
{
    const TABLENAME = 'messages';

    const LISTE_CHAMPS = [
        'email_to' => [ 
            'valid' => 'Valid::checkEmail',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'sujet' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'message' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
       ],
        'headers' => [ 
            'valid' => 'Valid::alwaysTrue',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ]  
    ];

    public function __construct()
    {
        $aTableDefinition = $this->cleanTableDefinition(self::LISTE_CHAMPS);
        parent::__construct( self::TABLENAME, $aTableDefinition );
    }

}
