<?php
	session_start();
	
	$_SESSION["errorMessage"]="";
	$_SESSION["errorServer"]="";
	$_SESSION["method"]="";

	function class_autoload($class){
		require_once(str_replace("index", str_replace("_", "/", $class), $_SERVER['SCRIPT_FILENAME']));
	}
	
	spl_autoload_register('class_autoload');
	
	//define("WEB_ROOT", str_replace(end($getPage), '', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
	if($_SERVER['SERVER_NAME']=="127.0.0.1" || $_SERVER['SERVER_NAME']=="localhost"){
		define("SERVER_ROOT", preg_replace("/siteweb\/([a-zA-Z0-9-_]*).php/", "api/", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
	} else {
		define("SERVER_ROOT", preg_replace("/([^test]*)test.com/", "api.test.com", "http://".$_SERVER['SERVER_NAME']));
	}
	
	$client = new Client_Core_Client;
	
	$method = (array_key_exists("method",$_POST))? $_POST["method"]:null;
	if(!is_null($method)){
		unset($_POST["method"]);
		$_SESSION["method"]=$method;
		$client->$method($_POST);
	}