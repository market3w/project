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
     * Liste tous les contrôleurs et contruit ses extensions
     */
    public function __construct(){		
        // Ajout des controllers
        $extensions = array ('Application_Controllers_Users',
                            'Application_Controllers_Roles',
                            'Application_Controllers_Statutes',
                            'Application_Controllers_Companies',
                            'Application_Controllers_Articles',
                            'Application_Controllers_Paiements',
                            'Application_Controllers_Campains',
                            'Application_Controllers_Appointments',
                            'Application_Controllers_Documents',
                            'Application_Controllers_Sessions');

        parent::__construct($extensions);
    }
}