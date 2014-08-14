<?php
class Library_Core_Controllers{
	
    private $apiResult;
	
	public function setApiResult($result, $error=false, $errorMessage="", $errorServer=false, $errorServerMessage=""){
        $this->apiResult                    	 = new stdClass();
        $this->apiResult->response          	 = $result;
        $this->apiResult->apiError          	 = $error;
        $this->apiResult->apiErrorMessage    	 = $errorMessage;
        $this->apiResult->serverError            = $errorServer;
        $this->apiResult->serverErrorMessage     = $errorServerMessage;
        return $this->apiResult;
    }
}