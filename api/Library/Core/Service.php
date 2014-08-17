<?php
class Library_Core_Service extends Library_Core_Extensions {
    
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
							 'Application_Controllers_Appointments');
		
		parent::__construct($extensions);
    }
}