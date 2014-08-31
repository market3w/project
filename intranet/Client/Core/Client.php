<?php
/**
 * La classe Client_Core_Client permet de faire appel à toutes les méthodes du client du webservice
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Client_Core_Client extends Client_Core_Extensions{
    /**
     * Stocke le client du webservice
     * @var object
     */
    private $_client;

    /**
     * Méthode magique __construct()
     * Initialise le client du webservice
     * Liste tous les contrôleurs et contruit ses extensions
     */
    public function __construct(){
        $this->_client = new Client_Core_RestClient(SERVER_ROOT);

        // Ajout des controllers
        $extensions = array ('Client_Controllers_Users',
                            'Client_Controllers_Roles',
                            'Client_Controllers_Campains',
                            'Client_Controllers_Paiements',
                            'Client_Controllers_Documents',
                            'Client_Controllers_Articles',
							'Client_Controllers_Appointments',							'Client_Controllers_Companies');
        parent::__construct($extensions,$this->_client);
    }
}