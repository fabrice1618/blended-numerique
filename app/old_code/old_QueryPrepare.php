<?php

class QueryPrepare
{

    private $table_name;
    private $table_definition;

    public function __construct( $sTableName, $aTableDefinition )
    {
        $this->table_name = $sTableName;
        $this->table_definition = $aTableDefinition;
    }

    public function makeDeleteQuery( $aWhere = null )
    {
        $sQueryTemplate = "DELETE FROM %s WHERE %s";
        $sQuery = sprintf( 
            $sQueryTemplate,
            $this->table_name,
            $this->clauseSelectWhere( $aWhere )
        );
//        print("Query:" . $sQuery.PHP_EOL);
        return($sQuery);
    }

    public function makeReadQuery( $aWhere = null )
    {
        $sQueryTemplate = "SELECT * FROM %s WHERE %s LIMIT 1";
        $sQuery = sprintf( 
            $sQueryTemplate,
            $this->table_name,
            $this->clauseSelectWhere( $aWhere )
        );
//        print("Query:" . $sQuery.PHP_EOL);
        return($sQuery);
    }

    public function makeIndexQuery( $aFields = null, $aWhere = null )
    {
        $sQueryTemplate = "SELECT %s FROM %s WHERE %s";
        $sQuery = sprintf( 
            $sQueryTemplate,
            $this->clauseSelectFields( $aFields ),
            $this->table_name,
            $this->clauseSelectWhere( $aWhere )
        );
//        print("Query:" . $sQuery.PHP_EOL);
        return($sQuery);
    }

    public function makeUpdateQuery( $aFields = null, $aWhere = null )
    {

        $sQueryTemplate = "UPDATE %s SET %s WHERE %s";
        $sQuery = sprintf( 
            $sQueryTemplate,
            $this->table_name,
            $this->clauseUpdateFields($aFields),
            $this->clauseSelectWhere( $aWhere )
        );
//        print("Query:" . $sQuery.PHP_EOL);

        return($sQuery);
    }

    public function makeInsertQuery()
    {
        $sQueryTemplate = "INSERT INTO %s (%s) VALUES (%s)";
        $sQuery = sprintf( 
            $sQueryTemplate,
            $this->table_name,
            $this->clauseInsertFields(),
            $this->clauseInsertValues() 
        );

        return($sQuery);
    }

    private function clauseSelectFields( $aFields = null )
    {
        if ( is_null($aFields) || !is_array($aFields) || count($aFields) == 0 ) {
            return("*");
        }

        $aSelectParts = [];
        foreach ($aFields as $sChamp) {
            $aSelectParts[] = $sChamp;
        }
    
        return( implode(", ", $aSelectParts) );
    }

    private function clauseSelectWhere( $aWhere = null )
    {
        if ( is_null($aWhere) || !is_array($aWhere) || count($aWhere) == 0 ) {
            return("TRUE");
        }

        $aWhereParts = array();
        foreach ($aWhere as $sChamp => $value) {
            $aWhereParts[] = sprintf( "%s = :%s", $sChamp, $sChamp);
        }

        return( implode(" AND ", $aWhereParts) );
    }

    public function paramWhere( $aWhere = null )
    {
        if ( is_null($aWhere) || !is_array($aWhere) || count($aWhere) == 0 ) {
            return( array() );
        }

        $aFields = array();
        foreach ($aWhere as $sChamp => $value) {
            $aFields[$sChamp] = [   
                'parameter' => ':'.$sChamp, 
                'value' => $value, 
                'pdo_type' => $this->table_definition[$sChamp]['pdo_type'] 
                ];
        }
    
        return( $aFields );
    }


    private function clauseUpdateFields( $aFields = null )
    {
        $aUpdateParts = array();

        if ( is_null($aFields) || !is_array($aFields) || count($aFields) == 0 ) {
            foreach ($this->table_definition as $sChamp => $aParam) {
                if ( $aParam['primary'] !== true ) {
                    $aUpdateParts[] = sprintf( "%s = :%s", $sChamp, $sChamp );
                }
            }
        } else {
            foreach ($aFields as $sChamp) {
                $aUpdateParts[] = sprintf( "%s = :%s", $sChamp, $sChamp );
            }
        }

        return( implode(", ", $aUpdateParts) );
    }

    public function paramUpdate( $aFields = null )
    {
        $aParamList = array();

        if ( is_null($aFields) || !is_array($aFields) || count($aFields) == 0 ) {
            foreach ($this->table_definition as $sChamp => $aParam) {
                if ( $aParam['primary'] !== true ) {
                    $aParamList[$sChamp] = [ 
                        'parameter' => ':'.$sChamp, 
                        'pdo_type' => $aParam['pdo_type'] 
                    ];
                }
            }
    
        } else {
            foreach ($aFields as $sChamp) {
                $aParamList[$sChamp] = [ 
                    'parameter' => ':'.$sChamp, 
                    'pdo_type' => $this->table_definition[$sChamp]['pdo_type'] 
                ];
            }
        }

        return( $aParamList );
    }


    private function clauseInsertFields()
    {
        $aFields = array();
        foreach ($this->table_definition as $sChamp => $aParam) {
            if ( $aParam['autoincrement'] !== true ) {
                $aFields[] = $sChamp;
            }
        }

        return( implode(',', $aFields) );
    }

    private function clauseInsertValues()
    {
        $aFields = array();
        foreach ($this->table_definition as $sChamp => $aParam) {
            if ( $aParam['autoincrement'] !== true ) {
                $aFields[] = ':' . $sChamp;
            }
        }

        return( implode(',', $aFields) );
    }

    public function paramInsert()
    {
        $aFields = array();
        foreach ($this->table_definition as $sChamp => $aParam) {
            if ( $aParam['autoincrement'] !== true ) {
                $aFields[$sChamp] = [ 
                    'parameter' => ':'.$sChamp, 
                    'pdo_type' => $aParam['pdo_type'] 
                ];
            }
        }

        return( $aFields );
    }

}