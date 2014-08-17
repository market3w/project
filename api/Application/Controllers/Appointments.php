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
    
    public function post_appointment($data){
		return $this->setApiResult(false,true,'A faire');
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
}