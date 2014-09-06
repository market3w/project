<?php
class Client_Controllers_Campains extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_allcampain($data=array()){
	 
		/* Recup�rer les vid�os */
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
                if(is_null($user_id)){
                    $this->parseQueryResult(json_decode($this->_client->query("GET","method=allcampain")));
                } else {
                    $this->parseQueryResult(json_decode($this->_client->query("GET","method=allcampain&user_id=".$user_id)));
                }
		$error = $this->getError();
		if($error===false){
			$campains = $this->getResponse();
			return $campains;
		}
	}
	
	public function get_campain($data){
		 $campain_id = (isset($data["campain_id"]) && is_numeric($data["campain_id"]))? $data["campain_id"]:null;
	
		/* Recup�rer les vid�os */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=campain&campain_id=".$campain_id)));
		$error = $this->getError();
		//var_dump($this->getResponse());
		if($error===false){
			$campain = $this->getResponse();
			return $campain;
		}
	}
	
	public function put_campain($data){
        $campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
		$campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
		$campain_courte_description = (empty ($data['campain_courte_description']))?null:$data['campain_courte_description'];
		$campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
		$campain_completion = (empty ($data['campain_completion']))?null:$data['campain_completion'];


        $this->parseQueryResult(json_decode($this->_client->query("PUT","method=campain&campain_id=".$campain_id."&campain_name=".$campain_name."&campain_description=".$campain_description."&campain_courte_description=".$campain_courte_description."&campain_completion=".$campain_completion)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "param 'campain_id' undefined" :
                case "param 'campain_id' is not numeric" :	   
                        $_SESSION["errorMessage"] = "Votre requête ne peut aboutir, il y a un problème avec la reconnaissance de l'id de la campagne";
                        break;

                case "param 'campain_name' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le nom de la campagne";
                        break;

                case "param 'campain_description' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner la description de la campagne";
                        break;
						
				 case "param 'campain_courte_description' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner la courte description de la campagne";
                        break;

                case "param 'campain_completion' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le complément d'informations";
                        break;

                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;				 
            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
	public function post_campain($data){
		 $user_id = (empty ($data['user_id']))?null:$data['user_id'];
       $campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
		$campain_courte_description = (empty ($data['campain_courte_description']))?null:$data['campain_courte_description'];
		$campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
		$campain_completion = (empty ($data['campain_completion']))?null:$data['campain_completion'];


        $this->parseQueryResult(json_decode($this->_client->query("POST","method=campain&user_id=".$user_id."&campain_name=".$campain_name."&campain_description=".$campain_description."&campain_courte_description=".$campain_courte_description."&campain_completion=".$campain_completion)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "param 'user_id' undefined" :
                case "param 'user_id' is not numeric" :	   
                        $_SESSION["errorMessage"] = "Votre requête ne peut aboutir, il y a un problème avec la reconnaissance de l'id de l'utilisateur";
                        break;

                case "param 'campain_name' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le nom de la campagne";
                        break;

                case "param 'campain_description' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner la description de la campagne";
                        break;
						
				 case "param 'campain_courte_description' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner la courte description de la campagne";
                        break;

                case "param 'campain_completion' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le complément d'informations";
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