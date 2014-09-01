<?php
class Client_Controllers_Companies extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	 public function put_company($data){
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
        $company_siret = (empty ($data['company_siret']))?null:$data['company_siret'];
        $company_siren = (empty ($data['company_siren']))?null:$data['company_siren'];
        $company_name = (empty ($data['company_name']))?null:$data['company_name'];
        $company_adress = (empty ($data['company_adress']))?null:$data['company_adress'];
        $company_adress2 = (empty ($data['company_adress2']))?null:$data['company_adress2'];
        $company_zipcode = (empty ($data['company_zipcode']))?null:$data['company_zipcode'];
        $company_town = (empty ($data['company_town']))?null:$data['company_town'];
        $company_nb_employees = (empty ($data['company_nb_employees']))?null:$data['company_nb_employees'];

        $this->parseQueryResult(json_decode($this->_client->query("PUT","method=company&company_id=".$company_id."&company_siret=".$company_siret."&company_siren=".$company_siren."&company_name=".$company_name."&company_adress=".$company_adress."&company_adress2=".$company_adress2."&company_zipcode=".$company_zipcode."&company_town=".$company_town."&company_nb_employees=".$company_nb_employees)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "param 'company_id' undefined" :
                case "param 'company_id' is not numeric" :	   
                        $_SESSION["errorMessage"] = "Votre requête ne peut aboutir, il y a un problème avec la reconnaissance de l'id de la cosiété";
                        break;

                case "param 'company_siret' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le siret de la société";
                        break;

                case "param 'company_siren' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le siren de la société";
                        break;

                case "param 'company_name' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner le nom de la société";
                        break;

                case "param 'company_adress' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner l'adresse de la société";
                        break;
				
				case "param 'company_zipcode' undefined" :
				case "param 'company_zipcode' unvalid" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner un code postal valide de la société";
                        break;
						
				case "param 'company_town' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner la ville de la société";
                        break;
						
                case "You can't update this user" :
                        $_SESSION["errorMessage"] = "Vous n'avez pas les droits pour modifier ce profil";
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