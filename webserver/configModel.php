<?php 
define( 'CONFIG_FILE', 'config.json' );

function getConfig($sParam)
{
    global $aConfig;

    $return = null;

    if ( is_null($aConfig) ) {
        readConfig();
    }

    if ( isset($aConfig[$sParam]) ) {
        $return = $aConfig[$sParam];
    }

    return($return);
}

function setConfig($sParam, $value)
{
    global $aConfig;

    if ( is_null($aConfig) ) {
        $aConfig = array();
    }

    $aConfig[$sParam] = $value;
}

function readConfig()
{
    global $aConfig;

    if ( file_exists(CONFIG_FILE) ) {
        $aContent = json_decode( file_get_contents(CONFIG_FILE), true );

        if ( ! is_null($aContent) ) {
            $aConfig = $aContent;
        } else {
            // Erreur interpretation du fichier JSON
            defaultConfig();
            writeConfig();
        }    
    } else {
        // Le fichier de config n'existe pas, on le cree
        defaultConfig();
        writeConfig();
    }
}

function writeConfig()
{
    global $aConfig;

    if ( is_null($aConfig) ) {
        readConfig();
    }
    file_put_contents( CONFIG_FILE, json_encode($aConfig, JSON_PRETTY_PRINT) );
}

function defaultConfig()
{
    setConfig('MYSQL_HOST', '');
    setConfig('MYSQL_DATABASE', '');
    setConfig('MYSQL_USER', '');
    setConfig('MYSQL_PASSWORD', '');
}

$aConfig = null;