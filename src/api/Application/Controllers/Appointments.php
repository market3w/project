<?php
/**
 * La classe Application_Controllers_Appointments effectue tous les contôles des données liées aux rendez-vous
 * Cette classe fait appel à Application_Models_Appointments pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Appointments extends Library_Core_Controllers{
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
     * Liste des champs à récupérer de la table liée
     * @var array
     */
    private $appointment_vars = array('appointment_id',
                                        'appointment_name',
                                        'appointment_description',
                                        'appointment_start_date',
                                        'appointment_end_date',
                                        'appointment_places',
					'status_id',
					'type_id',
                                        'appointment_active');

    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Appointments($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
	
    /**
     * Récupère un rendez-vous en fonction de son id
     * Récupère les détails de l'utilisateur, de la société et du webmarketeur liés
     * @param array $data
     * @return object
     */
    public function get_appointment($data){
        $appointment_id = (empty ($data['appointment_id']))?null:$data['appointment_id'];
        if($appointment_id==null){return $this->setApiResult(false, true, 'param \'appointment_id\' undefined');}
        if(!is_numeric($appointment_id)){return $this->setApiResult(false, true, 'param \'appointment_id\' is not numeric');}
        // Selectionner tous les champs de la table appointments
        $this->table->addField("*");
        // Selectionner tous les champs de la table users pour le client
        $this->table->addField("*","u");
        // Selectionner tous les champs de la table users pour le webmarketter
        $this->table->addField("user_id","w","webmarketter_id");
        $this->table->addField("user_name","w","webmarketter_name");
        $this->table->addField("user_firstname","w","webmarketter_firstname");
        $this->table->addField("user_email","w","webmarketter_email");
        $this->table->addField("user_phone","w","webmarketter_phone");
        $this->table->addField("user_mobile","w","webmarketter_mobile");
        // Jointure
        $this->table->addJoin("users","u","user_id","user_id","","left");
        $this->table->addJoin("users","w","user_id","webmarketter_id","","left");
        // Condition
        $this->table->addWhere("appointment_id",$appointment_id);
        $res = (array)$this->table->search();
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
        $this->table->addField("*");
        // Selectionner tous les champs de la table users pour le client
        $this->table->addField("*","u");
        // Selectionner tous les champs de la table users pour le webmarketter
        $this->table->addField("user_id","w","webmarketter_id");
        $this->table->addField("user_name","w","webmarketter_name");
        $this->table->addField("user_firstname","w","webmarketter_firstname");
        $this->table->addField("user_email","w","webmarketter_email");
        $this->table->addField("user_phone","w","webmarketter_phone");
        $this->table->addField("user_mobile","w","webmarketter_mobile");
        // Jointure
        $this->table->addJoin("users","u","user_id","user_id","","left");
        $this->table->addJoin("users","w","user_id","webmarketter_id","","left");
        // Condition
        $this->table->addWhere("user_id",$user_id);
        $this->table->addWhere("webmarketter_id",$user_id,'','or');
        $res = (array)$this->table->search();
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
    
    /**
     * Récupère tous les rendez-vous
     * Récupère les détails des utilisateurs, des sociétés et des webmarketeurs liés
     * @param array $data
     * @return object
     */
    public function get_allappointment($data){	
        // Selectionner tous les champs de la table appointments
        $this->table->addField("*");
        // Selectionner tous les champs de la table users pour le client
        $this->table->addField("*","u");
        // Selectionner tous les champs de la table users pour le webmarketter
        $this->table->addField("user_id","w","webmarketter_id");
        $this->table->addField("user_name","w","webmarketter_name");
        $this->table->addField("user_firstname","w","webmarketter_firstname");
        $this->table->addField("user_email","w","webmarketter_email");
        $this->table->addField("user_phone","w","webmarketter_phone");
        $this->table->addField("user_mobile","w","webmarketter_mobile");
        // Jointure
        $this->table->addJoin("users","u","user_id","user_id","","left");
        $this->table->addJoin("users","w","user_id","webmarketter_id","","left");
        $res = (array)$this->table->search();
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
	
	/**
     * Récupère tous les rendez-vous d'un user
     * Récupère les détails des utilisateurs, des sociétés et des webmarketeurs liés
     * @param array $data
     * @return object
     */
	 public function get_allappointmentuser($data){
		$user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}
		
		
        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupére les rdvs et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documentsiés a m'utilisateur sélectionner ou si c'est le mec lui même qui consulte
        if($role_id==1 || $role_id==2 || $role_id==4 || $role_id==5)
        {
			//Si client ou prspect ils peuvent recupérer que leur rdv
			if($role_id==4 || $role_id==5)
			{
				$user_id= $user_id_connecte;
			}
			//Sinon admin ou webmarketeurs peuvent regarder rdv d'un suer defini
			else
			{
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
			}
			
			if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
			if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
				
			// Selectionner tous les champs de la table appointments
			$this->table->addField("*");
			// Selectionner tous les champs de la table users pour le client
			$this->table->addField("*","u");
			// Selectionner tous les champs de la table users pour le webmarketter
			$this->table->addField("user_id","w","webmarketter_id");
			$this->table->addField("user_name","w","webmarketter_name");
			$this->table->addField("user_firstname","w","webmarketter_firstname");
			$this->table->addField("user_email","w","webmarketter_email");
			$this->table->addField("user_phone","w","webmarketter_phone");
			$this->table->addField("user_mobile","w","webmarketter_mobile");
			// Jointure
			$this->table->addJoin("users","u","user_id","user_id","","left");
			$this->table->addJoin("users","w","user_id","webmarketter_id","","left");
			$this->table->addWhere("user_id", $user_id);
			$res = (array)$this->table->search();
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
		 else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
    
    /**
     * Ajoute un rendez-vous
     * @param array $data
     * @return object
     */
    public function post_appointment($data){
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
        $user->get_table()->resetObject();
        $user_exists = $user->get_user(array("user_id"=>$user_id));
        if(!array_key_exists("user_id",$user_exists->response)){
            return $this->setApiResult(false, true, 'user not found');
        }
        $user->get_table()->resetObject();
        $user_exists = $user->get_userbyrole(array("user_id"=>$webmarketter_id,"role_id"=>2));
        if(!array_key_exists("user_id",$user_exists->response)){
            return $this->setApiResult(false, true, 'webmarketter not found');
        }

        /* Générer un token unique */
        if($type_id==1){
            $appointment_token = $this->generateToken();
        } else {
            $appointment_token = null;
        }

        $appointment_start_date = explode("/",$appointment_start_date);
        $appointment_start_date = $appointment_start_date[2]."-".$appointment_start_date[1]."-".$appointment_start_date[0];
        $appointment_end_date = explode("/",$appointment_end_date);
        $appointment_end_date = $appointment_end_date[2]."-".$appointment_end_date[1]."-".$appointment_end_date[0];
        $start_date = $appointment_start_date." ".$appointment_start_hour;
        $end_date = $appointment_end_date." ".$appointment_end_hour;
        if($this->isValidAppointment($start_date,$end_date,$user_id,$webmarketter_id)===false){
            return $this->setApiResult(false,true,'this time is not available');
        }

        $this->table->addNewField("appointment_name",$appointment_name);
        $this->table->addNewField("appointment_description",$appointment_description);
        $this->table->addNewField("appointment_start_date",$start_date);
        $this->table->addNewField("appointment_end_date",$end_date);
        $this->table->addNewField("user_id",$user_id);
        $this->table->addNewField("webmarketter_id",$webmarketter_id);
        $this->table->addNewField("appointment_token",$appointment_token);
        $this->table->addNewField("status_id",$status_id);
        $this->table->addNewField("type_id",$type_id);

        $insert = $this->table->insert();
		
        if($insert!="ok"){
            return $this->setApiResult(false, true, $insert);
        }
        return $this->setApiResult(true);
    }
    
    /**
     * Modifie un rendez-vous
     * @param array $data
     * @return object
     */
    public function put_appointment($data){
        $appointment_id = (empty ($data['appointment_id']))?null:$data['appointment_id'];
        if($appointment_id==null){return $this->setApiResult(false, true, 'param \'appointment_id\' undefined');}
        if(!is_numeric($appointment_id)){return $this->setApiResult(false, true, 'param \'appointment_id\' is not numeric');}
		
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
            - administrateur : mettre à jour le rendez-vous
            - webmarketeur ou prospect ou client : 
                # Si l'utilisateur connecté est le webmarketeur ou le prospect / client : mettre à jour le rendez-vous
                # Sinon interdire la mise à jour du rendez-vous
            Sinon interdire la mise à jour du rendez-vous
        */
        switch($role_current_id){
            case 1:
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("appointment_active",1);
                    $status_id = 2;
                    $res = $this->table->search();
                    if(!array_key_exists(0,$res)){
                            return $this->setApiResult(false,true,'Appointment not found');
                    }
                    break;
            case 2:
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("webmarketter_id",$_SESSION['market3w_user_id']);
                    $this->table->addWhere("appointment_active",1);
                    $status_id = 2;
                    $res = $this->table->search();
                    if(!array_key_exists(0,$res)){
                            return $this->setApiResult(false,true,'You can\'t update this appointment');
                    }
                    break;
            case 4: 
            case 5: 
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("user_id",$_SESSION['market3w_user_id']);
                    $this->table->addWhere("appointment_active",1);
                    $status_id = 1;
                    $res = $this->table->search();
                    if(!array_key_exists(0,$res)){
                            return $this->setApiResult(false,true,'You can\'t update this appointment');
                    }
                    break;
            default :			
                    return $this->setApiResult(false,true,'You can\'t update this appointment');
                    break;
        }
        $appointment = $res[0];
        $appointment_name = (empty ($data['appointment_name']))?null:$data['appointment_name'];
        $appointment_description = (empty ($data['appointment_description']))?null:$data['appointment_description'];
        $appointment_start_date = (empty ($data['appointment_start_date']))?null:$data['appointment_start_date'];
        $appointment_start_hour = (empty ($data['appointment_start_hour']))?null:$data['appointment_start_hour'];
        $appointment_end_date = (empty ($data['appointment_end_date']))?null:$data['appointment_end_date'];
        $appointment_end_hour = (empty ($data['appointment_end_hour']))?null:$data['appointment_end_hour'];
        $user_id = $appointment->user_id;
        $webmarketter_id = $appointment->webmarketter_id;
        $type_id = (empty ($data['type_id']))?null:$data['type_id'];
		
        if($type_id==1){
            if(is_null($appointment->appointment_token)){
                /* Générer un token unique */
                $appointment_token = $this->generateToken();
            } else {
                $appointment_token = $appointment->appointment_token;
            }
        } else {
            $appointment_token = null;
        }

        if($appointment_name==null){return $this->setApiResult(false, true, 'param \'appointment_name\' undefined');}
        if($appointment_start_date==null){return $this->setApiResult(false, true, 'param \'appointment_start_date\' undefined');}
        if($appointment_start_hour==null){return $this->setApiResult(false, true, 'param \'appointment_start_hour\' undefined');}
        if($appointment_end_date==null){return $this->setApiResult(false, true, 'param \'appointment_end_date\' undefined');}
        if($appointment_end_hour==null){return $this->setApiResult(false, true, 'param \'appointment_end_hour\' undefined');}
        if($type_id==null){return $this->setApiResult(false, true, 'param \'type_id\' undefined');}
        if(!is_numeric($type_id)){return $this->setApiResult(false, true, 'param \'type_id\' is not numeric');}
		
        $appointment_start_date = explode("/",$appointment_start_date);
        $appointment_start_date = $appointment_start_date[2]."-".$appointment_start_date[1]."-".$appointment_start_date[0];
        $appointment_end_date = explode("/",$appointment_end_date);
        $appointment_end_date = $appointment_end_date[2]."-".$appointment_end_date[1]."-".$appointment_end_date[0];
        $start_date = $appointment_start_date." ".$appointment_start_hour;
        $end_date = $appointment_end_date." ".$appointment_end_hour;

        /* 
            Si les dates n'ont pas changées, mettre à jour le rendez-vous
            Sinon changer le statut à "reporter" et ajouter un nouveau rendez-vous
        */
        $this->table->resetObject();
        $this->table->addWhere("appointment_id",$appointment_id);
        if($appointment->appointment_start_date == $start_date && $appointment->appointment_end_date == $end_date){
            $updateMethod = true;
        } else {
            $updateMethod = false;
            $this->table->addNewField("status_id",4);
            $this->table->addNewField("appointment_token",null);
            $this->table->addNewField("appointment_active",0);
            $update = $this->table->update();

            if($update!="ok"){
                return $this->setApiResult(false, true, $update);
            }

            $this->table->resetObject();
        }

        $this->table->addNewField("appointment_name",$appointment_name);
        $this->table->addNewField("appointment_description",$appointment_description);
        $this->table->addNewField("appointment_start_date",$start_date);
        $this->table->addNewField("appointment_end_date",$end_date);
        $this->table->addNewField("user_id",$user_id);
        $this->table->addNewField("webmarketter_id",$webmarketter_id);
        $this->table->addNewField("appointment_token",$appointment_token);
        $this->table->addNewField("status_id",$status_id);
        $this->table->addNewField("type_id",$type_id);

        if($updateMethod===true){
            $update = $this->table->update();
        } else {
            $update = $this->table->insert();
        }
		
        if($update!="ok"){
            return $this->setApiResult(false, true, $update);
        }
        return $this->setApiResult(true);
    }
    
    /**
     * Défini un rendez-vous comme terminé
     * @param array $data
     * @return object
     */
    public function put_appointmentfinish($data){
        $appointment_id = (empty ($data['appointment_id']))?null:$data['appointment_id'];
        if($appointment_id==null){return $this->setApiResult(false, true, 'param \'appointment_id\' undefined');}
        if(!is_numeric($appointment_id)){return $this->setApiResult(false, true, 'param \'appointment_id\' is not numeric');}
		
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
            - administrateur : clore le rendez-vous
            - webmarketeur ou prospect ou client : 
                # Si l'utilisateur connecté est le webmarketeur ou le prospect / client : clore le rendez-vous
                # Sinon interdire la cloture du rendez-vous
            Sinon interdire la cloture du rendez-vous
        */
        switch($role_current_id){
            case 1:
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("appointment_active",1);
                    break;
            case 2:
            case 4: 
            case 5: 
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("user_id",$_SESSION['market3w_user_id'],"","","","(");
                    $this->table->addWhere("webmarketter_id",$_SESSION['market3w_user_id'],"","","or",")");
                    $this->table->addWhere("appointment_active",1);
                    $res = $this->table->search();
                    if(!array_key_exists(0,$res)){
                            return $this->setApiResult(false,true,'You can\'t close this appointment');
                    }
                    break;
            default :			
                    return $this->setApiResult(false,true,'You can\'t close this appointment');
                    break;
        }
        $this->table->addNewField("status_id",5);
        $this->table->addNewField("appointment_token",null);
        $this->table->addNewField("appointment_active",0);

        $update = $this->table->update();
		
        if($update!="ok"){
            return $this->setApiResult(false, true, $update);
        }
        return $this->setApiResult(true);
    }
    
    /**
     * Annule un rendez-vous
     * @param array $data
     * @return object
     */
    public function delete_appointment($data){
        $appointment_id = (empty ($data['appointment_id']))?null:$data['appointment_id'];
        if($appointment_id==null){return $this->setApiResult(false, true, 'param \'appointment_id\' undefined');}
        if(!is_numeric($appointment_id)){return $this->setApiResult(false, true, 'param \'appointment_id\' is not numeric');}
		
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
            - administrateur : annuler le rendez-vous
            - webmarketeur ou prospect ou client : 
                # Si l'utilisateur connecté est le webmarketeur ou le prospect / client : annuler le rendez-vous
                # Sinon interdire l'annulation du rendez-vous
            Sinon interdire l'annulation du rendez-vous
        */
        switch($role_current_id){
            case 1:
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("appointment_active",1);
                    break;
            case 2:
            case 4: 
            case 5: 
                    $this->table->addWhere("appointment_id",$appointment_id);
                    $this->table->addWhere("user_id",$_SESSION['market3w_user_id'],"","","","(");
                    $this->table->addWhere("webmarketter_id",$_SESSION['market3w_user_id'],"","","or",")");
                    $this->table->addWhere("appointment_active",1);
                    $res = $this->table->search();
                    if(!array_key_exists(0,$res)){
                        return $this->setApiResult(false,true,'You can\'t cancel this appointment');
                    }
                    break;
            default :			
                    return $this->setApiResult(false,true,'You can\'t cancel this appointment');
                    break;
        }
        $this->table->addNewField("status_id",3);
        $this->table->addNewField("appointment_token",null);
        $this->table->addNewField("appointment_active",0);

        $update = $this->table->update();
		
        if($update!="ok"){
            return $this->setApiResult(false, true, $update);
        }
        return $this->setApiResult(true);
    }
	
    /**
     * Génère un token unique
     * @return string
     */
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
            $this->table->addWhere("appointment_token",$random_string);
            $res = $this->table->search();
            // Si le token est unique, le définir comme valide, sinon le définir comme invalide
            if(!array_key_exists(0,$res)){
                $token_valid = true;
            } else {
                $token_valid = false;
            }
            $this->table->resetObject();
        }while($token_valid===false);
        return $random_string;
    }
	
    private function isValidAppointment($startDate, $endDate, $user_id, $webmarketter_id){
        $this->table->resetObject();
        $this->table->addWhere("user_id",$user_id,"","","","(");
        $this->table->addWhere("webmarketter_id",$webmarketter_id,"","","or",")");
        $this->table->addWhere("appointment_start_date",array($startDate,$endDate),"","between","and","(");
        $this->table->addWhere("appointment_end_date",array($startDate,$endDate),"","between","or",")");
        $this->table->addWhere("appointment_start_date",$startDate,"",">=");
        $this->table->addWhere("appointment_end_date",$endDate,"","<=");
        $res = $this->table->search();
        if(array_key_exists(0,$res)){
            return false;
        } else {
            return true;
        }
    }
}