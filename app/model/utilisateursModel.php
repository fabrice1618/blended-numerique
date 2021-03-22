<?php
require_once( "model/database.php" );

define( 
    "SQL_USER_AUTH",
    "SELECT utilisateur_id, usr_pwd, usr_type, usr_active 
    FROM utilisateurs 
    WHERE usr_email = :usr_email 
    AND usr_pwd = :usr_pwd" 
);

define( 
    "SQL_USER_CREATE",
    "INSERT INTO utilisateurs(usr_email, usr_pwd, usr_prenom, usr_nom, usr_type, usr_active) 
    VALUES(:usr_email, :usr_pwd, :usr_prenom, :usr_nom, :usr_type, :usr_active)" 
);

define( 
    "SQL_USER_READ",
    "SELECT * FROM utilisateurs WHERE utilisateur_id = :utilisateur_id"
);

define( 
    "SQL_USER_FIND",
    "SELECT * FROM utilisateurs WHERE usr_email = :usr_email"
);

define( 
    "SQL_USER_UPDATE",
    "UPDATE utilisateurs SET usr_email=:usr_email, usr_pwd=:usr_pwd, usr_prenom=:usr_prenom, 
        usr_nom=:usr_nom, usr_type=:usr_type, usr_active=:usr_active
    WHERE utilisateur_id = :utilisateur_id" 
);

define( 
    "SQL_USER_DELETE",
    "DELETE FROM utilisateurs WHERE utilisateur_id = :utilisateur_id"
);

define( 
    "SQL_USER_INDEX_ADMIN",
    "SELECT * FROM utilisateurs WHERE usr_active='active' AND usr_type='admin'"
);

define( 
    "SQL_USER_INDEX_USERS",
    "SELECT * FROM utilisateurs WHERE usr_active='active' AND usr_type='user'"
);

define( 
    "SQL_USER_INDEX_INACTIVE",
    "SELECT * FROM utilisateurs WHERE usr_active<>'active'"
);

// Verifie si email et password sont OK et retourne utilisateur_id, sinon false
function checkAuth($sEmail, $sPassword)
{
    global $bdd;

    $nAuth = 0;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_AUTH );
    $sPasswordHash = $sPassword;
    if (
        $stmt !== false &&
        $stmt->bindValue(':usr_email', $sEmail, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_pwd', $sPasswordHash, PDO::PARAM_STR) &&
        $stmt->execute()
        ) {
        // La requete est correctement executee
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            if ($resultat['usr_active'] == 'active') {
                $nAuth = $resultat['utilisateur_id'];
            } else {
                $nAuth = -1;
            }            
        }
    }

    return($nAuth);
}

function createUtilisateur( $sEmail, $sPassword, $sPrenom, $sNom, $sType, $sActive )
{
    global $bdd;

    $nReturnId = 0;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_CREATE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':usr_email', $sEmail, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_pwd', $sPassword, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_prenom', $sPrenom, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_nom', $sNom, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_type', $sType, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_active', $sActive, PDO::PARAM_STR) 
        ) {

        try {
            $stmt->execute();
            $nReturnId = intval( $bdd->lastInsertId() );
        } catch (PDOException $e) {
            $nReturnId = 0;
        }
    }

    return($nReturnId);
}

function readUtilisateur( $nUtilisateurId )
{
    global $bdd;

    $aUtilisateur = array();

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_READ );
    if (
        $stmt !== false &&
        $stmt->bindValue(':utilisateur_id', $nUtilisateurId, PDO::PARAM_INT) &&
        $stmt->execute()
        ) {
        // La requete est correctement executee
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $aUtilisateur = $resultat;
        }
    }

    return($aUtilisateur);
}

function findUtilisateur( $sUsrEmail )
{
    global $bdd;

    $aUtilisateur = array();

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_FIND );
    if (
        $stmt !== false &&
        $stmt->bindValue(':usr_email', $sUsrEmail, PDO::PARAM_STR) &&
        $stmt->execute()
        ) {
        // La requete est correctement executee
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $aUtilisateur = $resultat;
        }
    }

    return($aUtilisateur);
}

function updateUtilisateur( $nUtilisateurId, $sEmail, $sPassword, $sPrenom, $sNom, $sType, $sActive )
{
    global $bdd;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_UPDATE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':usr_email', $sEmail, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_pwd', $sPassword, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_prenom', $sPrenom, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_nom', $sNom, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_type', $sType, PDO::PARAM_STR) &&
        $stmt->bindValue(':usr_active', $sActive, PDO::PARAM_STR) &&
        $stmt->bindValue(':utilisateur_id', $nUtilisateurId, PDO::PARAM_INT) 
        ) {
        $stmt->execute();
    }
}

function deleteUtilisateur( $nUtilisateurId )
{
    global $bdd;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_USER_DELETE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':utilisateur_id', $nUtilisateurId, PDO::PARAM_INT) 
        ) {
        $stmt->execute();
    }
}

function indexUtilisateur($sQueryIndex)
{
    global $bdd;

    $aUtilisateurs = array();

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( $sQueryIndex );
    if (
        $stmt !== false &&
        $stmt->execute()
        ) {
        // La requete est correctement executee
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $aUtilisateurs = $resultat;
        }
    }

    return($aUtilisateurs);
}


function indexAdminUtilisateur()
{
    return(indexUtilisateur(SQL_USER_INDEX_ADMIN));
}

function indexUsersUtilisateur()
{
    return(indexUtilisateur(SQL_USER_INDEX_USERS));
}

function indexInactiveUtilisateur()
{
    return(indexUtilisateur(SQL_USER_INDEX_INACTIVE));
}

