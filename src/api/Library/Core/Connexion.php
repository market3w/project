<?php
/**
 * La classe Library_Core_Connexion permet d'établir une connexion avec la base de données en utilisant PDO
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Library_Core_Connexion{
    
    /**
     * Variable privée stockant la connexion à la base de données
     * @var object 
     */
    private $connexion;
    
    /**
     * Retourne la connexion
     * @return object
     */
    public function getConnexion(){
        return $this->connexion;
    }
    
    /**
     * Stocke la connexion dans la variable de classe $connexion
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $pass
     * @param string $charset
     */
    public function connect($host, $dbname, $user, $pass, $charset){
        $this->connexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->connexion->exec("SET CHARACTER SET $charset");
    }
}