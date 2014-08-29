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

                default : 								   
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;								 
            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
}