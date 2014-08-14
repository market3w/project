<?php
class Application_Models_Paiements extends Library_Core_Model{
    
    protected $table = "Compains";
    protected $table_as = "co";
    protected $primary = array("compain_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}