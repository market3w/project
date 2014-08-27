<?php
class Client_Controllers_Users extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function login($data){
		$user_email = ($data["login"]!="")? $data["login"]:null;
		$user_password = ($data["password"]!="")? $data["password"]:null;
		
		$temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=login&user_email=".$user_email."&user_password=".$user_password)));
		$error = $this->getError();
		if($error===false){
			$response = $this->getResponse();
			$_SESSION["market3w_user"] = trim($response[0]->user_firstname." ".$response[0]->user_name);
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
				case "Login incorrect" : 				   $_SESSION["errorMessage"] = "Email et/ou mot de passe incorrecte";
														   break;
														 
				case "param 'user_email' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 
				case "param 'user_password' undefined" :   $_SESSION["errorMessage"] = "Veuillez renseigner votre mot de passe";
														   break;
														 
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
	
	public function logout($data){
		$temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=logout")));
		$error = $this->getError();
		if($error===false){
			$_SESSION["market3w_user"] = "";
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
				case "Login incorrect" : 				   $_SESSION["errorMessage"] = "Email et/ou mot de passe incorrecte";
														   break;
														 
				case "param 'user_email' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 
				case "param 'user_password' undefined" :   $_SESSION["errorMessage"] = "Veuillez renseigner votre mot de passe";
														   break;
														 
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
	
	public function get_all_users($data=""){
		$users = array("clients"=>array(),"prospects"=>array(),"visiteurs"=>array());
		/* Recup�rer les visiteurs */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbyrole&role_id=6")));
		$error = $this->getError();
		if($error===false){
			$users["visiteurs"] = $this->getResponse();
		}
		/* Recup�rer les prospects */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbyrole&role_id=5")));
		$error = $this->getError();
		if($error===false){
			$users["prospects"] = $this->getResponse();
		}
		/* Recup�rer les clients */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbyrole&role_id=4")));
		$error = $this->getError();
		if($error===false){
			$users["clients"] = $this->getResponse();
		}
		return $users;
	}
	
	public function get_currentuser($data=""){
		/* Recup�rer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=currentuser")));
		$error = $this->getError();
		if($error===false){
			$user = $this->getResponse();
			return $user;
		}
				
		return array();
	}
}