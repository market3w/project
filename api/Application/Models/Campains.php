<?php
class Application_Models_Campains extends Library_Core_Model{
    
    protected $table = "Campains";
    protected $table_as = "ca";
    protected $primary = array("campain_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}