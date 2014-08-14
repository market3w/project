<?php
class Application_Models_Roles extends Library_Core_Model{
    
    protected $table = "roles";
    protected $table_as = "r";
    protected $primary = array("role_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}