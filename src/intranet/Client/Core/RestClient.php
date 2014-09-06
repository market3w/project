<?php
/**
 * La classe Client_Core_RestClient permet d'intéragir avec le webservice
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Client_Core_RestClient{
    /**
     * Nom du User Agent
     * @var string
     */
    private $userAgent;
    /**
     * URL du webservice
     * @var string
     */
    private $requestUrl;
    /**
     * Requête à soumettre au webservice
     * @var string
     */
    private $requestBody;
    /**
     * Résultat de la requête
     * @var object
     */
    private $responseBody;
    /**
     * Informations sur l'exécution de la requête
     * @var object 
     */
    private $responseHeader;
    
    /**
     * Méthode magique __construct
     * Initialise la session et les variables de la classe
     * Vérifie la validation de l'URL du webservice
     * @param string $serverUrl
     * @throws Exception
     */
    public function __construct($serverUrl) {
        if(!isset ($_SESSION)){
            session_start();
            session_regenerate_id();
        }
        if(!filter_var($serverUrl,FILTER_VALIDATE_URL)){
            throw new Exception("Error Server URL Request invalid");
        }
        
        $this->userAgent      = "RestClient V1";
        $this->requestUrl     = $serverUrl;
        $this->requestBody    = null;
        $this->responseBody   = null;
        $this->responseHeader = null;
    }
    
    /**
     * Initialise la requête curl
     * Exécute la méthode qui va effectuer la requête
     * @param string $httpMethod
     * @param null|string $request
     * @return object
     * @throws Exception
     */
    public function query($httpMethod='GET', $request=null){
        $this->responseBody   = null;
        $this->responseHeader = null;
        
        if(is_null($request)){
            throw new Exception("Erreur Client Request invalid");
        }
        $token = (array_key_exists("market3w_api_token",$_SESSION))?$_SESSION["market3w_api_token"]:null;
        $this->requestBody = $request."&session_token=".$token;
        
        $ch = curl_init($this->requestUrl);
        
        $httpMethod = strtolower($httpMethod);
        
        switch ($httpMethod){
            case 'get'      : $this->methodGet($ch); break;
            case 'post'     : $this->methodPost($ch); break;
            case 'put'      : $this->methodPut($ch); break;
            case 'delete'   : $this->methodDelete($ch); break; 
            default         : throw new Exception("HTTP method not found"); break;
        }
        
        return $this->responseBody;
    }
    
    /**
     * Modifie le User Agent
     * @param string $value
     */
    public function setUserAgent($value){
        if(!empty ($value)){
            $this->userAgent = $value;
        }
    }

    /**
     * Exécute la requête curl
     * Stocke la réponse
     * @param object $ch
     */
    private function doExecute(&$ch){
        $strCookie = session_name()."=".session_id();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: Application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $strCookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $strCookie);
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        
        $this->responseBody = curl_exec($ch);
        $this->responseHeader = curl_getinfo($ch);
    }

    /**
     * Prépare une requête de type GET 
     * @param object $ch
     */
    private function methodGet(&$ch){
        curl_setopt($ch, CURLOPT_URL, $this->requestUrl."?".$this->requestBody);
        $this->doExecute($ch);
    }
    
    /**
     * Prépare une requête de type POST 
     * @param object $ch
     */
    private function methodPost(&$ch){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
        curl_setopt($ch, CURLOPT_POST, true);
        $this->doExecute($ch);
    }
    
    /**
     * Prépare une requête de type PUT 
     * @param object $ch
     */
    private function methodPut(&$ch){
        $f = fopen('php://temp', 'rw');
        fwrite($f, $this->requestBody);
        rewind($f);
        
        curl_setopt($ch, CURLOPT_INFILE, $f);
        curl_setopt($ch, CURLOPT_INFILESIZE, strlen($this->requestBody));
        curl_setopt($ch, CURLOPT_PUT, true);
        $this->doExecute($ch);
        fclose($f);
    }
    
    /**
     * Prépare une requête de type DELETE 
     * @param object $ch
     */
    private function methodDelete(&$ch){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->doExecute($ch);
    }
}