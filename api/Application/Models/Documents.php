<?php
class Application_Models_Documents extends Library_Core_Model{
    
    protected $table = "Documents";
    protected $table_as = "d";
    protected $primary = array("document_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}