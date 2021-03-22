<?php 

// Controle si le parametre est une chaine, non vide et d'une longueur inférieure à $nLen
function checkStr( $val, $nLenMin, $nLenMax )
{
    $bReturn = true;

    if (    
        ! is_string($val) || 
        empty($val) || 
        strlen($val) < $nLenMin ||
        strlen($val) > $nLenMax 
        ) {
        throw new Exception("Erreur: parametre incorrect - type attendu: string");
    }

    return($bReturn);
}

// Controle si le parametre est un identifiant valide (entier positif)
function checkId( $val )
{
    $bReturn = true;

    if (! is_int($val) || ( $val < 1 ) ) {
        $bReturn = false;
        throw new Exception("Erreur: parametre incorrect - attendu: entier positif");
    }

    return($bReturn);
}

// Controle si le parametre est un array et qu'il contient les champs en parametre
function checkArray( $val, $aChamps )
{
    $bReturn = true;

    if (! is_array($val) ) {
        $bReturn = false;
        throw new Exception("Erreur: parametre incorrect - attendu: array");
    }

    foreach ($aChamps as $sChamp) {
        if ( !isset( $val[$sChamp] ) ) {
            $bReturn = false;
            throw new Exception("Erreur: parametre manquant - champ: $sChamp");
        }
    }

    return($bReturn);
}

// Controle si le parametre est une date valide
function checkDateTime( $val )
{
    $bReturn = true;

    if ( ! date_create_from_format('Y-m-j H:i:s', $val) ) {
        $bReturn = false;
        throw new Exception("Erreur: parametre incorrect - attendu: date");
    }

    return($bReturn);
}
