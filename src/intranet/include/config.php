<?php
    if(!($_SERVER['SERVER_NAME']=="127.0.0.1" || $_SERVER['SERVER_NAME']=="localhost")){
        session_set_cookie_params(0, '/', preg_replace("/([a-z.]*)market3w(.*)/", ".market3w$2", $_SERVER['SERVER_NAME']));
    }
	session_start();
        ini_set('session.gc_maxlifetime', 7200);
        ini_set('session.cookie_lifetime', 7200);
        $temp = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
        $temp = explode("/",$temp);
        
        $folder = null;
        if(array_key_exists(0, $temp) && $temp[0]!=""){
            $folder = $temp[0];
        } elseif(array_key_exists(0, $temp) && array_key_exists(1, $temp) && $temp[0]=="" && $temp[1]!=""){
            $folder = "/".$temp[1];
        }
        
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
            define("SERVER_ROOT", preg_replace("/intranet\/([a-zA-Z0-9-_]*).php/", "api/", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
            define("VITRINE_ROOT", preg_replace("/intranet\/([a-zA-Z0-9-_]*).php/", "siteweb/", "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']));
            define("UPLOAD_ROOT", $_SERVER['DOCUMENT_ROOT'].$folder."/src/intranet/upload/");
	} else {
            define("WEB_ROOT", "http://".$_SERVER['SERVER_NAME']."/");
            define("SERVER_ROOT", preg_replace("/([a-z.]*)market3w(.*)/", "http://api.market3w$2/", $_SERVER['SERVER_NAME']));
            define("VITRINE_ROOT", preg_replace("/([a-z.]*)market3w(.*)/", "http://www.market3w$2/", $_SERVER['SERVER_NAME']));
            define("UPLOAD_ROOT", $_SERVER['DOCUMENT_ROOT']."upload/");
	}
	$currentPage = ("http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']==WEB_ROOT.'index.php')? WEB_ROOT:"http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
	define("CURRENT_PAGE",$currentPage);
	
	$client = new Client_Core_Client;
	
	$method = (array_key_exists("method",$_POST))? $_POST["method"]:null;
	if(!is_null($method)){
		unset($_POST["method"]);
		$_SESSION["method"]=$method;
		$client->$method($_POST);
	}
	
	if($_SESSION["market3w_user"]!="")
	{
		$res = $client->get_currentuser();
                $currentuser = $res[0];
		$currentuser_id = $currentuser->user_id;
		$currentuser_role_id = $currentuser->user_role->role_id;
	}
	 
