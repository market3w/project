<?php
/**
 * La classe Application_Models_Campains permet d'agir sur la table campains
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Campains extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "campains"
     * @var string
     */
    protected $table = "campains";
    /**
     * Alias de la table liée
     * valeur : "ca"
     * @var string
     */
    protected $table_as = "ca";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"campain_id"}
     * @var array
     */
    protected $primary = array("campain_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}