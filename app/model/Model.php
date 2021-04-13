<?php

class Model
{
//    private $field_list = null;
    private $table_definition = null;
    private $dbh;

    protected $data = [];
    protected $table_name = null;

    public function updateWhere(  $aFields = null, $aWhere = null  )
    {

        $oQuery = new QueryPrepare( $this->table_name, $this->table_definition );
        $sQuery = $oQuery->makeUpdateQuery( $aFields, $aWhere );

        // preparation de la requete
        $stmt = $this->dbh->prepare( $sQuery );
        if ( $stmt === false ) {
            throw new Exception("Erreur préparation requete : $sQuery");
        }

//        print($sQuery);

        // remplacement des parametres
        $this->bindParams( $stmt, $oQuery->paramUpdate($aFields) );
        $this->bindParams( $stmt, $oQuery->paramWhere($aWhere) );

        // Execution de la requete
        if ( $stmt->execute() === true ) {
            // La requete est correctement executee
            return(true);
        }
    
        return(false);
    }    

    public function create()
    {
        $nReturnId = 0;

        $oQuery = new QueryPrepare( $this->table_name, $this->table_definition );
        $sQuery = $oQuery->makeInsertQuery();
//        print("Query:" . $sQuery.PHP_EOL);

        // preparation de la requete
        $stmt = $this->dbh->prepare( $sQuery );
        if ( $stmt === false ) {
            throw new Exception("Erreur préparation requete : $sQuery");
        }

        // remplacement des parametres
        $this->bindParams( $stmt, $oQuery->paramInsert() );

        // Execution de la requete
        if ( $stmt->execute() === true ) {
            $nReturnId = (int)$this->dbh->lastInsertId();            
        }

        return($nReturnId);
    }

    public function index( $aFields = null )
    {
        return( $this->indexWhere($aFields) );
    }

    public function indexWhere( $aFields = null, $aWhere = null )
    {
        $aIndex = array();

        $oQuery = new QueryPrepare( $this->table_name, $this->table_definition );
        $sQuery = $oQuery->makeIndexQuery( $aFields, $aWhere );

        // preparation de la requete
        $stmt = $this->dbh->prepare( $sQuery );
        if ( $stmt === false ) {
            throw new Exception("Erreur préparation requete : $sQuery");
        }

        // remplacement des parametres
        $this->bindParams( $stmt, $oQuery->paramWhere($aWhere) );

        // Execution de la requete
        if ( $stmt->execute() === true ) {
            // La requete est correctement executee
            $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($resultat !== false) {
                $aIndex = $resultat;
            }            
        }
    
        return($aIndex);
    }

    public function readWhere( $aWhere = null )
    {

        $oQuery = new QueryPrepare( $this->table_name, $this->table_definition );
        $sQuery = $oQuery->makeReadQuery( $aWhere );

        // preparation de la requete
        $stmt = $this->dbh->prepare( $sQuery );
        if ( $stmt === false ) {
            throw new Exception("Erreur préparation requete : $sQuery");
        }

        // remplacement des parametres
        $this->bindParams( $stmt, $oQuery->paramWhere($aWhere) );

        // Execution de la requete
        if ( $stmt->execute() === true ) {
            // La requete est correctement executee
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultat !== false) {
                foreach ($resultat as $sChamp => $value) {
                    // Conversion des entiers car PDO retourne des chaines !
                    if ( $this->table_definition[$sChamp]['pdo_type'] == PDO::PARAM_INT ) {
                        $value = (int)$value;
                    }
                    $this->__set( $sChamp, $value );                    
                }
                return(true);
            }            
        }
    
        return(false);
    }

    public function deleteWhere( $aWhere = null )
    {

        $oQuery = new QueryPrepare( $this->table_name, $this->table_definition );
        $sQuery = $oQuery->makeDeleteQuery( $aWhere );

        // preparation de la requete
        $stmt = $this->dbh->prepare( $sQuery );
        if ( $stmt === false ) {
            throw new Exception("Erreur préparation requete : $sQuery");
        }

        // remplacement des parametres
        $this->bindParams( $stmt, $oQuery->paramWhere($aWhere) );

        // Execution de la requete
        if ( $stmt->execute() === true ) {
            return(true);
        }
    
        return(false);
    }    


    public function bindParams( $stmt, $aParams )
    {
//        print_r($aParams);

        // remplacement des parametres
        foreach( $aParams as $sChamp => $aParam ) {
//            print("BindParam:".$sChamp);

            $value = $aParam['value'] ?? $this->__get($sChamp); 
            if ( ! $stmt->bindValue( $aParam['parameter'], $value, $aParam['pdo_type'] ) ) {
                throw new Exception( sprintf( "Erreur bindValue %s %s", $aParam['parameter'], $this->__get($sChamp) ) );
            }
        }
    }


    public function __construct( $sTableName, $aTableDefinition)
    {
        if ( ! is_string($sTableName) || empty($sTableName) ) {
            throw new \Exception(__CLASS__.": table name $sTableName incorrect", 1);
        }

        $this->table_name = $sTableName;
        $this->table_definition = $aTableDefinition;

        $this->setDefault();

        $this->dbh = Database::connexion();
    }

    public function setDefault()
    {
        foreach ($this->table_definition as $sNomChamp => $aChamp) {
            $this->data[$sNomChamp] = $aChamp['default'];
        }
    }

    public function __get($sName)
    {
        if (! array_key_exists($sName, $this->table_definition )) {
            throw new \Exception(__CLASS__.": undefined property $sName", 1);
        }
  
        return($this->data[$sName]);
    }
  
    public function __set( $name, $value )
    {
        if ( ! array_key_exists($name, $this->table_definition) ) {
            throw new Exception(__CLASS__.": Le champ $name n'existe pas dans l'objet", 1);
        }

        if ( ! $this->validate( $name, $value ) ) {
            throw new Exception(__CLASS__.": Erreur mise à jour champ $name avec $value. Valeur invalide", 1);    
        }

        $this->data[$name] =  $value;        
    }

    public function validate( $name, $value )
    {
//        var_dump($this->table_definition);
        $ValidFunction = $this->table_definition[$name]['valid'];
        $lValid = $ValidFunction($value);

        return($lValid);
    }

    public function toArray()
    {
        return($this->data);
    }

    protected function cleanTableDefinition($aInput)
    {

        if ( ! is_array($aInput) || count($aInput) == 0 ) {
            throw new \Exception(__CLASS__.": table definition incorrecte", 1);
        }

        $aTableDefinition = array();

        foreach ($aInput as $sChamp => $aParameters) {
            
            if ( isset($aParameters['valid']) && is_string($aParameters['valid']) && !empty($aParameters['valid']) ) {
                $aParameters['valid'] === $aParameters['valid'];
            } else {
                $aParameters['valid'] = "Valid::alwaysTrue";
            }

            $aParameters['default'] = $aParameters['default'] ?? null;

            if ( !isset($aParameters['pdo_type']) ) {
                $aParameters['pdo_type'] = PDO::PARAM_STR;
            }

            if ( isset($aParameters['autoincrement']) && is_bool($aParameters['autoincrement']) ) {
                $aParameters['autoincrement'] === $aParameters['autoincrement'];
            } else {
                $aParameters['autoincrement'] = false;
            }
            
            if ( isset($aParameters['primary']) && is_bool($aParameters['primary']) ) {
                $aParameters['primary'] === $aParameters['primary'];
            } else {
                $aParameters['primary'] = false;
            }

            // Parametres normalisés
            $aTableDefinition[$sChamp] = $aParameters;                
        }

        return($aTableDefinition);
    }

}
