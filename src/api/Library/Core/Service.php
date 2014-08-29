<?php
/**
 * La classe Library_Core_Service permet de faire appel à toutes les méthodes du service
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Library_Core_Service extends Library_Core_Extensions {
    
    /**
     * Méthode magique __construct()
     * Initialise l'id de l'utilisateur
     * Liste tous les contrôleurs et contruit ses extensions
     */
    public function __construct(){
        // Initialisation du user_id en session
        if(empty ($_SESSION['market3w_user_id'])){
            $_SESSION['market3w_user_id'] = -1;
        }
		
        // Ajout des controllers
        $extensions = array ('Application_Controllers_Users',
                            'Application_Controllers_Roles',
                            'Application_Controllers_Statutes',
                            'Application_Controllers_Companies',
                            'Application_Controllers_Articles',
                            'Application_Controllers_Paiements',
                            'Application_Controllers_Campains',
                            'Application_Controllers_Appointments',
                            'Application_Controllers_Documents');

        parent::__construct($extensions);
    }
}