<?php
class Application_Controllers_Roles extends Library_Core_Controllers{
    private $roleTable;
	private $as;
	
	public function __construct(){
        global $iDB;
        $this->roleTable = new Application_Models_Roles($iDB->getConnexion());
		$as = $this->roleTable->getAlias();
	}
	
	public function get_role($data){
        $role_id = (empty ($data['role_id']))?null:$data['role_id'];
        if($role_id==null){return $this->setApiResult(false, true, 'param \'role_id\' undefined');}
        if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' is not numeric');}
		
		//------------- Where -------------------------------------------------------------//
		//Requête : WHERE current_as.`field_name`=field_value
		$this->roleTable->addWhere("role_id",$role_id);
		
        $res = (array)$this->roleTable->search();
        return $this->setApiResult($res);
    }
    
    public function get_allrole($data){
        $res = (array)$this->roleTable->search();
        return $this->setApiResult($res);
    }
}