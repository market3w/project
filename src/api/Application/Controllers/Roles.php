<?php
/**
 * La classe Application_Controllers_Roles effectue tous les contôles des données liées aux roles
 * Cette classe fait appel à Application_Models_Roles pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Roles extends Library_Core_Controllers{
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
        $this->table = new Application_Models_Roles($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
	
    /**
     * Récupère le role en fonction du role_id
     * @param array $data
     * @return object
     */
    public function get_role($data){
        $role_id = (empty ($data['role_id']))?null:$data['role_id'];
        if($role_id==null){return $this->setApiResult(false, true, 'param \'role_id\' undefined');}
        if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' is not numeric');}

        //------------- Where -------------------------------------------------------------//
        //Requête : WHERE current_as.`field_name`=field_value
        $this->table->addWhere("role_id",$role_id);
		
        $res = (array)$this->table->search();
        return $this->setApiResult($res);
    }
		
    /**
     * Récupère le role en fonction de l'id de l'utilisateur connecté
     * @param array $data
     * @return object
     */
    public function get_currentrole($data=""){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'You are not logged');}
        $this->table->addField("*",$this->as);
        $this->table->addJoin("users","u","role_id","role_id");
        $this->table->addWhere("user_id",$user_id,"u");
		
        $res = (array)$this->table->search();
        return $this->setApiResult($res);
    }
		
    /**
     * Récupère le role en fonction du user_id
     * @param array $data
     * @return object
     */
    public function get_userrole($data){
        $user_id = (empty($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
        $this->table->addField("*",$this->as);
        $this->table->addJoin("users","u","role_id","role_id");
        $this->table->addWhere("user_id",$user_id,"u");
		
        $res = (array)$this->table->search();
        if(!array_key_exists(0,$res)){
            return $this->setApiResult(false, true, 'user not found');
        }
        return $this->setApiResult($res);
    }
    
    /**
     * Récupère tous les roles
     * @param array $data
     * @return object
     */
    public function get_allrole($data){
        $res = (array)$this->table->search();
        return $this->setApiResult($res);
    }
}