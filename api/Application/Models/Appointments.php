<?php
class Application_Models_Appointments extends Library_Core_Model{
    
    protected $table = "appointments";
    protected $table_as = "app";
    protected $primary = array("appointment_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}