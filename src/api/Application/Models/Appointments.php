<?php
/**
 * La classe Application_Models_Appointments permet d'agir sur la table appointments
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Appointments extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "appointments"
     * @var string
     */
    protected $table = "appointments";
    /**
     * Alias de la table liée
     * valeur : "app"
     * @var string
     */
    protected $table_as = "app";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"appointment_id"}
     * @var array
     */
    protected $primary = array("appointment_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}