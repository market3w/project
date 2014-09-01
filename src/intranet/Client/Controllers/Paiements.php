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
	
	public function get_paiement($data){
	  $paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];
    
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=paiement&paiement_id=".$paiement_id)));
        $error = $this->getError();
        if($error===false){
            $paiement = $this->getResponse();
            return $paiement;
        }
    }
	
}