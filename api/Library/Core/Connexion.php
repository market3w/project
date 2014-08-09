<?php
class Library_Core_Connexion{
    private $connexion;
    
    public function getConnexion(){
        return $this->connexion;
    }
    
    public function __construct() {
        
    }
    
    public function connect($host, $dbname, $user, $pass, $charset){
        $this->connexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->connexion->exec("SET CHARACTER SET $charset");
    }
}