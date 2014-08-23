<?php
class Application_Controllers_Appointments extends Library_Core_Controllers{
    private $appointmentsTable;
	private $as;
	
	private $appointment_vars = array('appointment_id',
					   		   		   'appointment_date',
					   		   		   'appointment_places',
					   		   		   'appointment_active');
	
	public function __construct(){
        global $iDB;
        $this->appointmentsTable = new Application_Models_Appointments($iDB->getConnexion());
		$as = $this->appointmentsTable->getAlias();
	}
	
	public function get_appointment($data){
        $appointment_id = (empty ($data['appointment_id']))?null:$data['appointment_id'];
        if($appointment_id==null){return $this->setApiResult(false, true, 'param \'appointment_id\' undefined');}
        if(!is_numeric($appointment_id)){return $this->setApiResult(false, true, 'param \'appointment_id\' is not numeric');}
		// Selectionner tous les champs de la table appointments
		$this->appointmentsTable->addField("*");
		// Selectionner tous les champs de la table users pour le client
		$this->appointmentsTable->addField("*","u");
		// Selectionner tous les champs de la table users pour le webmarketter
		$this->appointmentsTable->addField("user_id","w","webmarketter_id");
		$this->appointmentsTable->addField("user_name","w","webmarketter_name");
		$this->appointmentsTable->addField("user_firstname","w","webmarketter_firstname");
		$this->appointmentsTable->addField("user_email","w","webmarketter_email");
		$this->appointmentsTable->addField("user_phone","w","webmarketter_phone");
		$this->appointmentsTable->addField("user_mobile","w","webmarketter_mobile");
		// Jointure
		$this->appointmentsTable->addJoin("users","u","user_id","user_id","","left");
		$this->appointmentsTable->addJoin("users","w","user_id","webmarketter_id","","left");
		// Condition
		$this->appointmentsTable->addWhere("appointment_id",$appointment_id);
        $res = (array)$this->appointmentsTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'appointment not found');
		}
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"user")===false)){
				$tab['appointment_user'][$k]=$v;
			} elseif(!(strpos($k,"webmarketter")===false)){
				$tab['appointment_webmarketter'][$k]=$v;
			} elseif($k=='appointment_token') {
				if($res[0]->appointment_active==1){
					$tab['appointment_url']=RTC_ROOT.'#'.$v;
				}
			} elseif(in_array($k,$this->appointment_vars)) {
				$tab[$k] = $v;
			}
		}
        return $this->setApiResult($tab);
    }
	
	public function get_currentappointment($data=array()){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}
		// Selectionner tous les champs de la table appointments
		$this->appointmentsTable->addField("*");
		// Selectionner tous les champs de la table users pour le client
		$this->appointmentsTable->addField("*","u");
		// Selectionner tous les champs de la table users pour le webmarketter
		$this->appointmentsTable->addField("user_id","w","webmarketter_id");
		$this->appointmentsTable->addField("user_name","w","webmarketter_name");
		$this->appointmentsTable->addField("user_firstname","w","webmarketter_firstname");
		$this->appointmentsTable->addField("user_email","w","webmarketter_email");
		$this->appointmentsTable->addField("user_phone","w","webmarketter_phone");
		$this->appointmentsTable->addField("user_mobile","w","webmarketter_mobile");
		// Jointure
		$this->appointmentsTable->addJoin("users","u","user_id","user_id","","left");
		$this->appointmentsTable->addJoin("users","w","user_id","webmarketter_id","","left");
		// Condition
		$this->appointmentsTable->addWhere("user_id",$user_id);
		$this->appointmentsTable->addWhere("webmarketter_id",$user_id,'','or');
        $res = (array)$this->appointmentsTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'appointment not found');
		}
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"user")===false)){
				$tab['appointment_user'][$k]=$v;
			} elseif(!(strpos($k,"webmarketter")===false)){
				$tab['appointment_webmarketter'][$k]=$v;
			} elseif($k=='appointment_token') {
				if($res[0]->appointment_active==1){
					$tab['appointment_url']=RTC_ROOT.'#'.$v;
				}
			} elseif(in_array($k,$this->appointment_vars)) {
				$tab[$k] = $v;
			}
		}
        return $this->setApiResult($tab);
    }
    
    public function get_allappointment($data){
		// Selectionner tous les champs de la table appointments
		$this->appointmentsTable->addField("*");
		// Selectionner tous les champs de la table users pour le client
		$this->appointmentsTable->addField("*","u");
		// Selectionner tous les champs de la table users pour le webmarketter
		$this->appointmentsTable->addField("user_id","w","webmarketter_id");
		$this->appointmentsTable->addField("user_name","w","webmarketter_name");
		$this->appointmentsTable->addField("user_firstname","w","webmarketter_firstname");
		$this->appointmentsTable->addField("user_email","w","webmarketter_email");
		$this->appointmentsTable->addField("user_phone","w","webmarketter_phone");
		$this->appointmentsTable->addField("user_mobile","w","webmarketter_mobile");
		// Jointure
		$this->appointmentsTable->addJoin("users","u","user_id","user_id","","left");
		$this->appointmentsTable->addJoin("users","w","user_id","webmarketter_id","","left");
        $res = (array)$this->appointmentsTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no  found');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"user")===false)){
					$tab[$k]['appointment_user'][$k2]=$v2;
				} elseif(!(strpos($k2,"webmarketter")===false)){
					$tab[$k]['appointment_webmarketter'][$k2]=$v2;
				} elseif($k2=='appointment_token') {
					if($res[$k]->appointment_active==1){
						$tab[$k]['appointment_url']=RTC_ROOT.'#'.$v2;
					}
				} elseif(in_array($k2,$this->appointment_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
		}
        return $this->setApiResult($tab);
    }
    
    public function get_postappointment($data){
        $appointment_name = (empty ($data['appointment_name']))?null:$data['appointment_name'];
        $appointment_description = (empty ($data['appointment_description']))?null:$data['appointment_description'];
        $appointment_start_date = (empty ($data['appointment_start_date']))?null:$data['appointment_start_date'];
        $appointment_start_hour = (empty ($data['appointment_start_hour']))?null:$data['appointment_start_hour'];
        $appointment_end_date = (empty ($data['appointment_end_date']))?null:$data['appointment_end_date'];
        $appointment_end_hour = (empty ($data['appointment_end_hour']))?null:$data['appointment_end_hour'];
        $type_id = (empty ($data['type_id']))?null:$data['type_id'];
		
		/* Test si l'utilisateur est connecté */
		$user = new Application_Controllers_Users();
		$exist_user = $user->get_currentuser();
		if($exist_user->apiError==true){ return $this->setApiResult(false,true,'You are not logged'); }
		 
		/* Recupération du role */
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_current_id = $role_res->response[0]->role_id;
		
		/*
			Définition de la valeur par défaut des id user et marketeur
			Si l'utilisateur est un :
			- administrateur : user_id et webmarketter_id sont null
			- webmarketeur : user_id est null et webmarketter_id = id de l'utilisateur connecté
			- prospect ou client : user_id = id de l'utilisateur connecté et webmarketter_id est null
			Sinon interdire de prendre un rendez-vous
		*/
		switch($role_current_id){
			case 1:
				$user_id = $webmarketter_id = null;
				$status_id = 2;
				break;
			case 2:
				$user_id = null;
				$webmarketter_id = $_SESSION['market3w_user_id'];
				$status_id = 2;
				break;
			case 4: 
			case 5: 
				$user_id = $_SESSION['market3w_user_id'];
				$webmarketter_id = null;
				$status_id = 1;
				break;
			default :			
				return $this->setApiResult(false,true,'You can\'t make appointments');
				break;
		}
		
        $user_id = (empty ($data['user_id']))?$user_id:$data['user_id'];
        $webmarketter_id = (empty ($data['webmarketter_id']))?$webmarketter_id:$data['webmarketter_id'];
		/* Générer un token unique */
		$appointment_token = $this->generateToken();
		
		// Tests des variables
		if($appointment_name==null){return $this->setApiResult(false, true, 'param \'appointment_name\' undefined');}
		if($appointment_start_date==null){return $this->setApiResult(false, true, 'param \'appointment_start_date\' undefined');}
		if($appointment_start_hour==null){return $this->setApiResult(false, true, 'param \'appointment_start_hour\' undefined');}
		if($appointment_end_date==null){return $this->setApiResult(false, true, 'param \'appointment_end_date\' undefined');}
		if($appointment_end_hour==null){return $this->setApiResult(false, true, 'param \'appointment_end_hour\' undefined');}
		if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		if($webmarketter_id==null){return $this->setApiResult(false, true, 'param \'webmarketter_id\' undefined');}
        if(!is_numeric($webmarketter_id)){return $this->setApiResult(false, true, 'param \'webmarketter_id\' is not numeric');}
		if($type_id==null){return $this->setApiResult(false, true, 'param \'type_id\' undefined');}
        if(!is_numeric($type_id)){return $this->setApiResult(false, true, 'param \'type_id\' is not numeric');}
		$user->resetObject();
		$user_exists = $user->get_user(array("user_id"=>$user_id));
		if(!array_key_exists(0,$user_exists->response)){
			return $this->setApiResult(false, true, 'user not found');
		}
		$user->resetObject();
		$user_exists = $user->get_userbyrole(array("user_id"=>$webmarketter_id,"role_id"=>2));
		if(!array_key_exists(0,$user_exists->response)){
			return $this->setApiResult(false, true, 'user not found');
		}
		$appointment_start_date = split("/",$appointment_start_date);
		$appointment_start_date = $appointment_start_date[2]."-".$appointment_start_date[1]."-".$appointment_start_date[0];
		$appointment_end_date = split("/",$appointment_end_date);
		$appointment_end_date = $appointment_end_date[2]."-".$appointment_end_date[1]."-".$appointment_end_date[0];
		$start_date = $appointment_start_date." ".$appointment_start_hour;
		$end_date = $appointment_end_date." ".$appointment_end_hour;
		if($this->isValidAppointment($start_date,$end_date,$user_id,$webmarketter_id)===false){
			return $this->setApiResult(false,true,'this time is not available');
		}
		
		$this->appointmentsTable->addNewField("appointment_name",$appointment_name);
		$this->appointmentsTable->addNewField("appointment_description",$appointment_description);
		$this->appointmentsTable->addNewField("appointment_start_date",$start_date);
		$this->appointmentsTable->addNewField("appointment_end_date",$end_date);
		$this->appointmentsTable->addNewField("user_id",$user_id);
		$this->appointmentsTable->addNewField("webmarketter_id",$webmarketter_id);
		$this->appointmentsTable->addNewField("appointment_token",$appointment_token);
		$this->appointmentsTable->addNewField("status_id",$status_id);
		$this->appointmentsTable->addNewField("type_id",$type_id);
		
		$insert = $this->appointmentsTable->insert();
		
        if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
    
    public function put_appointment($data){
		return $this->setApiResult(false,true,'A faire');
    }
    
    public function delete_appointment($data){
		return $this->setApiResult(false,true,'A faire');
    }
	
	private function generateToken(){		
		// Faire ... Tant que le token est invalide (au moins une execution)
		do{
			// Initialisation du token
			$random_string = "";
			// Caractères acceptés
			$valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			// Nombre de caractères acceptés
			$num_valid_chars = strlen($valid_chars);
		
			// Selection de 15 caractères
			for ($i = 0; $i < 15; $i++)
			{
				$random_pick = mt_rand(1, $num_valid_chars);
				$random_char = $valid_chars[$random_pick-1];
				$random_string .= $random_char;
				// Ajouter un '-' après le 8e caractère sélectionné
				if($i==7){
					$random_string .= "-";
				}
			}
			// Test que le token est unique
			$this->appointmentsTable->addWhere("appointment_token",$random_string);
			$res = $this->appointmentsTable->search();
			// Si le token est unique, le définir comme valide, sinon le définir comme invalide
			if(!array_key_exists(0,$res)){
				$token_valid = true;
			} else {
				$token_valid = false;
			}
			$this->appointmentsTable->resetObject();
		}while($token_valid===false);
		return $random_string;
	}
	
	private function isValidAppointment($startDate, $endDate, $user_id, $webmarketter_id){
		$this->appointmentsTable->addWhere("user_id",$user_id,"","","","(");
		$this->appointmentsTable->addWhere("webmarketter_id",$webmarketter_id,"","","or",")");
		$this->appointmentsTable->addWhere("appointment_start_date",$startDate,"","<","and","((");
		$this->appointmentsTable->addWhere("appointment_end_date",$startDate,"",">","and",")");
		$this->appointmentsTable->addWhere("appointment_start_date",$endDate,"",">","or","(");
		$this->appointmentsTable->addWhere("appointment_end_date",$endDate,"","<","and","))");
		$res = $this->appointmentsTable->search(true);
		var_dump($res);
		if(array_key_exists(0,$res)){
			return false;
		} else {
			return true;
		}
	}
}