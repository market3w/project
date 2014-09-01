<?php
class Client_Controllers_Paiements extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_allpaiement($data=""){
	 $user_id = (empty ($data['user_id']))?null:$data['user_id'];
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=allpaiement&user_id=".$user_id)));
		$error = $this->getError();
		if($error===false){
			$paiements = $this->getResponse();
			return $paiements;
			
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