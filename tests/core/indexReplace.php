<?php
session_start();

require_once BASE_TEST."core/testMaster.php";

switch(FOLDER){
    case 'api':
            $iDB = apiIndexReplace();
            break;
    default:
            break;
}

function apiIndexReplace(){
    require_once BASE_SRC."api/Library/Core/Connexion.php";
    
    define("RTC_ROOT", "http://videoconference.market3w.test.com");
    define("INTRANET_ROOT", "http://intranet.market3w.test.com");
    define("VITRINE_ROOT", "http://www.market3w.test.com");
        
    define("DB_HOST",   "localhost");
    define("DB_NAME",   "market3w");
    define("DB_USER",   "market3w_user");
    define("DB_PASS",   "Gru15;7T$");
    define("DB_CHARSET","utf8");

    define("SALT_USER_PWD", '=+/e-Kue/vW--y?cj:,54rsfgh:lm&d5eE>tl#rmzh./M+Jz47a,sz>BARyXrRXZ4P~%');

    date_default_timezone_set("Europe/Paris");
    ini_set('session.gc_maxlifetime', 7200);
    ini_set('session.cookie_lifetime', 7200);

    $connexion = new Library_Core_Connexion();
    $connexion->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
    return $connexion;
}