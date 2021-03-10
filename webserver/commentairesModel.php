<?php
require_once( "database.php" );

define( 
    "SQL_COMMENT_INDEX",
    "SELECT * FROM commentaires ORDER BY date_commentaire DESC LIMIT 4" 
);

define( 
    "SQL_COMMENT_CREATE",
    "INSERT INTO commentaires(pseudo, commentaire, date_commentaire) 
    VALUES(:pseudo, :commentaire, :date_commentaire)"
);

function ajouterCommentaire( $sPseudo, $sCommentaire )
{
    global $bdd;

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_COMMENT_CREATE );
    if (
        $stmt !== false &&
        $stmt->bindValue(':pseudo', $sPseudo, PDO::PARAM_STR) &&
        $stmt->bindValue(':commentaire', $sCommentaire, PDO::PARAM_STR) &&
        $stmt->bindValue(':date_commentaire', time(), PDO::PARAM_INT) 
        ) {
        $stmt->execute();
    }
}

function indexCommentaires()
{
    global $bdd;

    $comment = array();

    if ($bdd === null) {
        openDatabase();
    }
    // preparation de la requete et remplacement des parametres
    $stmt = $bdd->prepare( SQL_COMMENT_INDEX );
    if ( $stmt !== false && $stmt->execute() ) {
        // La requete est correctement executee
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultat !== false) {
            $comment = $resultat;
        }
    }

    return($comment);
}