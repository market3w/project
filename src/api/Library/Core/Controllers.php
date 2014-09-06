<?php
/**
 * La classe Library_Core_Controllers permet de formatter les données retournées
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Library_Core_Controllers{
    
    /**
     * Stocke la table associée à un controller
     * @var object
     */
    protected $table;
    /**
     * Stocke le format des données retournées
     * @var object
     */
    private $apiResult;
	
    /**
     * Formatte et Retourne les données structurées
     * @param array|object $result
     * @param boolean $error                default value : false
     * @param string $errorMessage          default value : ""
     * @param boolean $errorServer          default value : false
     * @param string $errorServerMessage    default value : ""
     * @return object
     */
    public function setApiResult($result, $error=false, $errorMessage="", $errorServer=false, $errorServerMessage=""){
        $this->apiResult                    	 = new stdClass();
        $this->apiResult->response          	 = $result;
        $this->apiResult->apiError          	 = $error;
        $this->apiResult->apiErrorMessage    	 = $errorMessage;
        $this->apiResult->serverError            = $errorServer;
        $this->apiResult->serverErrorMessage     = $errorServerMessage;
        return $this->apiResult;
    }
	
    /**
     * Retourne la table associée au controller
     * @return object
     */
    public function get_table(){
        return $this->table;
    }
	
    /**
     * Retourne les informations du fichier sous forme de tableau ou null
     * @return array|null
     */
    public function get_file($file){
        return (empty($file))?null:unserialize($file);
    }
	
    /**
     * Envoi le mail
     * @return boolean
     */
    public function send_mail($name, $firstname, $email, $subject, $message_form, $email_dest){
        $name = htmlentities($name, ENT_NOQUOTES, "UTF-8");
        $firstname = htmlentities($firstname, ENT_NOQUOTES, "UTF-8");
        $email = htmlentities($email, ENT_NOQUOTES, "UTF-8");
        $subject= '=?utf-8?B?'.base64_encode($subject).'?=';
        $message_form = htmlentities($message_form, ENT_NOQUOTES, "UTF-8");

        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email_dest)) // On filtre les serveurs qui rencontrent des bogues.
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }
        //=====Déclaration des messages au format texte et au format HTML.
        $message_txt = $message_form;
        $message_html = $message_form;
        //==========

        //=====Création de la boundary
        $boundary = "-----=".md5(rand());
        //==========

        //=====Création du header de l'e-mail.
        $header = "From: \"".$name." ".$firstname."\"<".$email.">".$passage_ligne;
        $header.= "Reply-to: \"".$name." ".$firstname."\" <".$email.">".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        //==========

        //=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //==========

        //=====Envoi de l'e-mail.
        return mail($email_dest,$subject,$message,$header);
        //==========
    }
}