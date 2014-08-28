<?php
/**
 * La classe Application_Configs_Settings configure le webservice
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Configs_Settings{
    /**
     * Méthode magique __construct
     * Défini les constantes de l'api
     */
    public function __construct() {
        define("API_ROOT", str_replace("index.php", "", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
        if($_SERVER['SERVER_NAME']=="127.0.0.1" || $_SERVER['SERVER_NAME']=="localhost"){
            define("RTC_ROOT", str_replace("api/index.php", "videoconference/", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
        } else {
            define("RTC_ROOT", str_replace("api", "videoconference", "http://".$_SERVER['SERVER_NAME']));
        }
        
        define("DB_HOST",   "localhost");
        define("DB_NAME",   "market3w");
        define("DB_USER",   "market3w_user");
        define("DB_PASS",   "Gru15;7T$");
        define("DB_CHARSET","utf8");
        
        define("SALT_USER_PWD", '=+/e-Kue/vW--y?cj:,54rsfgh:lm&d5eE>tl#rmzh./M+Jz47a,sz>BARyXrRXZ4P~%');
    }
}