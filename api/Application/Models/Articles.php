<?php
class Application_Models_Articles extends Library_Core_Model{
    
    protected $table = "articles";
    protected $table_as = "a";
    protected $primary = array("article_id");


    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}