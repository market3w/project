<?php
class Application_Models_Paiements extends Library_Core_Model{
    
    protected $table = "paiements";
    protected $table_as = "p";
    protected $primary = array("paiement_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}