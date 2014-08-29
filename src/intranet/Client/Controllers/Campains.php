<?php
class Client_Controllers_Campains extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_allcampain($data=""){
	 
		/* Recupérer les vidéos */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=allcampain")));
		$error = $this->getError();
		if($error===false){
			$campains = $this->getResponse();
			return $campains;
		}
	}
	
	public function get_campain($data){
		 $campain_id = (isset($data["campain_id"]) && is_numeric($data["campain_id"]))? $data["campain_id"]:null;
	
		/* Recupérer les vidéos */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=campain&campain_id=".$campain_id)));
		$error = $this->getError();
		if($error===false){
			$campain = $this->getResponse();
			return $campain;
		}
	}
	
}