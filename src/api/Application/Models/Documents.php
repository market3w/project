<?php
/**
 * La classe Application_Models_Documents permet d'agir sur la table documents
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Documents extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "documents"
     * @var string
     */
    protected $table = "documents";
    /**
     * Alias de la table liée
     * valeur : "d"
     * @var string
     */
    protected $table_as = "d";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"document_id"}
     * @var array
     */
    protected $primary = array("document_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}