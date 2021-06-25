<?php 
/* Modèle formations v1 - Sans gestion des erreurs et avec faille de sécurité !!!
*/


class FormationModel
{

    private $dbh;

    protected $data = [];

    

    public function __construct( )
    {
        $this->dbh = Database::connexion();

        $this->data['formation_id'] = null;
        $this->data['formation'] = '';
        $this->data['form_active'] = false;

    }


    // Read - lecture d'une formation
    function read( $formation_id ) 
    {
        
        if ( Valid::checkId( $formation_id ) ) {
            $sRequete = "SELECT * 
                    FROM formations 
                    WHERE formation_id = $formation_id"; 
            $stmt = $this->dbh->query( $sRequete, PDO::FETCH_ASSOC );
            $aFormation = $stmt->fetch();   // recuperer un seul enregistrement

            $this->formation_id = $formation_id;
            $this->formation = $aFormation['formation'];
            $this->form_active = $aFormation['form_active'];
        }

    }
    

    // Update - modification d'une formation
    public function update() 
    {
            
        $sRequete = "UPDATE formations 
                     SET formation = ':formation', 
                         form_active = ':form_active'
                     WHERE formation_id = ':formation_id'";


        $stmt1 = $this->dbh->prepare( $sRequete );

        $stmt1->bindValue(':formation_id', intval($this->formation_id), PDO::PARAM_INT);
        $stmt1->bindValue(':formation', $this->formation, PDO::PARAM_STR);
        $stmt1->bindValue(':form_active', $this->form_active, PDO::PARAM_STR);

            if ( $stmt1->execute() ) {
//                echo "Update réussi\n";
                
                return(true);
            }
                                

        return(false);
    }

    // Delete - effacement d'une formation
    public function delete( $formation_id ) 
    {

        if ( Valid::checkId( $formation_id ) ) {
            $sRequete = "DELETE FROM formations 
                        WHERE formation_id = $formation_id";        // ACHTUNG SQLI
            $this->dbh->query( $sRequete );
            return(true);
        }

        return(false);
    }    

    // Liste de toutes les formations
    public function index() 
    {

        $sRequete = "SELECT * FROM formations";

        $stmt = $this->dbh->query( $sRequete, PDO::FETCH_ASSOC );
        $aFormations = $stmt->fetchAll();   // Récupération de toutes les lignes

        return( $aFormations );
    }
        



    public function __get($sName)
    {
        if (! array_key_exists($sName, $this->data )) {
            throw new \Exception(__CLASS__.": undefined property $sName", 1);
        }
  
        return($this->data[$sName]);
    }
  
    public function __set( $name, $value )
    {
        if ( ! array_key_exists($name, $this->data) ) {
            throw new Exception(__CLASS__.": Le champ $name n'existe pas dans l'objet", 1);
        }

        /*
        if ( ! $this->validate( $name, $value ) ) {
            throw new Exception(__CLASS__.": Erreur mise à jour champ $name avec $value. Valeur invalide", 1);    
        }
*/

        $this->data[$name] =  $value;        
    }


    public function toArray()
    {
        return($this->data);
    }

    public function toString()
    {
        return(json_encode($this->data));
    }

}




// Create - creation nouvelle formation
function createFormations( $formation ) 
{
    global $bdd;

    $nId = 0;

    if ( checkStr( $formation, 2, 250 ) ) {
        $sRequete = "INSERT INTO formations (formation) 
                    VALUES ('$formation')";
        $bdd->query( $sRequete );
        $nId = intVal( $bdd->lastInsertId() );
    }

    return( $nId );
}




