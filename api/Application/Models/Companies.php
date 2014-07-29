<?php
class Application_Models_Companies extends Library_Core_Model{
    
    protected $table = "companies";
    protected $table_as = "c";
    protected $primary = array("company_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}
?>
