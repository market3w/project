<?php
/**
 * La classe Application_Models_Articles permet d'agir sur la table articles
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Articles extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "articles"
     * @var string
     */
    protected $table = "articles";
    /**
     * Alias de la table liée
     * valeur : "a"
     * @var string
     */
    protected $table_as = "a";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"article_id"}
     * @var array
     */
    protected $primary = array("article_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}