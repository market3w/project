<?php
class Client_Controllers_Documents extends Client_Core_Controllers{
    private $_client;

    public function __construct($_client){
        $this->_client = $_client;
    }

    public function get_alldocument($data=array()){
	$user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if(is_null($user_id)){
            $this->parseQueryResult(json_decode($this->_client->query("GET","method=alldocument")));
        } else {
            $this->parseQueryResult(json_decode($this->_client->query("GET","method=alldocument_user&user_id=".$user_id)));
        }
        $error = $this->getError();
        if($error===false){
            $documents = $this->getResponse();
            return $documents;
        }
    }

    public function post_document($data){
        $document_name = (empty ($data['document_name']))?null:$data['document_name'];
        $document_description = (empty ($data['document_description']))?null:$data['document_description'];
        $document_file = $this->set_file('document');

        $temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=document&document_name=".$document_name."&document_description=".$document_description."&document_file=".$document_file)));

        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();

        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "you are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'etes pas connecté";
                        break;

                case "param 'user_id' undefined" : 
                case "param 'user_id' is not numeric" : 
                        $_SESSION["errorMessage"] = "Votre identifiant n'a pas été trouvé";
                        break;

                case "param 'document_name' undefined" :         
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre le nom du document";
                        break;

                case "param 'document_description' undefined" :     
                        $_SESSION["errorMessage"] = "Veuillez renseigner la description du document";
                        break;

                case "bad extension" :   
                        $_SESSION["errorMessage"] = "Vous avez téléchargez un fichier avec une mauvaise extension (extensions autorisées : gif, jpeg, png)";
                        break;	

                case "document too big" :   
                        $_SESSION["errorMessage"] = "Vous avez téléchargez un fichier trop lourd";
                        break;	

                case "download fail" :   
                        $_SESSION["errorMessage"] = "Une erreur s'est produite durant le téléchargement";
                        break;
				
				case "file already exist" :   
                        $_SESSION["errorMessage"] = "Le fichier que vous voulez télécharger existe déjà, veuillez supprimer le fichier avec le même nom ou renommer votre fichier";
                        break;										   									   

                default : 								   
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;								 
            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
	
	 public function delete_document($data){
        $document_id = (empty ($data['document_id']))?null:$data['document_id'];
 		$document_file_name = (empty ($data['document_file_name']))?null:$data['document_file_name'];

        $temp = $this->parseQueryResult(json_decode($this->_client->query("POST","method=document&document_id=".$document_id."&document_file_name=".$document_file_name)));
 		var_dump($this->getResponse());
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();

        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "you are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'etes pas connecté";
                        break;

                case "param 'document_id' undefined" : 
                case "param 'document_id' is not numeric" : 
                        $_SESSION["errorMessage"] = "L' identifiant du document est incorrect";
                        break;

                case "document doesn't look existt" :         
                        $_SESSION["errorMessage"] = "Le document n'a pas été trouvé dans les bases de données";
                        break;

                case "param 'document_file_name' undefined" :     
                        $_SESSION["errorMessage"] = "Le lien du document à supprimer n'est pas défini";
                        break;

                case "bad extension" :   
                        $_SESSION["errorMessage"] = "Vous avez téléchargez un fichier avec une mauvaise extension (extensions autorisées : gif, jpeg, png)";
                        break;	

                case "document too big" :   
                        $_SESSION["errorMessage"] = "Vous avez téléchargez un fichier trop lourd";
                        break;	

                case "download fail" :   
                        $_SESSION["errorMessage"] = "Une erreur s'est produite durant le téléchargement";
                        break;
				
				case "file already exist" :   
                        $_SESSION["errorMessage"] = "Le fichier que vous voulez télécharger existe déjà, veuillez supprimer le fichier avec le même nom ou renommer votre fichier";
                        break;										   									   

                default : 								   
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;								 
            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
}