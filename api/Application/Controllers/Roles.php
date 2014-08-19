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
	
	public function get_currentrole($data=""){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'You are not logged');}
		$this->roleTable->addField("*",$this->as);
		$this->roleTable->addJoin("users","u","role_id","role_id");
		$this->roleTable->addWhere("user_id",$user_id,"u");
		
        $res = (array)$this->roleTable->search();
        return $this->setApiResult($res);
    }
	
	public function get_userrole($data){
        $user_id = (empty($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->roleTable->addField("*",$this->as);
		$this->roleTable->addJoin("users","u","role_id","role_id");
		$this->roleTable->addWhere("user_id",$user_id,"u");
		
        $res = (array)$this->roleTable->search();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'user not found');
		}
        return $this->setApiResult($res);
    }
    
    public function get_allrole($data){
        $res = (array)$this->roleTable->search();
        return $this->setApiResult($res);
    }
}