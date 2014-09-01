<?php
session_start();

require_once BASE_TEST."core/testMaster.php";

switch($folder){
    case 'api':
            $iDB = apiIndexReplace();
            break;
    default:
            break;
}

function apiIndexReplace(){
    require_once BASE_SRC."api/Application/Configs/Settings.php";
    require_once BASE_SRC."api/Library/Core/Connexion.php";
    
    $iSettings = new Application_Configs_Settings();

    $connexion = new Library_Core_Connexion();
    $connexion->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
    return $connexion;
}