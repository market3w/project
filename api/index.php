<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}

session_start();

function class_autoload($class){
    require_once(str_replace("index", str_replace("_", "/", $class), $_SERVER['SCRIPT_FILENAME']));
}

spl_autoload_register('class_autoload');

$json = true;
if(array_key_exists("json",$_GET)){
	$json = ($_GET["json"]!=0)?true:false;
	unset($_GET["json"]);
}

$iSettings = new Application_Configs_Settings();

$iDB = new Library_Core_Connexion();
$iDB->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);

$server = new Library_Core_RestServer('Library_Core_Service',$json);
$server->handle();