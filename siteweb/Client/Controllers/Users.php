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
			header("location: ../intranet/index.php");
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
	
	public function post_user($data){
		$user_name = (empty ($data['user_name']))?null:$data['user_name'];
		$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
		$user_email = (empty ($data['user_email']))?null:$data['user_email'];
		$user_password = (empty ($data['user_password']))?null:$data['user_password'];
		$user_function = (empty ($data['user_function']))?null:$data['user_function'];
		$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
		$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
		$user_adress = (empty ($data['user_adress']))?null:$data['user_adress'];
		$user_adress2 = (empty ($data['user_adress2']))?null:$data['user_adress2'];
		$user_zipcode = (empty ($data['user_zipcode']))?null:$data['user_zipcode'];
		$user_town = (empty ($data['user_town']))?null:$data['user_town'];
		
		$temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=user&user_name=".$user_name."&user_firstname=".$user_firstname."&user_email=".$user_email."&user_password=".$user_password."&user_function=".$user_function."&user_phone=".$user_phone."&user_mobile=".$user_mobile."&user_adress=".$user_adress."&user_adress2=".$user_adress2."&user_zipcode=".$user_zipcode."&user_town=".$user_town)));
		$error = $this->getError();
		if($error===false){
			$response = $this->getResponse();
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
												 
				case "param 'user_name' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre nom";
														   break;
														 										 
				case "param 'user_firstname' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre prénom";
														   break;
														 										 
				case "param 'user_email' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 										 
				case "param 'user_password' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre mot de passe";
														   break;
														   
				case "Enter 2 same passwords" :      		$_SESSION["errorMessage"] = "Vous n'avez pas indiqué le meme mot de passe ";
														   break;
														   								 
				case "param 'user_function' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre profession";
														   break;
														 										 
				case "param 'user_phone' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 										 
				case "param 'user_mobile' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 										 
				case "param 'user_adress' undefined" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 										 
				case "param 'user_zipcode' undefined" :
				case "param 'user_zipcode' unvalid" :      $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
														   break;
														 
				case "param 'user_town' undefined" :   $_SESSION["errorMessage"] = "Veuillez renseigner votre ville";
														   break;
														 
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
}