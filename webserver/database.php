<?php 
require_once("configModel.php");

function openDatabase()
{
    global $bdd;

    $sMySQLHost = getConfig('MYSQL_HOST');
    $sMySQLDatabase = getConfig('MYSQL_DATABASE');
    $sMySQLUser = getConfig('MYSQL_USER');
    $sMySQLPassword = getConfig('MYSQL_PASSWORD');

    if (
        ! is_null($sMySQLHost) &&
        ! empty($sMySQLHost) &&
        ! is_null($sMySQLDatabase) &&
        ! empty($sMySQLDatabase) &&
        ! is_null($sMySQLUser) &&
        ! empty($sMySQLUser) &&
        ! is_null($sMySQLPassword) &&
        ! empty($sMySQLPassword) 
    ) {
        $sPDOConnectString = "mysql:host=$sMySQLHost;dbname=$sMySQLDatabase;charset=utf8";
        $bdd = new PDO($sPDOConnectString, $sMySQLUser, $sMySQLPassword);
        $bdd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } else {
        throw new Exception("erreur config.json: base de donnees non configuree.", 1);
    }
}

function closeDatabase()
{
    global $bdd;

    $bdd = null;
}

$bdd = null;
