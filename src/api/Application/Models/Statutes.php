<?php
/**
 * La classe Application_Models_Statutes permet d'agir sur la table appointments
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Statutes extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "appointments"
     * @var string
     */
    protected $table = "statutes";
    /**
     * Alias de la table liée
     * valeur : "st"
     * @var string
     */
    protected $table_as = "st";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"statut_id"}
     * @var array
     */
    protected $primary = array("statut_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}