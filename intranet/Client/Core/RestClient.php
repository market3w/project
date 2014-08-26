<?php
class Client_Core_RestClient{
    
    private $userAgent;
    private $requestUrl;
    private $requestBody;
    private $responseBody;
    private $responseHeader;
    
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
    
    public function query($httpMethod='GET', $request=null){
        $this->responseBody   = null;
        $this->responseHeader = null;
        
        if(is_null($request)){
            throw new Exception("Erreur Client Request invalid");
        }
        $this->requestBody = $request;
        
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
    
    public function setUserAgent($value){
        if(!empty ($value)){
            $this->userAgent = $value;
        }
    }


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


    private function methodGet(&$ch){
        curl_setopt($ch, CURLOPT_URL, $this->requestUrl."?".$this->requestBody);
        $this->doExecute($ch);
    }
    
    private function methodPost(&$ch){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
        curl_setopt($ch, CURLOPT_POST, true);
        $this->doExecute($ch);
    }
    
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
    
    private function methodDelete(&$ch){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->doExecute($ch);
    }
}