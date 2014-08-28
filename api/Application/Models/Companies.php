<?php
/**
 * La classe Application_Models_Companies permet d'agir sur la table companies
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Companies extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "companies"
     * @var string
     */
    protected $table = "companies";
    /**
     * Alias de la table liée
     * valeur : "c"
     * @var string
     */
    protected $table_as = "c";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"company_id"}
     * @var array
     */
    protected $primary = array("company_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}