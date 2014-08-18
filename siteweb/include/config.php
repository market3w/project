<?php
	session_start();
	
	$_SESSION["market3w_user"] = (array_key_exists("market3w_user",$_SESSION) && $_SESSION["market3w_user"]!="")? $_SESSION["market3w_user"]:"";
	$_SESSION["errorMessage"]="";
	$_SESSION["errorServer"]="";
	$_SESSION["method"]="";

	function class_autoload($class){
		require_once(preg_replace("/([a-zA-Z0-9-_]*).php/", str_replace("_", "/", $class).".php", $_SERVER['SCRIPT_FILENAME']));
	}
	
	spl_autoload_register('class_autoload');
	
	if($_SERVER['SERVER_NAME']=="127.0.0.1" || $_SERVER['SERVER_NAME']=="localhost"){
		define("WEB_ROOT", preg_replace("/([a-zA-Z0-9-_]*).php/", "", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
		define("SERVER_ROOT", preg_replace("/siteweb\/([a-zA-Z0-9-_]*).php/", "api/", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
	} else {
		define("WEB_ROOT", "http://".$_SERVER['SERVER_NAME']);
		define("SERVER_ROOT", preg_replace("/([^test]*)test.com/", "api.test.com", "http://".$_SERVER['SERVER_NAME']));
	}
	
	$client = new Client_Core_Client;
	
	$method = (array_key_exists("method",$_POST))? $_POST["method"]:null;
	if(!is_null($method)){
		unset($_POST["method"]);
		$_SESSION["method"]=$method;
		$client->$method($_POST);
	}