<?php
class Library_Core_Controllers{
	
    private $apiResult;
	
	public function setApiResult($result, $error=false, $errorMessage=""){
        $this->apiResult                     = new stdClass();
        $this->apiResult->response           = $result;
        $this->apiResult->apiError           = $error;
        $this->apiResult->apiErrorMessage    = $errorMessage;
        return $this->apiResult;
    }
}