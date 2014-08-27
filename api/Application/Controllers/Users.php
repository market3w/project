<?php
class Application_Controllers_Users extends Library_Core_Controllers{
    protected $table;
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
        $this->table = new Application_Models_Users($iDB->getConnexion());
		$as = $this->table->getAlias();
	}
	
	public function get_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->table->addJoin("roles","r","role_id","role_id");
		$this->table->addJoin("companies","c","company_id","company_id","","left");
		$this->table->addWhere("user_id",$user_id);
        $res = (array)$this->table->search();
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
		$this->table->addJoin("paiements","p","paiement_id","paiement_id","","left");
		$this->table->addWhere("user_id",$user_id);
        $res = (array)$this->table->search();
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
		$this->table->addJoin("roles","r","role_id","role_id");
		$this->table->addJoin("companies","c","company_id","company_id","","left");
		$this->table->addWhere("user_id",$user_id);
        $res = (array)$this->table->search();
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
		$this->table->addJoin("roles","r","role_id","role_id");
		$this->table->addJoin("companies","c","company_id","company_id","","left");
        $res = (array)$this->table->search();
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
    
	public function get_userbyrole($data){
        $role_id = (empty ($data['role_id']))?null:$data['role_id'];
        if($role_id==null){return $this->setApiResult(false, true, 'param \'role_id\' undefined');}
        if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' is not numeric');}
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->table->addJoin("roles","r","role_id","role_id");
		$this->table->addJoin("companies","c","company_id","company_id","","left");
		$this->table->addWhere("role_id",$role_id);
		$this->table->addWhere("user_id",$user_id);
        $res = (array)$this->table->search();
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
    
	public function get_alluserbyrole($data){
        $role_id = (empty ($data['role_id']))?null:$data['role_id'];
        if($role_id==null){return $this->setApiResult(false, true, 'param \'role_id\' undefined');}
        if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' is not numeric');}
		$this->table->addJoin("roles","r","role_id","role_id");
		$this->table->addJoin("companies","c","company_id","company_id","","left");
		$this->table->addWhere("role_id",$role_id);
        $res = (array)$this->table->search();
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
		$this->table->addJoin("roles","r","role_id","role_id");
		$this->table->addJoin("companies","c","company_id","company_id","","left");
		// Condition 
		$this->table->addWhere("user_name",$user_search,"","like");
		$this->table->addWhere("user_firstname",$user_search,"","like","or");
        $res = (array)$this->table->search();
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
		$this->table->addWhere("user_email",$user_email);
		$this->table->addWhere("user_password",md5($user_email.SALT_USER_PWD.$user_password));
		$this->table->addWhere("user_active",1);
        $res = (array)$this->table->search();
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
			// Ajouter un compte visiteur
			case "visitor":
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
				$this->table->addNewField("user_name",$user_name);
				$this->table->addNewField("user_firstname",$user_firstname);
				$this->table->addNewField("user_email",$user_email);
				$this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
				break;
			// Ajouter un compte prospet ou client
			case "prospet_client":
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
					$this->table->addNewField("user_name",$user_name);
					$this->table->addNewField("user_firstname",$user_firstname);
					$this->table->addNewField("user_email",$user_email);
					$this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
				} else {
					$post = false;
					// Conditions
					$this->table->addWhere("user_id",$_SESSSION['market3w_user_id']);
				}
				// Récupération des paramètres supplémentaires utiles
				$user_function = (empty ($data['user_function']))?null:$data['user_function'];
				$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
				$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
				$user_adress = (empty ($data['user_adress']))?null:$data['user_adress'];
				$user_adress2 = (empty ($data['user_adress2']))?null:$data['user_adress2'];
				$user_zipcode = (empty ($data['user_zipcode']))?null:$data['user_zipcode'];
				$user_town = (empty ($data['user_town']))?null:$data['user_town'];
				$role_id = (empty ($data['role_id']))?5:$data['role_id'];
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
				if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' unvalid');}
				
				// Préparation de la requête
				$this->table->addNewField("user_function",$user_function);
				$this->table->addNewField("user_phone",$user_phone);
				$this->table->addNewField("user_mobile",$user_mobile);
				$this->table->addNewField("user_adress",$user_adress);
				$this->table->addNewField("user_adress2",$user_adress2);
				$this->table->addNewField("user_zipcode",$user_zipcode);
				$this->table->addNewField("user_town",$user_town);
				$this->table->addNewField("role_id",$role_id);
				$this->table->addNewField("company_id",$company_id);
				break;
			// Ajouter un webmarketeur ou un community manager
			case "webmarketer_community_manager":
				$exist_user = $this->get_currentuser();
				if($exist_user->apiError==true){ return $this->setApiResult(false,true,'You are not logged'); }
				 
				$role = new Application_Controllers_Roles();
				$role_res = $role->get_currentrole();
				$role_current_id = $role_res->response[0]->role_id;
				if($role_current_id!=1){ return $this->setApiResult(false,true,'You can\'t add this account'); }
					
				$this->table->resetObject();
				
				$user_name = (empty ($data['user_name']))?null:$data['user_name'];
				$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
				$user_email = (empty ($data['user_email']))?null:$data['user_email'];
				$user_password = (empty ($data['user_password']))?null:$data['user_password'];
				$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
				$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
				$role_id = (empty ($data['role_id']))?null:$data['role_id'];
				
				if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
				if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
				if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
				if($user_password==null){return $this->setApiResult(false, true, 'param \'user_password\' undefined');}
				if(!array_key_exists('user_password2',$data) || $user_password!=$data['user_password2']){return $this->setApiResult(false, true, 'Enter 2 same passwords');}
				if($user_phone==null){return $this->setApiResult(false, true, 'param \'user_phone\' undefined');}
				if($user_mobile==null){return $this->setApiResult(false, true, 'param \'user_mobile\' undefined');}
				if($role_id==null){return $this->setApiResult(false, true, 'param \'role_id\' undefined');}
				if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' unvalid');}
				
				$this->table->addNewField("user_name",$user_name);
				$this->table->addNewField("user_firstname",$user_firstname);
				$this->table->addNewField("user_email",$user_email);
				$this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
				$this->table->addNewField("user_phone",$user_phone);
				$this->table->addNewField("user_mobile",$user_mobile);
				$this->table->addNewField("role_id",$role_id);
				break;
			default:
				return $this->setApiResult(false, true, 'param \'add_user_method\' value is different to "visitor", "prospet_client" or "webmarketer_community_manager"');
				break;
		}
		
		if($post===true){
        	$insert = $this->table->insert();
		} else {
        	$insert = $this->table->update();
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
		$company_id = (empty ($data['company_id']))?null:$data['company_id'];
		
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		
		//------------- Test existance en base --------------------------------------------//
		$exist_user = $this->get_currentuser();
        if($exist_user->apiError==true){ return $this->setApiResult(false,true,'You are not logged'); }
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_current_id = $role_res->response[0]->role_id;
			
		if($user_id!=$_SESSION['market3w_user_id'] && $role_current_id>=2){
			$this->table->resetObject();
			//------------- Test existance en base --------------------------------------------//
			$exist_user = $this->get_user(array("user_id"=>$user_id));
			if($exist_user->apiError==true){ return $this->setApiResult(false,true,'User not found'); }
			
			$role->get_table()->resetObject();
			$role_res = $role->get_userrole(array("user_id"=>$user_id));
			$role_id = $role_res->response[0]->role_id;
		} elseif($user_id!=$_SESSION['market3w_user_id'] && $role_current_id<2){
			return $this->setApiResult(false,true,'You can\'t update this user');
		} else {
			$role_id = $role_current_id;
		}
				
		$role_id = (empty ($data['role_id']))?$role_id:$data['role_id'];
			
		$this->table->resetObject();
		
		
		if($user_name!=null){
			$this->table->addNewField("user_name",$user_name);
		}
		if($user_firstname!=null){
			$this->table->addNewField("user_firstname",$user_firstname);
		}
		if($user_email!=null){
			$this->table->addNewField("user_email",$user_email);
		}
		if($user_password!=null && $user_password==$user_password2){
			$this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
		}
		$this->table->addNewField("user_function",$user_function);
		$this->table->addNewField("user_phone",$user_phone);
		$this->table->addNewField("user_mobile",$user_mobile);
		$this->table->addNewField("user_adress",$user_adress);
		$this->table->addNewField("user_adress2",$user_adress2);
		$this->table->addNewField("user_zipcode",$user_zipcode);
		$this->table->addNewField("user_town",$user_town);
		$this->table->addNewField("role_id",$role_id);
		if($company_id!=null){
			$this->table->addNewField("company_id",$company_id);
		}
		
        $this->table->update();
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
			
		$this->table->resetObject();
		
		if($user_id!=$_SESSION['market3w_user_id'] && $role_current_id==1){
			//------------- Test existance en base --------------------------------------------//
			$exist_user = $this->get_user(array("user_id"=>$user_id));
			if($exist_user->apiError==true){ return $this->setApiResult(false,true,'User not found'); }
			
			$role->get_table()->resetObject();
			$role_res = $role->get_userrole(array("user_id"=>$user_id));
			$role_id = $role_res->response[0]->role_id;
		} elseif($user_id!=$_SESSION['market3w_user_id'] && $role_current_id!=1){
			return $this->setApiResult(false,true,'You can\'t delete this user');
		} else {
			$role_id = $role_current_id;
		}
			
		$this->table->resetObject();
		
		$this->table->addWhere("user_id",$user_id);
		
		switch($role_id){
			case 1 : 
				return $this->setApiResult(false,true,'Delete impossible');
				break;
			case 2 :  case 3 :
				if($role_current_id == 1){
					$deleteMethod = true;
				} else {
					return $this->setApiResult(false,true,'Delete impossible');
				}
				break;
			case 4 : 
				$this->table->addNewField("user_active",0);
				$deleteMethod = false;
				break;
			case 5 : case 6 :
				$deleteMethod = true;
				break;
			default :
				break;
		}
		
		if($deleteMethod===true){
			$delete = $this->table->delete();
		} else {
			$delete = $this->table->update();
		}
		
		if($delete!="ok"){
			return $this->setApiResult(false, true, $delete);
		}
		return $this->setApiResult(true);
    }
	
	//CONTACTS 
	
	public function post_contact($data){
		// Récupération des paramètres utiles
		$user_name = (empty ($data['user_name']))?null:$data['user_name'];
		$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
		$user_email = (empty ($data['user_email']))?null:$data['user_email'];
		$objet = (empty ($data['objet']))?null:$data['objet'];
		$message_form = (empty ($data['message']))?null:$data['message'];
		
		$user_name = htmlentities($user_name, ENT_NOQUOTES, "UTF-8");
		$user_firstname = htmlentities($user_firstname, ENT_NOQUOTES, "UTF-8");
		$user_email = htmlentities($user_email, ENT_NOQUOTES, "UTF-8");
		//$objet = htmlentities($objet, ENT_NOQUOTES, "UTF-8");
		$message_form = htmlentities($message_form, ENT_NOQUOTES, "UTF-8");
		
		// Tests des variables
		if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
		if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
		if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
		if($objet==null){return $this->setApiResult(false, true, 'param \'objet\' undefined');}
		if($message_form==null){return $this->setApiResult(false, true, 'param \'message_form\' undefined');}
		
		$mail = 'weaponsb@mail.fr'; // Déclaration de l'adresse de destination.
		
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = $message_form;
		$message_html = $message_form;
		//==========
		 
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========
		 
		//=====Définition du sujet.
		$sujet = $objet;
		//=========
		 
		//=====Création du header de l'e-mail.
		$header = "From: \"".$user_name." ".$user_firstname."\"<".$user_emails.">".$passage_ligne;
		$header.= "Reply-to: \"".$user_name." ".$user_firstname."\" <".$user_emails.">".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========
		 
		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML
		$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========
		 
		//=====Envoi de l'e-mail.
		mail($mail,$sujet,$message,$header);
		//==========
		
        return $this->setApiResult(true);
	}
}