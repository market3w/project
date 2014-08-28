<?php
class Client_Controllers_Documents extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_alldocument($data=""){
	 
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=alldocument_user")));
		$error = $this->getError();
		if($error===false){
			$documents = $this->getResponse();
			return $documents;
			
		}
	}
	
	public function put_user($data){
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
		$user_name = (empty ($data['user_name']))?null:$data['user_name'];
		$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
		$user_email = (empty ($data['user_email']))?null:$data['user_email'];
		$user_function = (empty ($data['user_function']))?null:$data['user_function'];
		$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
		$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
		$user_adress = (empty ($data['user_adress']))?null:$data['user_adress'];
		$user_adress2 = (empty ($data['user_adress2']))?null:$data['user_adress2'];
		$user_zipcode = (empty ($data['user_zipcode']))?null:$data['user_zipcode'];
		$user_town = (empty ($data['user_town']))?null:$data['user_town'];
		$company_id = (empty ($data['company_id']))?null:$data['company_id'];
		
		$temp = $this->parseQueryResult(json_decode($this->_client->query("PUT","method=user&user_id=".$user_id."&user_name=".$user_name."&user_firstname=".$user_firstname."&user_email=".$user_email."&user_function=".$user_function."&user_phone=".$user_phone."&user_mobile=".$user_mobile."&user_adress=".$user_adress."&user_adress2=".$user_adress2."&user_zipcode=".$user_zipcode."&user_town=".$user_town."&company_id=".$company_id)));
		$error = $this->getError();
		if($error===false){
			$response = $this->getResponse();
		
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
				case "param 'user_id' undefined" :
				case "param 'user_id' is not numeric" :	   $_SESSION["errorMessage"] = "Votre requete ne peut aboutir, il y a un probleme avec la reconnaissance de votre identité";
														   break;
														 
				case "param 'user_name' undefined" :   		$_SESSION["errorMessage"] = "Veuillez renseigner votre nom";
														   break;
														   
				case "param 'user_firstname' undefined" :  $_SESSION["errorMessage"] = "Veuillez renseigner votre prénom";
														   break;
														 
				case "param 'user_email' undefined" :  $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
				   											break;
											
				case "User not found" :  $_SESSION["errorMessage"] = "Utilisateur non trouvé";
				   											break;
															
				case "You can't update this user" :  $_SESSION["errorMessage"] = "Vous n'avez pas les droits pour modifier ce profil";
				   											break;
														 
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
	
	public function post_document($data){
		$document_name = (empty ($data['document_name']))?null:$data['document_name'];
		$document_description = (empty ($data['document_description']))?null:$data['document_description'];
		$document_file = $this->set_file();
		
		$temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=document&document_name=".$document_name."&document_description=".$document_description."&document_file=".$document_file)));
		$error = $this->getError();
		if($error===false){
			$response = $this->getResponse();
			
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
				
				case "you are not logged" :					$_SESSION["errorMessage"] = "Vous n'etes pas connecté";
														   break;
				
				case "param 'user_id' undefined" : 
				case "param 'user_id' is not numeric" : 
				     										$_SESSION["errorMessage"] = "Votre identifiant n'a pas été trouvé";
														   break;
														   				 
				case "param 'document_name' undefined" :   $_SESSION["errorMessage"] = "Veuillez renseigner votre le nom du document";
														   break;
				
				case "param 'document_description' undefined" :   $_SESSION["errorMessage"] = "Veuillez renseigner la description du document";
														   break;
														   

				case "bad extension" :   $_SESSION["errorMessage"] = "Vous avez téléchargez un fichier avec une mauvaise extension (extensions autorisées : gif, jpeg, png)";
														   break;	
														   									   
				case "document too big" :   $_SESSION["errorMessage"] = "Vous avez téléchargez un fichier trop lourd";
														   break;	
														   									   
				case "download fail" :   $_SESSION["errorMessage"] = "Une erreur s'est produite durant le téléchargement";
														   break;										   
			
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
	
	
	
}