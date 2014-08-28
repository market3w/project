<?php
/**
 * La classe Application_Roles_Appointments permet d'agir sur la table roles
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Roles extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "roles"
     * @var string
     */
    protected $table = "roles";
    /**
     * Alias de la table liée
     * valeur : "r"
     * @var string
     */
    protected $table_as = "r";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"role_id"}
     * @var array
     */
    protected $primary = array("role_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}