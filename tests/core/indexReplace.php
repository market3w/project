<?php
session_start();

require_once $base."core/testMaster.php";

$folder_temp = explode("/",preg_replace("/(?:tests\/)([a-z]+)\/([a-zA-Z0-9-_]*).php/", "$1", $_SERVER['SCRIPT_FILENAME']));
$folder = $folder_temp[count($folder_temp)-1];

switch($folder){
    case 'api':
            $iDB = apiIndexReplace();
            break;
    default:
            break;
}

function apiIndexReplace(){
    require_once str_replace("tests", "src", $base."api/Application/Configs/Settings.php");
    require_once preg_replace("tests", "src", $base."api/Library/Core/Connexion.php");
    
    $iSettings = new Application_Configs_Settings();

    $connexion = new Library_Core_Connexion();
    $connexion->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
    return $connexion;
}