<?php
require_once( "database.php" );

define( 
    "SQL_USER_AUTH",
    "SELECT utilisateur_id, usr_type 
    FROM utilisateurs 
    WHERE usr_email = :usr_email 
    AND usr_pwd = :usr_pwd" 
);

define( 
    "SQL_USER_CREATE",
    "INSERT INTO utilisateurs(usr_email, usr_pwd, usr_type) 
    VALUES(:usr_email, :usr_pwd, :usr_type)" 
);

// Verifie si email et password sont OK et retourne utilisateur_id, sinon false
function checkAuth($sEmail, $sPassword)
{
    global $bdd;

    $auth = false;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_AUTH );
    if (
        $stmt !== false &&
        $stmt->bindValue(':usr_email', $sEmail, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_pwd', $sPassword, PDO::PARAM_STR) &&
        $stmt->execute()
        ) {
        // La requete est correctement executee
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $auth = $resultat['utilisateur_id'];
        }
    }

    return($auth);
}

function ajouterUtilisateur( $sEmail, $sPassword, $sType )
{
    global $bdd;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_CREATE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':usr_email', $sEmail, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_pwd', $sPassword, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_type', $sType, PDO::PARAM_STR) 
        ) {
        $stmt->execute();
    }
}
