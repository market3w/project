<?php
class Application_Configs_Settings{
    public function __construct() {
        /*define("WEB_ROOT", str_replace("index.php", "", $_SERVER['SCRIPT_NAME']));
        define("LINK_ROOT", str_replace("Public/index.php", "", "http://localhost".$_SERVER['SCRIPT_NAME']));
        define("APP_ROOT", str_replace("Public/index.php", "Application/", $_SERVER['SCRIPT_FILENAME']));
        define("LIB_ROOT", str_replace("Public/index.php", "Library/", $_SERVER['SCRIPT_FILENAME']));*/
        
        define("DB_HOST",   "localhost");
        define("DB_NAME",   "market3w");
        define("DB_USER",   "market3w_user");
        define("DB_PASS",   "Gru15;7T$");
        define("DB_CHARSET","utf8");
        
        define("SALT_USER_PWD", '=+/e-Kue/vW--y?cj:,54rsfgh:lm&d5eE>tl#rmzh./M+Jz47a,sz>BARyXrRXZ4P~%');
    }
}
?>
