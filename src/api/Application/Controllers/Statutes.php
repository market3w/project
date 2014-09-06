<?php
/**
 * La classe Application_Controllers_Statutes effectue tous les contôles des données liées aux statuts
 * Cette classe fait appel à Application_Models_Statutes pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Statutes extends Library_Core_Controllers{
    /**
     * Stocke le modèle de la table
     * @var object
     */
    protected $table;
    /**
     * Stocke l'alias de la table
     * @var string
     */
    private $as;
	
    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Statutes($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
	
    /**
     * Récupère le statut en fonction du status_id
     * @param array $data
     * @return object
     */
    public function get_status($data){
        $status_id = (empty ($data['status_id']))?null:$data['status_id'];
        if($status_id==null){return $this->setApiResult(false, true, 'param \'status_id\' undefined');}
        if(!is_numeric($status_id)){return $this->setApiResult(false, true, 'param \'status_id\' is not numeric');}
		
        //------------- Where -------------------------------------------------------------//
        //Requête : WHERE current_as.`field_name`=field_value
        $this->table->addWhere("status_id",$status_id);
        return $this->setApiResult($res);
    }
    
    /**
     * Récupère tous les statuts
     * @param array $data
     * @return object
     */
    public function get_allstatus($data){
        $res = (array)$this->table->search();
        return $this->setApiResult($res);
    }
}