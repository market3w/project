<?php
/**
 * La classe Client_Core_Controllers permet de traiter les données retournées
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Client_Core_Controllers{
    /**
     * Stocke la réponse
     * @var object
     */
    private $response;
    /**
     * Défini s'il y a eu une erreur
     * @var boolean
     */
    private $error;
    /**
     * Défini le type d'erreur
     * @var string
     */
    private $errorType;
    /**
     * Défini le message d'erreur
     * @var string
     */
    private $errorMessage;

    /**
     * Réparti les éléments retournés
     * @param object $result
     */
    public function parseQueryResult($result){
        //var_dump($result->response);
        $_SESSION["market3w_api_token"]=$result->response[count($result->response)-1]->token;
        unset($result->response[count($result->response)-1]);
        $this->response = $result->response;
        $this->error = ($result->apiError==true || $result->serverError==true)? true:false;
        $this->errorType = ($this->error==true)? (($result->apiError==true)? "API ERROR" : "SERVER ERROR"): "";
        $this->errorMessage = ($this->error==true)? (($result->apiError==true)? $result->apiErrorMessage : $result->serverErrorMessage): "";
    }

    /**
     * Retourne la réponse
     * @return object
     */
    public function getResponse(){
        return ($this->response===false)? "":$this->response;
    }

    /**
     * Retourne l'erreur
     * @return boolean|array
     */
    public function getError(){
        return ($this->error===false)? false:array("errorType"=>$this->errorType,"errorMessage"=>$this->errorMessage);
    }

    /**
     * Formatte le contenu de la variable $_FILES à envoyer au webservice 
     * Copie le fichier à uploader dans un dossier temporaire
     * @param string $field_name
     * @return null|string
     */
    public function set_file($field_name){
        if(!empty($_FILES)){
            $file = array_merge($_FILES,array("upload_root"=>UPLOAD_ROOT));
            $taille_maxi = 1000000;
            $taille = filesize($_FILES[$field_name]['tmp_name']);
            $temp = explode("/", $_FILES[$field_name]['tmp_name']);
            $tmp_name = $temp[(count($temp)-1)];
            $file[$field_name]['tmp_name'] = str_replace('upload', 'temp', UPLOAD_ROOT) . $tmp_name;
            if(count($temp)<=1){
                $temp = explode("\\", $_FILES[$field_name]['tmp_name']);
                $tmp_name = $temp[(count($temp)-1)];
                $file[$field_name]['tmp_name'] = str_replace('/','\\',str_replace('upload', 'temp', UPLOAD_ROOT) . $tmp_name);
            }
            move_uploaded_file($_FILES[$field_name]['tmp_name'], str_replace('upload', 'temp', UPLOAD_ROOT) . $tmp_name);
        }
        return (empty($_FILES))?null:serialize($file);
    }
}