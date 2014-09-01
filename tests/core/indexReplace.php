<?php
session_start();

require_once preg_replace("/(?:tests\/)([a-z]+)\/([a-zA-Z0-9-_]*).php/", "tests/core/testMaster.php", $_SERVER['SCRIPT_FILENAME']);

$folder = explode("/",preg_replace("/(?:tests\/)([a-z]+)\/([a-zA-Z0-9-_]*).php/", "$1", $_SERVER['SCRIPT_FILENAME']));
$folder = str_replace($_SERVER, "", $folder[count($folder)-1]);

switch($folder){
    case 'api':
            $iDB = apiIndexReplace();
            break;
    default:
            break;
}

function apiIndexReplace(){
    require_once preg_replace("/(?:tests\/)api\/([a-zA-Z0-9-_]*).php/", "src/api/Application/Configs/Settings.php", $_SERVER['SCRIPT_FILENAME']);
    require_once preg_replace("/(?:tests\/)api\/([a-zA-Z0-9-_]*).php/", "src/api/Library/Core/Connexion.php", $_SERVER['SCRIPT_FILENAME']);
    
    $iSettings = new Application_Configs_Settings();

    $connexion = new Library_Core_Connexion();
    $connexion->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
    return $connexion;
}