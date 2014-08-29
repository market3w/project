<?php
class Client_Core_Client extends Client_Core_Extensions{
	private $_client;
	
	public function __construct(){
		$this->_client = new Client_Core_RestClient(SERVER_ROOT);
		
		// Ajout des controllers
		$extensions = array ('Client_Controllers_Users',
							 'Client_Controllers_Roles',
							 'Client_Controllers_Campains',
							 'Client_Controllers_Paiements',
							 'Client_Controllers_Documents',
							 'Client_Controllers_Articles');
		
		parent::__construct($extensions,$this->_client);
	}
}