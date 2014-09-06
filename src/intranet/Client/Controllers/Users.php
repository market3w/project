<?php
/**
 * La classe Client_Controllers_Users permet d'appeler les méthodes du webservice liées aux utilisateurs et de traiter ces informations
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Client_Controllers_Users extends Client_Core_Controllers{
    /**
     * Client du webservice
     * @var object
     */
    private $_client;

    /**
     * Stocke le client du webservice
     * @param object $_client
     */
    public function __construct($_client){
        $this->_client = $_client;
    }
	
    /**
     * Connexion
     * Exécute la méthode post_login du webservice
     * Stocke le prenom et le nom dans une variable de session
     * @param array $data
     */
    public function login($data){
        $user_email = ($data["login"]!="")? $data["login"]:null;
        $user_password = ($data["password"]!="")? $data["password"]:null;

        $this->parseQueryResult(json_decode($this->_client->query("POST","method=login&user_email=".$user_email."&user_password=".$user_password)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();
            $_SESSION["market3w_user"] = trim($response[0]->user_firstname." ".$response[0]->user_name);
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "Login incorrect" :
                        $_SESSION["errorMessage"] = "Email et/ou mot de passe incorrecte";
                        break;

                case "param 'user_email' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
                        break;

                case "param 'user_password' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre mot de passe";
                        break;

                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;

            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
	
    public function logout($data){
        $this->parseQueryResult(json_decode($this->_client->query("POST","method=logout")));
        $error = $this->getError();
        if($error===false){
            $_SESSION["market3w_user"] = "";
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "Login incorrect" :
                        $_SESSION["errorMessage"] = "Email et/ou mot de passe incorrecte";
                        break;

                case "param 'user_email' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
                        break;

                case "param 'user_password' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre mot de passe";
                        break;

                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;					 
            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
	
    public function get_all_users($data=""){
        $users = array("clients"=>array(),"prospects"=>array(),"visiteurs"=>array());
        /* Recupérer les visiteurs */
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbyrole&role_id=6")));
        $error = $this->getError();
        if($error===false){
            $users["visiteurs"] = $this->getResponse();
        }
        /* Recupérer les prospects */
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbyrole&role_id=5")));
        $error = $this->getError();
        if($error===false){
            $users["prospects"] = $this->getResponse();
        }
        /* Recupérer les clients */
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbyrole&role_id=4")));
        $error = $this->getError();
        if($error===false){
            $users["clients"] = $this->getResponse();
        }
        return $users;
    }
	
    public function get_currentuser($data=""){
        /* Recupérer les pdf */
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=currentuser")));
        $error = $this->getError();
        if($error===false){
            $user = $this->getResponse();
            return $user;
        }		
        return array();
    }
	
    public function get_user($data){
        /* Recupérer les pdf */
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=user&user_id=".$user_id)));
        $error = $this->getError();
        if($error===false){
            $user = $this->getResponse();
            return $user[0];
        }		
        return array();
    }
    
    public function get_alluserbywebmarketter($data="") {
        /* Recupérer les pdf */
        $webmarketter_id = (empty ($data['webmarketter_id']))?null:$data['webmarketter_id'];
        $webmarketter = (is_null($webmarketter_id))?"":"&webmarketter_id=".$webmarketter_id;
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=alluserbywebmarketter".$webmarketter)));
        $error = $this->getError();
        if($error===false){
            return $this->getResponse();
        }		
        return array();
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

        $this->parseQueryResult(json_decode($this->_client->query("PUT","method=user&user_id=".$user_id."&user_name=".$user_name."&user_firstname=".$user_firstname."&user_email=".$user_email."&user_function=".$user_function."&user_phone=".$user_phone."&user_mobile=".$user_mobile."&user_adress=".$user_adress."&user_adress2=".$user_adress2."&user_zipcode=".$user_zipcode."&user_town=".$user_town."&company_id=".$company_id)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "param 'user_id' undefined" :
                case "param 'user_id' is not numeric" :	   
                        $_SESSION["errorMessage"] = "Votre requête ne peut aboutir, il y a un problème avec la reconnaissance de votre identité";
                        break;

                case "param 'user_name' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre nom";
                        break;

                case "param 'user_firstname' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre prénom";
                        break;

                case "param 'user_email' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
                        break;

                case "User not found" :
                        $_SESSION["errorMessage"] = "Utilisateur non trouvé";
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
	
    public function put_password($data){
        $user_password = (empty ($data['user_password']))?null:$data['user_password'];
        $user_password2 = (empty ($data['user_password2']))?null:$data['user_password2'];
        $user_email = (empty ($data['user_email']))?null:$data['user_email'];

        $this->parseQueryResult(json_decode($this->_client->query("PUT","method=password&user_password=".$user_password."&user_password2=".$user_password2."&user_email=".$user_email)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();

        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "you are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'êtes pas connecté";
                        break;

                case "param 'user_id' undefined" : 
                case "param 'user_id' is not numeric" : 
                        $_SESSION["errorMessage"] = "Votre identifiant n'a pas été trouvé";
                        break;

                case "param 'user_password' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre mot de passe";
                        break;

                case "param 'user_password2' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez confirmer votre mot de passe";
                        break;

                case "param 'user_email' undefined" :
                        $_SESSION["errorMessage"] = "Adresse mail manquante";
                        break;										   

                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;				 
            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
	
    public function contact($data){
        $user_name = (empty ($data['user_name']))?null:$data['user_name'];
        $user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
        $user_email = (empty ($data['user_email']))?null:$data['user_email'];
        $objet = (empty ($data['objet']))?null:$data['objet'];
        $message_form = (empty ($data['message']))?null:$data['message'];

        $this->parseQueryResult(json_decode($this->_client->query("POST","method=contact&user_name=".$user_name."&user_firstname=".$user_firstname."&user_email=".$user_email."&objet=".$objet."&message=".$message_form)));
        $error = $this->getError();
        if($error===false){
            $response = $this->getResponse();
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "param 'user_email' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre email";
                        break;

                case "param 'user_name' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre nom";
                        break;

                case "param 'user_firstname' undefined" :
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre prénom";
                        break;

                case "param 'objet' undefined" :   
                        $_SESSION["errorMessage"] = "Veuillez renseigner l'objet de votre message";
                        break;

                case "param 'message' undefined" :   
                        $_SESSION["errorMessage"] = "Veuillez renseigner votre message";
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