<?php
class Application_Models_Users extends Library_Core_Model{
    
    protected $table = "users";
    protected $table_as = "u";
    protected $primary = array("user_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}
?>
