<?php
class Application_Controllers_Users extends Library_Core_Controllers{
    private $usersTable;
	private $as;
	
	private $user_vars = array('user_id',
					   		   'user_name',
					   		   'user_firstname',
					   		   'user_email',
					   		   'user_function',
					   		   'user_phone',
					   		   'user_mobile',
					   		   'user_adress',
					   		   'user_adress2',
					   		   'user_zipcode',
					   		   'user_town');
	
	public function __construct(){
        global $iDB;
        $this->usersTable = new Application_Models_Users($iDB->getConnexion());
		$as = $this->usersTable->getAlias();
	}
	
	public function get_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->usersTable->addJoin("roles","r","role_id","role_id");
		$this->usersTable->addJoin("companies","c","company_id","company_id","","left");
		$this->usersTable->addWhere("user_id",$user_id);
        $res = (array)$this->usersTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'user not found');
		}
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"role")===false)){
				$tab['user_role'][$k]=$v;
			} elseif(!(strpos($k,"company")===false)){
				$tab['user_company'][$k]=$v;
			} elseif(in_array($k,$this->user_vars)) {
				$tab[$k] = $v;
			}
		}
		if($tab['user_company']['company_id']!=null){
			$tab['user_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab['user_company']['company_id'];
		}
        return $this->setApiResult($tab);
    }
	
	public function get_user_paiement($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->usersTable->addJoin("paiements","p","paiement_id","paiement_id","","left");
		$this->usersTable->addWhere("user_id",$user_id);
        $res = (array)$this->usersTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'user not found');
		}
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"paiement")===false)){
				$tab['user_paiement'][$k]=$v;
			} elseif(in_array($k,$this->user_vars)) {
				$tab[$k] = $v;
			}
		}
		if($tab['user_paiement']['user_paiement']!=null){
			$tab['user_paiement']['paiement_url']=API_ROOT."?method=paiement&paiement_id=".(int)$tab['user_paiement']['paiement_id'];
		}
        return $this->setApiResult($tab);
    }
	
	public function get_currentuser($data=array()){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}
		$this->usersTable->addJoin("roles","r","role_id","role_id");
		$this->usersTable->addJoin("companies","c","company_id","company_id","","left");
		$this->usersTable->addWhere("user_id",$user_id);
        $res = (array)$this->usersTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			$_SESSION['market3w_user_id']=-1;
			return $this->setApiResult(false, true, 'you are not logged');
		}
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"role")===false)){
				$tab['user_role'][$k]=$v;
			} elseif(!(strpos($k,"company")===false)){
				$tab['user_company'][$k]=$v;
			} elseif(in_array($k,$this->user_vars)) {
				$tab[$k] = $v;
			}
		}
		if($tab['user_company']['company_id']!=null){
			$tab['user_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab['user_company']['company_id'];
		}
        return $this->setApiResult($tab);
    }
    
    public function get_alluser($data){
		$this->usersTable->addJoin("roles","r","role_id","role_id");
		$this->usersTable->addJoin("companies","c","company_id","company_id","","left");
        $res = (array)$this->usersTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no users found');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"role")===false)){
					$tab[$k]['user_role'][$k2]=$v2;
				} elseif(!(strpos($k2,"company")===false)){
					$tab[$k]['user_company'][$k2]=$v2;
				} elseif(in_array($k2,$this->user_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
			if($tab[$k]['user_company']['company_id']!=null){
				$tab[$k]['user_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab[$k]['user_company']['company_id'];
			}
		}
        return $this->setApiResult($tab);
    }
    
	public function get_alluserbyrole($data){
        $role_id = (empty ($data['role_id']))?null:$data['role_id'];
        if($role_id==null){return $this->setApiResult(false, true, 'param \'role_id\' undefined');}
        if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' is not numeric');}
		$this->usersTable->addJoin("roles","r","role_id","role_id");
		$this->usersTable->addJoin("companies","c","company_id","company_id","","left");
		$this->usersTable->addWhere("role_id",$role_id);
        $res = (array)$this->usersTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no users found in this category');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"role")===false)){
					$tab[$k]['user_role'][$k2]=$v2;
				} elseif(!(strpos($k2,"company")===false)){
					$tab[$k]['user_company'][$k2]=$v2;
				} elseif(in_array($k2,$this->user_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
			if($tab[$k]['user_company']['company_id']!=null){
				$tab[$k]['user_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab[$k]['user_company']['company_id'];
			}
		}
        return $this->setApiResult($tab);
    }
	
    public function get_autocompletionuser($data){
        $user_search = (empty ($data['user_search']))?null:$data['user_search'];
        if($user_search==null){return $this->setApiResult(false, true, 'param \'user_search\' undefined');}
        if(strlen($user_search)<3){return $this->setApiResult(false, true, '3 characters minimum for autocompletion');}
		// Jointure
		$this->usersTable->addJoin("roles","r","role_id","role_id");
		$this->usersTable->addJoin("companies","c","company_id","company_id","","left");
		// Condition 
		$this->usersTable->addWhere("user_name",$user_search,"","like");
		$this->usersTable->addWhere("user_firstname",$user_search,"","like","or");
        $res = (array)$this->usersTable->search();
        $tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no users found');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"role")===false)){
					$tab[$k]['user_role'][$k2]=$v2;
				} elseif(!(strpos($k2,"company")===false)){
					$tab[$k]['user_company'][$k2]=$v2;
				} elseif(in_array($k2,$this->user_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
			if($tab[$k]['user_company']['company_id']!=null){
				$tab[$k]['user_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab[$k]['user_company']['company_id'];
			}
		}
        return $this->setApiResult($tab);
    }
	
	public function post_login($data){
		// Récupération des paramètres utiles
		$user_email = (empty ($data['user_email']))?null:$data['user_email'];
		$user_password = (empty ($data['user_password']))?null:$data['user_password'];
		// Tests des variables
		if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
		if($user_password==null){return $this->setApiResult(false, true, 'param \'user_password\' undefined');}
		// Ajout des champs de recherche
		$this->usersTable->addWhere("user_email",$user_email);
		$this->usersTable->addWhere("user_password",md5($user_email.SALT_USER_PWD.$user_password));
        $res = (array)$this->usersTable->search();
		if(empty($res)){
			return $this->setApiResult(false, true, 'Login incorrect');
		} else {
			$_SESSION['market3w_user_id']=$res[0]->user_id;
		}
        return $this->setApiResult($res);
	}
	
	public function post_logout($data){
		$_SESSION['market3w_user_id']=-1;
        return $this->setApiResult(true);
	}
    
    public function post_user($data){
		$post = true;
		$add_user_method = (empty ($data['add_user_method']))?null:$data['add_user_method'];
        if($add_user_method==null){return $this->setApiResult(false, true, 'param \'add_user_method\' undefined');}
		
		switch($add_user_method){
			// Cas pour télécharger les pdf et / ou voir les vidéos
			case "consulting":
				// Récupération des paramètres utiles
				$user_name = (empty ($data['user_name']))?null:$data['user_name'];
				$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
				$user_email = (empty ($data['user_email']))?null:$data['user_email'];
				$user_password = (empty ($data['user_password']))?null:$data['user_password'];
				// Tests des variables
				if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
				if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
				if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
				if($user_password==null){return $this->setApiResult(false, true, 'param \'user_password\' undefined');}
				if(!array_key_exists('user_password2',$data) || $user_password!=$data['user_password2']){return $this->setApiResult(false, true, 'Enter 2 same passwords');}
				// Préparation de la requête
				$this->usersTable->addNewField("user_name",$user_name);
				$this->usersTable->addNewField("user_firstname",$user_firstname);
				$this->usersTable->addNewField("user_email",$user_email);
				$this->usersTable->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
				break;
			// Cas pour prendre des RDV
			case "appointment":
				$exist_user = $this->get_currentuser();
        		if($exist_user->apiError==true) {
					// Récupération des paramètres utiles
					$user_name = (empty ($data['user_name']))?null:$data['user_name'];
					$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
					$user_email = (empty ($data['user_email']))?null:$data['user_email'];
					$user_password = (empty ($data['user_password']))?null:$data['user_password'];
					// Tests des variables
					if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
					if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
					if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
					if($user_password==null){return $this->setApiResult(false, true, 'param \'user_password\' undefined');}
					if(!array_key_exists('user_password2',$data) || $user_password!=$data['user_password2']){return $this->setApiResult(false, true, 'Enter 2 same passwords');}
					// Préparation de la requête
					$this->usersTable->addNewField("user_name",$user_name);
					$this->usersTable->addNewField("user_firstname",$user_firstname);
					$this->usersTable->addNewField("user_email",$user_email);
					$this->usersTable->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
				} else {
					$post = false;
					// Conditions
					$this->usersTable->addWhere("user_id",$_SESSSION['market3w_user_id']);
				}
				// Récupération des paramètres supplémentaires utiles
				$user_function = (empty ($data['user_function']))?null:$data['user_function'];
				$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
				$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
				$user_adress = (empty ($data['user_adress']))?null:$data['user_adress'];
				$user_adress2 = (empty ($data['user_adress2']))?null:$data['user_adress2'];
				$user_zipcode = (empty ($data['user_zipcode']))?null:$data['user_zipcode'];
				$user_town = (empty ($data['user_town']))?null:$data['user_town'];
				$role_id = (empty ($data['role_id']))?null:$data['role_id'];
				$company_id = (empty ($data['company_id']))?null:$data['company_id'];
				// Tests des variables
				if($user_function==null){return $this->setApiResult(false, true, 'param \'user_function\' undefined');}
				if($user_phone==null){return $this->setApiResult(false, true, 'param \'user_phone\' undefined');}
				if($user_mobile==null){return $this->setApiResult(false, true, 'param \'user_mobile\' undefined');}
				if($user_adress==null){return $this->setApiResult(false, true, 'param \'user_adress\' undefined');}
				if($user_zipcode==null){return $this->setApiResult(false, true, 'param \'user_zipcode\' undefined');}
				if(!is_numeric($user_zipcode)){return $this->setApiResult(false, true, 'param \'user_zipcode\' unvalid');}
				if($user_town==null){return $this->setApiResult(false, true, 'param \'user_town\' undefined');}
				if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
				if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' unvalid');}
				
				// Préparation de la requête
				$this->usersTable->addNewField("user_function",$user_function);
				$this->usersTable->addNewField("user_phone",$user_phone);
				$this->usersTable->addNewField("user_mobile",$user_mobile);
				$this->usersTable->addNewField("user_adress",$user_adress);
				$this->usersTable->addNewField("user_adress2",$user_adress2);
				$this->usersTable->addNewField("user_zipcode",$user_zipcode);
				$this->usersTable->addNewField("user_town",$user_town);
				$this->usersTable->addNewField("role_id",5);
				$this->usersTable->addNewField("company_id",$company_id);
				break;
			// Cas ajout par l'administrateur
			case "byAdmin":
				$user_name = (empty ($data['user_name']))?null:$data['user_name'];
				if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
				$this->usersTable->addNewField("user_name",$user_name);
				break;
			default:
				return $this->setApiResult(false, true, 'param \'add_user_method\' value is different to "consulting", "appointment" or "byAdmin"');
				break;
		}
		
		if($post===true){
        	$insert = $this->usersTable->insert();
		} else {
        	$insert = $this->usersTable->update();
		}
		
        if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
    
    public function put_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
		$user_name = (empty ($data['user_name']))?null:$data['user_name'];
		$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
		$user_email = (empty ($data['user_email']))?null:$data['user_email'];
		$user_password = (empty ($data['user_password']))?null:$data['user_password'];
		$user_password2 = (empty ($data['user_password']))?null:$data['user_password2'];
		$user_function = (empty ($data['user_function']))?null:$data['user_function'];
		$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
		$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
		$user_adress = (empty ($data['user_adress']))?null:$data['user_adress'];
		$user_adress2 = (empty ($data['user_adress2']))?null:$data['user_adress2'];
		$user_zipcode = (empty ($data['user_zipcode']))?null:$data['user_zipcode'];
		$user_town = (empty ($data['user_town']))?null:$data['user_town'];
		$role_id = (empty ($data['role_id']))?null:$data['role_id'];
		$company_id = (empty ($data['company_id']))?null:$data['company_id'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_user = $this->get_currentuser();
        if($exist_user->apiError==true){ return $this->setApiResult(false,true,'You are not logged'); }
		if($exist_user->response['role_id']==1){
			$exist_user = $this->get_user(array('user_id'=>$user_id));
        	if($exist_user->apiError==true){ return $this->setApiResult(false,true,'User not found'); }
		}
		
		$this->usersTable->addNewField("user_name",$user_name);
		$this->usersTable->addNewField("user_firstname",$user_firstname);
		$this->usersTable->addNewField("user_email",$user_email);
		if($user_password!=null && $user_password==$user_password2){
			$this->usersTable->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
		}
		$this->usersTable->addNewField("user_function",$user_function);
		$this->usersTable->addNewField("user_phone",$user_phone);
		$this->usersTable->addNewField("user_mobile",$user_mobile);
		$this->usersTable->addNewField("user_adress",$user_adress);
		$this->usersTable->addNewField("user_adress2",$user_adress2);
		$this->usersTable->addNewField("user_zipcode",$user_zipcode);
		$this->usersTable->addNewField("user_town",$user_town);
		$this->usersTable->addNewField("role_id",$role_id);
		$this->usersTable->addNewField("company_id",$company_id);
		
        $this->usersTable->update();
        return $this->setApiResult(true);
    }
    
    public function delete_user($data){
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		
		//------------- Test de connexion -------------------------------------------------//
		$exist_user = $this->get_currentuser();
        if($exist_user->apiError==true){ return $this->setApiResult(false,true,'You are not logged'); }
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_current_id = $role_res->response[0]->role_id;
			
		$this->usersTable->resetObject();
		
		if($user_id!=$_SESSION['market3w_user_id'] && $role_current_id==1){
			//------------- Test existance en base --------------------------------------------//
			$exist_user = $this->get_user(array("user_id"=>$user_id));
			if($exist_user->apiError==true){ return $this->setApiResult(false,true,'User not found'); }
			
			$role_res = $role->get_userrole(array("user_id"=>$user_id));
		} elseif($user_id!=$_SESSION['market3w_user_id'] && $role_current_id!=1){
			return $this->setApiResult(false,true,'You can\'t delete this user');
		} else {
			$role_id = $role_current_id;
		}
			
		$this->usersTable->resetObject();
		
		$this->usersTable->addWhere("user_id",$user_id);
		
		switch($role_id){
			case 1 : 
				return $this->setApiResult(false,true,'Delete impossible');
				break;
			case 2 :  case 3 :
				if($role_current_id == 1){
					$this->usersTable->delete();
					return $this->setApiResult(true);
				} else {
					return $this->setApiResult(false,true,'Delete impossible');
				}
				break;
			case 4 : 
				$this->usersTable->addNewField("user_active",0);
				$this->usersTable->update();
				break;
			case 5 : case 6 :
				$this->usersTable->delete();
				return $this->setApiResult(true);
				break;
			default :
				break;
		}
    }
}