<?php
/**
 * La classe Library_Core_RestServer est le premier controlleur appelé
 * Celui-ci lance le service et exécute les différentes méthodes du webservice
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Library_Core_RestServer{
    /**
     * Contient le service à appeler
     * @var object
     */
    private $service;
    /**
     * Type de methode 
     * valeurs possibles : GET, POST, PUT, DELETE
     * @var string
     */
    private $httpMethod;
    /**
     * Nom de la méthode à appeler dans le service 
     * Elle sera préfixer $httpMethod en minuscules et "_"
     * @var string
     */
    private $classMethod;
    /**
     * Liste des paramètres fournis à la méthode du service
     * @var array
     */
    private $requestParam;
    /**
     * Contient le User Agent du client
     * @var string
     */
    private $clientUserAgent;
    /**
     * Contient le Http Accept du client
     * @var string
     */
    private $clientHttpAccept;
    /**
     * Contient la réponse à afficher au format json
     * @var object
     */
    private $json;
    
    /**
     * Méthode magique __construct()
     * Formatte le type de retour
     * Initialise la réponse
     * Exécute la méthode du service
     * @param string $service Contient le nom du service à appeler
     * @param boolean $json Défini si le type de retour est json (true) ou html (false)
     */
    public function __construct($service,$json){
        if($json===true){
            header('Content-type: application/json');
        }
        $this->json                     = new stdClass();
        $this->json->response           = "";
        $this->json->apiError           = false;
        $this->json->apiErrorMessage    = "";
        $this->json->serverError        = false;
        $this->json->serverErrorMessage = "";
        
        $this->httpMethod               = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->clientUserAgent          = $_SERVER['HTTP_USER_AGENT'];
        $this->clientHttpAccept         = $_SERVER['HTTP_ACCEPT'];
        
        if(class_exists($service)){
            $this->service = new $service;
        } else {
            $this->showErrorServer("Server Error, Ressource not Found");
        }
        
        $D = array();
        switch ($this->httpMethod){
            case 'GET'      : $D=$_GET; break;
            case 'POST'     : 
            case 'PUT'      : 
            case 'DELETE'   : parse_str(file_get_contents("php://input"),$D); break;
            default         : $this->showErrorServer("Server Error, HTTP Method not Found"); break;
        }
		
        if(isset($D["method"])){
            $this->setClassMethod($D["method"]);
            unset($D["method"]);
            $this->requestParam = $D;
        } else {
            $this->showErrorServer("Server Error, Method not Found");
        }
    }
    
    /**
     * Méthode magique __destruct()
     * Affiche le contenu de la variable de classe $json formattée
     */
    public function __destruct() {
        echo json_encode($this->json, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    }
    
    /**
     * Exécute la méthode du service
     * Stocke la réponse dans la variable de classe $json
     */
    public function handle(){
        if(array_key_exists("session_token",$this->requestParam)){
            $token = $this->requestParam["session_token"];
            unset($this->requestParam["session_token"]);
        } else {
            $token = null;
        }
        call_user_func(array($this->service, 'init_session'),  $token);
        $res = call_user_func(array($this->service, $this->classMethod),  $this->requestParam);
        $nbRes = count($res->response);
        $response = array();
        if(is_array($res->response) && array_key_exists($nbRes-1, $res->response)){
            $response = $res->response;
            $index = (is_null($res->response[$nbRes-1]))?($nbRes-1):$nbRes;
        } else {
            $response[0] = $res->response;
            $index = 1;
        }
        if($index==1){
            if(array_key_exists(0, $response)){
                $temp = $response[0];
                unset($response[0]);
            } else {
                $temp = $response;
            }
            if(is_array($temp)){
                $response[0] = (array_key_exists(0, $temp))?$temp[0]:$temp;
            } else {
                $response[0]= $temp;
            }
        }
        $response[$index]["token"]=$_SESSION["token"];
        $this->json->response              = $response;
        $this->json->apiError              = $res->apiError;
        $this->json->apiErrorMessage       = $res->apiErrorMessage;
        $this->json->serverError           = $res->serverError;
        $this->json->serverErrorMessage    = $res->serverErrorMessage;
        exit;
    }
    
    /**
     * Formatte et stocke le nom de la méthode
     * @param string $methodName
     */
    private function setClassMethod($methodName){
        $this->classMethod = strtolower("{$this->httpMethod}_$methodName");
    }
    
    /**
     * Met le statut serverError à true
     * Stocke le message d'erreur
     * @param string $message
     */
    private function showErrorServer($message){
        $this->json->serverError        = true;
        $this->json->serverErrorMessage = $message;
        exit;
    }
}