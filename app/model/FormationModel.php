<?php 

class FormationModel extends Model
{
    const LISTE_CHAMPS = [
        'formation_id' => [ 
            'valid' => 'Valid::checkId',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'formation' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
       ],
        'form_active' => [ 
            'valid' => 'FormationModel::checkFormActive',
            'default' => 'inactive',
            'pdo_type' => PDO::PARAM_STR
            ]       
    ];    

    const FORM_ACTIVE = [ 'active', 'inactive'];

    const QUERY_CREATE = "  INSERT INTO formations (formation, form_active) 
                            VALUES (':formation', ':form_active')";

    const QUERY_READ = "SELECT * FROM formations WHERE formation_id = :formation_id"; 

    const QUERY_UPDATE = "UPDATE formations 
                        SET formation = ':formation', 
                            form_active = ':form_active'
                        WHERE formation_id = ':formation_id'";

    const QUERY_DELETE = "DELETE FROM formations WHERE formation_id = :formation_id"; 

    const QUERY_INDEX = "SELECT * FROM formations";

    public function __construct( )
    {
        parent::__construct( self::LISTE_CHAMPS );
    }

    // Create - creation nouvelle formation
    public function create() 
    {
        $nId = 0;

        $stmt = $this->dbh->prepare( self::QUERY_CREATE );
        if (
            $stmt !== false &&
            $stmt->bindValue(':formation', $this->formation, PDO::PARAM_STR) &&
            $stmt->bindValue(':form_active', $this->form_active, PDO::PARAM_STR) &&
            $stmt->execute()
        ) {
            $nId = intVal( $this->dbh->lastInsertId() );            
        }

        return( $nId );
    }

    // Read - lecture d'une formation
    function read( $formation_id ) 
    {
        if ( $this->validate('formation_id', $formation_id) ) {
            $stmt = $this->dbh->prepare( self::QUERY_READ );
            if (
                $stmt !== false &&
                $stmt->bindValue(':formation_id', $this->formation_id, PDO::PARAM_INT) &&
                $stmt->execute()
            ) {
                $aFormation = $stmt->fetch();   // recuperer un seul enregistrement

                $this->formation_id = $aFormation['formation_id'];
                $this->formation = $aFormation['formation'];
                $this->form_active = $aFormation['form_active'];    
            }
        }
    }

    // Update - modification d'une formation
    public function update() 
    {
        $stmt = $this->dbh->prepare( self::QUERY_UPDATE );

        if (
            $stmt !== false &&
            $stmt->bindValue(':formation_id', $this->formation_id, PDO::PARAM_INT) &&
            $stmt->bindValue(':formation', $this->formation, PDO::PARAM_STR) &&
            $stmt->bindValue(':form_active', $this->form_active, PDO::PARAM_STR) &&
            $stmt->execute()
        ) {
            return(true);
        }

        return(false);
    }

    // Delete - effacement d'une formation
    public function delete( $formation_id ) 
    {
        if ( $this->validate('formation_id', $formation_id) ) {
            $stmt = $this->dbh->prepare( self::QUERY_DELETE );
            if (
                $stmt !== false &&
                $stmt->bindValue(':formation_id', $this->formation_id, PDO::PARAM_INT) &&
                $stmt->execute()
            ) {
                return(true);
            }
        }

        return(false);
    }    

    // Liste de toutes les formations
    public function index() 
    {
        $aFormations = array();

        $stmt = $this->dbh->prepare( self::QUERY_INDEX );
        if ( $stmt !== false && $stmt->execute() ) {
            $aFormations = $stmt->fetchAll();   // recuperer un seul enregistrement
        }

        return( $aFormations );
    }

    public static function checkFormActive($val)
    {

        if ( ! is_string($val) || empty($val) || ! in_array($val, self::FORM_ACTIVE) ) {
            throw new Exception("Erreur: parametre incorrect - type attendu: form_active");
        }

        return(true);
    }

}
