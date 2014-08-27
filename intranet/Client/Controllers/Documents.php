<?php
class Client_Controllers_Documents extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_alldocument($data=""){
	 
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=alldocument_user")));
		$error = $this->getError();
		if($error===false){
			$documents = $this->getResponse();
			return $documents;
			
		}
	}
	
	
	
}