<?php
class Application_Models_Statutes extends Library_Core_Model{
    
    protected $table = "statutes";
    protected $table_as = "st";
    protected $primary = array("status_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}
?>
