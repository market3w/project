<?php
/**
 * La classe Application_Models_Sessions permet d'agir sur la table sessions
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Sessions extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "sessions"
     * @var string
     */
    protected $table = "sessions";
    /**
     * Alias de la table liée
     * valeur : "ses"
     * @var string
     */
    protected $table_as = "ses";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"session_token"}
     * @var array
     */
    protected $primary = array("session_token");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}