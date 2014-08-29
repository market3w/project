<?php
/**
 * La classe Application_Models_Paiements permet d'agir sur la table paiements
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Models_Paiements extends Library_Core_Model{
    
    /**
     * Nom de la table liée
     * valeur : "paiements"
     * @var string
     */
    protected $table = "paiements";
    /**
     * Alias de la table liée
     * valeur : "p"
     * @var string
     */
    protected $table_as = "p";
    /**
     * Clefs primaires de la table liée
     * valeurs : {"paiement_id"}
     * @var array
     */
    protected $primary = array("paiement_id");

    /**
     * Fourni la connexion à Library_Core_Model
     * @param object $connexion
     */
    public function __construct($connexion) {
        parent::__construct($connexion);
    }
}