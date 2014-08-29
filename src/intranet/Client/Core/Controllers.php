<?php
class Client_Core_Controllers{
	private $response;
	private $error;
	private $errorType;
	private $errorMessage;
	
	public function parseQueryResult($result){
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