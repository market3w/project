<?php
class Library_Core_RestServer{
    private $service;
    private $httpMethod;
    private $classMethod;
    private $requestParam;
    private $clientUserAgent;
    private $clientHttpAccept;
    
    private $json;
    
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
    
    public function __destruct() {
        echo json_encode($this->json, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    }
    
    public function handle(){
        $res = call_user_func(array($this->service, $this->classMethod),  $this->requestParam);
        $this->json->response              = $res->response;
        $this->json->apiError              = $res->apiError;
        $this->json->apiErrorMessage       = $res->apiErrorMessage;
        $this->json->serverError           = $res->serverError;
        $this->json->serverErrorMessage    = $res->serverErrorMessage;
        exit;
    }
    
    private function setClassMethod($methodName){
        $this->classMethod = strtolower("{$this->httpMethod}_$methodName");
    }
    
    private function showErrorServer($message){
        $this->json->serverError        = true;
        $this->json->serverErrorMessage = $message;
        exit;
    }
}