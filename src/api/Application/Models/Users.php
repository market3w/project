<?php
/**
 * La classe Application_Models_Users permet d'agir sur la table users
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Users extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "users"
     * @var string
     */
    protected $table = "users";
    /**
     * Alias de la table liée
     * valeur : "u"
     * @var string
     */
    protected $table_as = "u";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"user_id"}
     * @var array
     */
    protected $primary = array("user_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}