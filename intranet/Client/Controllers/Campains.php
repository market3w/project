<?php
class Client_Controllers_Campains extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_allcampain($data=array()){
	 
		/* Recup�rer les vid�os */
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
                if(is_null($user_id)){
                    $this->parseQueryResult(json_decode($this->_client->query("GET","method=allcampain")));
                } else {
                    $this->parseQueryResult(json_decode($this->_client->query("GET","method=allcampain&user_id=".$user_id)));
                }
		$error = $this->getError();
		if($error===false){
			$campains = $this->getResponse();
			return $campains;
		}
	}
	
	public function get_campain($data){
		 $campain_id = (isset($data["campain_id"]) && is_numeric($data["campain_id"]))? $data["campain_id"]:null;
	
		/* Recup�rer les vid�os */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=campain&campain_id=".$campain_id)));
		$error = $this->getError();
		//var_dump($this->getResponse());
		if($error===false){
			$campain = $this->getResponse();
			return $campain;
		}
	}
	
}