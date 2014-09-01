<?php
class Client_Core_Controllers{
	private $response;
	private $error;
	private $errorType;
	private $errorMessage;
	
	public function parseQueryResult($result){
            $_SESSION["market3w_api_token"]=$result->response[count($result->response)-1]->token;
            unset($result->response[count($result->response)-1]);
		$this->response = $result->response;
		$this->error = ($result->apiError==true || $result->serverError==true)? true:false;
		$this->errorType = ($this->error==true)? (($result->apiError==true)? "API ERROR" : "SERVER ERROR"): "";
		$this->errorMessage = ($this->error==true)? (($result->apiError==true)? $result->apiErrorMessage : $result->serverErrorMessage): "";
	}
	
	public function getResponse(){
		return ($this->response===false)? "":$this->response;
	}
	
	public function getError(){
		return ($this->error===false)? false:array("errorType"=>$this->errorType,"errorMessage"=>$this->errorMessage);
	}
}