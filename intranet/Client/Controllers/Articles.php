<?php
class Client_Controllers_Articles extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_allvideo($data=""){
		
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=allvideo")));
		$error = $this->getError();
		if($error===false){
			$videos = $this->getResponse();
			return $videos;
		}
		
		
	}
	
	public function get_allpdf($data=""){
		
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=allpdf")));
		$error = $this->getError();
		if($error===false){
			$pdf = $this->getResponse();
			return $pdf;
		}
		
		
	}
	
	public function get_article($data){
		$id_article = (isset($data["id"]) && is_numeric($data["id"]))? $data["id"]:null;
		
		
		/* Recupérer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=article&article_id=".$id_article)));
		$error = $this->getError();
		if($error===false){
			$article = $this->getResponse();
			return $article[0];
		}
				
		return array();
	}
	
	public function post_article($data){
		$article_name = (empty ($data['article_name']))?null:$data['article_name'];
		$article_courte_description = (empty ($data['article_courte_description']))?null:$data['article_courte_description'];
		$article_description = (empty ($data['article_description']))?null:$data['article_description'];
		$type = (empty ($data['type']))?null:$data['type'];
		
		if($type==1)
		{
			$document_file = $this->set_file();
		}
		elseif($type==2)
		{
			$article_link = (empty ($data['article_link']))?null:$data['article_link'];
		}
		
		$temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=article&article_name=".$article_name."&article_courte_description=".$article_courte_description."&article_description=".$article_description."&type=".$type.(($type==1) ? "&document=".$document_file : "").(($type==2) ? "&article_link=".$article_link : ""))));
		
		$error = $this->getError();
		if($error===false){
			$response = $this->getResponse();
		
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
				
				case "You are not logged" :  $_SESSION["errorMessage"] = "Vous devez être connecté";
				   											break;
				
			
				case "param 'article_name' undefined" :   		$_SESSION["errorMessage"] = "Veuillez renseigner le nom de l'article";
														   break;
														   
				case "param 'article_courte_description' undefined" :  $_SESSION["errorMessage"] = "Veuillez renseigner une courte description de votre article";
														   break;
														 
				case "param 'article_description' undefined" :  $_SESSION["errorMessage"] = "Veuillez renseigner une description";
				   											break;
				
				case "param 'type' undefined" :  $_SESSION["errorMessage"] = "Type de l'article non trouvé";
				   											break;
															
				case "param 'article_link' undefined" :  $_SESSION["errorMessage"] = "Lien de la vidéo manquant";
				   											break;
						
				case "Not authorized" :  $_SESSION["errorMessage"] = "Vous n'êtes pas authorisé à voir ce contenu";
				   											break;
														 
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
	
	public function put_article($data){
		$article_id = (empty ($data['article_id']))?null:$data['article_id'];
		$article_name = (empty ($data['article_name']))?null:$data['article_name'];
		$article_courte_description = (empty ($data['article_courte_description']))?null:$data['article_courte_description'];
		$article_description = (empty ($data['article_description']))?null:$data['article_description'];
		$type = (empty ($data['type']))?null:$data['type'];
		
		if($type=='videos')
		{
			$article_link = (empty ($data['article_link']))?null:$data['article_link'];
		}
		
		$temp = $this->parseQueryResult(json_decode($this->_client->query("PUT","method=article&article_id=".$article_id."&article_name=".$article_name."&article_courte_description=".$article_courte_description."&article_description=".$article_description."&type=".$type.(($type=='videos') ? "&article_link=".$article_link : ""))));
		
		$error = $this->getError();
		if($error===false){
			$response = $this->getResponse();
		
		} elseif($error["errorType"]=="API ERROR") {
			switch($error["errorMessage"]){
				
				case "You are not logged" :  $_SESSION["errorMessage"] = "Vous devez être connecté";
				   											break;
				
				case "param 'article_id' undefined" :
				case "param 'article_id' is not numeric" :	   $_SESSION["errorMessage"] = "Votre requête ne peut aboutir, il y a un problème avec la reconnaissance de votre article_id";
														   break;
														 
				case "param 'article_name' undefined" :   		$_SESSION["errorMessage"] = "Veuillez renseigner le nom de l'article";
														   break;
														   
				case "param 'article_courte_description' undefined" :  $_SESSION["errorMessage"] = "Veuillez renseigner une courte description de votre article";
														   break;
														 
				case "param 'article_description' undefined" :  $_SESSION["errorMessage"] = "Veuillez renseigner une description";
				   											break;
				
				case "param 'type' undefined" :  $_SESSION["errorMessage"] = "Type de l'article non trouvé";
				   											break;
															
				case "param 'article_link' undefined" :  $_SESSION["errorMessage"] = "Lien de la vidéo manquant";
				   											break;
						
				case "Not authorized" :  $_SESSION["errorMessage"] = "Vous n'êtes pas authorisé à voir ce contenu";
				   											break;
														 
				default : 								   $_SESSION["errorMessage"] = "Erreur de saisie";
														   break;
										 
			}
		} elseif($error["errorType"]=="SERVER ERROR") {
			$_SESSION["errorServer"]=$error["errorMessage"];
		}
	}
	
	
}