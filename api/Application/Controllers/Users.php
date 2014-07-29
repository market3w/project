<?php
class Application_Controllers_Users extends Library_Core_Controllers{
    private $usersTable;
	private $as;
	
	private $user_name;
	private $user_firstname;
	private $user_email;
	private $user_role;
	private $user_function;
	private $user_phone;
	private $user_company;
	
	public function __construct(){
        global $iDB;
        $this->usersTable = new Application_Models_Users($iDB->getConnexion());
		$as = $this->usersTable->getAlias();
		$user_role = new Application_Models_Roles($iDB->getConnexion());
	}
	
	public function get_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->usersTable->addWhere("user_id",$user_id);
        $res = (array)$this->usersTable->search();
        return $this->setApiResult($res);
    }
	
	public function get_currentuser($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}
		$this->usersTable->addWhere("user_id",$user_id);
        $res = (array)$this->usersTable->search();
        return $this->setApiResult($res);
    }
    
    public function get_alluser($data){
        $res = (array)$this->usersTable->search();
        return $this->setApiResult($res);
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
				// Si aucun compte existant
				if($_SESSSION['market3w_user_id']==-1){
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
					// Récupération des paramètres utiles
					$user_function = (empty ($data['user_function']))?null:$data['user_function'];
					// Tests des variables
					if($user_function==null){return $this->setApiResult(false, true, 'param \'user_function\' undefined');}
					// Préparation de la requête
					$this->usersTable->addNewField("user_function",$user_function);
					// Conditions
					$this->usersTable->addWhere("user_id",$_SESSSION['market3w_user_id']);
				}
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
		}
		
        if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
    
    public function put_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        $user_name = (empty ($data['user_name']))?null:$data['user_name'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_user = $this->get_user(array("user_id"=>$user_id));
        if($exist_user->apiError==true){ return $this->setApiResult(false,true,$exist_user->apiErrorMessage); }
        $update = array();
		
		//------------- Test et ajout des champs ------------------------------------------//
        if($user_name!=null){
			$this->usersTable->addNewField("user_name",$user_name);
		}
        $this->usersTable->update();
        return $this->setApiResult(true);
    }
    
    public function delete_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_user = $this->get_user(array("user_id"=>$user_id));
        if($exist_user->apiError==true){ return $this->setApiResult(false,true,$exist_user->apiErrorMessage); }
        $update = array();
		
        $this->usersTable->delete();
        return $this->setApiResult(true);
    }
}