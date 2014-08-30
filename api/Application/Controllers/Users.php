<?php
/**
 * La classe Application_Controllers_Users effectue tous les contôles des données liées aux utilisateurs
 * Cette classe fait appel à Application_Models_Users pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Users extends Library_Core_Controllers{
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
	
    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Users($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
	
    /**
     * Récupère un utilisateur en fonction de son id
     * Récupère les détails de son role et de la société
     * @param array $data
     * @return object
     */
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
	
    /**
     * Récupère un utilisateur en fonction de son id
     * Récupère les détails de ses paiements
     * @param array $data
     * @return object
     */
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
	
    /**
     * Récupère l'utilisateur connecté
     * Récupère les détails de son role et de la société
     * @param array $data
     * @return object
     */
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
    
    /**
     * Récupère tous les utilisateurs
     * Récupère les détails de leurs roles et de leurs sociétés
     * @param array $data
     * @return object
     */
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
    
    /**
     * Récupère l'utilisateur en fonction de son id et ayant le role défini en paramètre
     * Récupère les détails de son role et de la société
     * @param array $data
     * @return object
     */
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
    
    /**
     * Récupère tous les utilisateurs ayant le role défini en paramètre
     * Récupère les détails de leurs roles et de leurs sociétés
     * @param array $data
     * @return object
     */
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
	
    /**
     * Récupère tous les utilisateurs dont le nom ou le prenom est en partie trouvé en base de données (3 caractères minimum)
     * Récupère les détails de leurs roles et de leurs sociétés
     * @param array $data
     * @return object
     */
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
	
    /**
     * Connexion
     * Récupère l'utilisateur si les identifiants sont corrects
     * @param array $data
     * @return object
     */
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
	
    /**
     * Déconnexion
     * @param array $data
     * @return object
     */
    public function post_logout($data){
        $_SESSION['market3w_user_id']=-1;
        return $this->setApiResult(true);
    }
    
    /**
     * Ajoute ou modifie un compte utilisateur
     * @param array $data
     * @return object
     */
    public function post_user($data){
       
      	 $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		 
		 //Si visiteur non connecté et donc  non inscrits
        if($user_id_connecte==null)
		{
			// Récupération des paramètres utiles
			$user_name = (empty ($data['user_name']))?null:$data['user_name'];
			$user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
			$user_email = (empty ($data['user_email']))?null:$data['user_email'];
			$user_password = (empty ($data['user_password']))?null:$data['user_password'];
			$user_function = (empty ($data['user_function']))?null:$data['user_function'];
			$user_phone = (empty ($data['user_phone']))?null:$data['user_phone'];
			$user_mobile = (empty ($data['user_mobile']))?null:$data['user_mobile'];
			$user_adress = (empty ($data['user_adress']))?null:$data['user_adress'];
			$user_adress2 = (empty ($data['user_adress2']))?null:$data['user_adress2'];
			$user_zipcode = (empty ($data['user_zipcode']))?null:$data['user_zipcode'];
			$user_town = (empty ($data['user_town']))?null:$data['user_town'];
			$role_id = 5;
			//$company_id = (empty ($data['company_id']))?null:$data['company_id'];
			// Tests des variables
			if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
			if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
			if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
			if($user_password==null){return $this->setApiResult(false, true, 'param \'user_password\' undefined');}
			if(!array_key_exists('user_password2',$data) || $user_password!=$data['user_password2']){return $this->setApiResult(false, true, 'Enter 2 same passwords');}
			if($user_function==null){return $this->setApiResult(false, true, 'param \'user_function\' undefined');}
			if($user_phone==null){return $this->setApiResult(false, true, 'param \'user_phone\' undefined');}
			if($user_mobile==null){return $this->setApiResult(false, true, 'param \'user_mobile\' undefined');}
			if($user_adress==null){return $this->setApiResult(false, true, 'param \'user_adress\' undefined');}
			if($user_zipcode==null){return $this->setApiResult(false, true, 'param \'user_zipcode\' undefined');}
			if(!is_numeric($user_zipcode)){return $this->setApiResult(false, true, 'param \'user_zipcode\' unvalid');}
			if($user_town==null){return $this->setApiResult(false, true, 'param \'user_town\' undefined');}
			//if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
			//if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' unvalid');}
			if(!is_numeric($role_id)){return $this->setApiResult(false, true, 'param \'role_id\' unvalid');}
			// Préparation de la requête
			$this->table->addNewField("user_name",$user_name);
			$this->table->addNewField("user_firstname",$user_firstname);
			$this->table->addNewField("user_email",$user_email);
			$this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
			$this->table->addNewField("user_function",$user_function);
			$this->table->addNewField("user_phone",$user_phone);
			$this->table->addNewField("user_mobile",$user_mobile);
			$this->table->addNewField("user_adress",$user_adress);
			$this->table->addNewField("user_adress2",$user_adress2);
			$this->table->addNewField("user_zipcode",$user_zipcode);
			$this->table->addNewField("user_town",$user_town);
			$this->table->addNewField("role_id",$role_id);
			//$this->table->addNewField("company_id",$company_id);
			
			$insert = $this->table->insert();
       
			if($insert!="ok"){
				return $this->setApiResult(false, true, $insert);
			}
			return $this->setApiResult(true);
		}
		//Sinon connecté
		else
		{
			 $role = new Application_Controllers_Roles();
			$role_res = $role->get_currentrole();
			$role_id = $role_res->response[0]->role_id;
		} 
        
    }
    
    /**
     * Modifier un compte utilisateur
     * @param array $data
     * @return object
     */
    public function put_user($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        $user_name = (empty ($data['user_name']))?null:$data['user_name'];
        $user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
        $user_email = (empty ($data['user_email']))?null:$data['user_email'];
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
        if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
        if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
        if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}

        //------------- Test existance en base --------------------------------------------//
        $exist_user = $this->get_currentuser();
        if($exist_user->apiError==true){ return $this->setApiResult(false,true,'You are not logged'); }
		 
        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_current_id = $role_res->response[0]->role_id;

        //Si c'est un admin ou un webmarkeut ils peuvent modifier ainsi que l'user concerné
        if(($user_id!=$_SESSION['market3w_user_id'] && $role_current_id>=2) || $user_id==$_SESSION['market3w_user_id'] ){
            $this->table->resetObject();
            //------------- Test existance en base --------------------------------------------//
            $exist_user = $this->get_user(array("user_id"=>$user_id));
            if($exist_user->apiError==true){ return $this->setApiResult(false,true,'User not found'); }

            $role->get_table()->resetObject();
            $role_res = $role->get_userrole(array("user_id"=>$user_id));
            $role_id = $role_res->response[0]->role_id;
        }
        elseif($user_id!=$_SESSION['market3w_user_id'] && $role_current_id<2){
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
        /*if($user_password!=null && $user_password==$user_password2){
            $this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
        }*/
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
        $this->table->addWhere("user_id", $user_id);
        $this->table->update();
        return $this->setApiResult(true);
    }
	
    /**
     * Modifie le mot de passe
     * @param array $data
     * @return object
     */
    public function put_password($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $user_password = (empty ($data['user_password']))?null:$data['user_password'];
        $user_password2 = (empty ($data['user_password']))?null:$data['user_password'];
        $user_email = (empty ($data['user_email']))?null:$data['user_email'];

        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
        if($user_password==null){return $this->setApiResult(false, true, 'param \'user_password\' undefined');}
        if($user_password2==null){return $this->setApiResult(false, true, 'param \'user_password2\' undefined');}
        if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}

        $this->table->resetObject();


        if($user_password!=null && $user_password==$user_password2){
            $this->table->addNewField("user_password",md5($user_email.SALT_USER_PWD.$user_password));
        }
        $this->table->addWhere("user_id", $user_id);
        $this->table->update();
        return $this->setApiResult(true);
    }
    
    /**
     * Supprime ou désactive un compte utilisateur
     * @param array $data
     * @return object
     */
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
	
    /**
     * Envoi d'un mail pour prendre contact
     * @param array $data
     * @return object
     */
    public function post_contact($data){
        // Récupération des paramètres utiles
        $user_name = (empty ($data['user_name']))?null:$data['user_name'];
        $user_firstname = (empty ($data['user_firstname']))?null:$data['user_firstname'];
        $user_email = (empty ($data['user_email']))?null:$data['user_email'];
        $objet = (empty ($data['objet']))?null:$data['objet'];
        $message_form = (empty ($data['message']))?null:$data['message'];

        // Tests des variables
        if($user_name==null){return $this->setApiResult(false, true, 'param \'user_name\' undefined');}
        if($user_firstname==null){return $this->setApiResult(false, true, 'param \'user_firstname\' undefined');}
        if($user_email==null){return $this->setApiResult(false, true, 'param \'user_email\' undefined');}
        if($objet==null){return $this->setApiResult(false, true, 'param \'objet\' undefined');}
        if($message_form==null){return $this->setApiResult(false, true, 'param \'message_form\' undefined');}

        //$mail = 'weaponsb@mail.fr'; // Déclaration de l'adresse de destination.
        $mail = 'thierryflorian@free.fr';

        if($this->send_mail($user_name, $user_firstname, $user_email, $objet, $message_form, $mail)===true){
            return $this->setApiResult(true);
        } else {
            return $this->setApiResult(false, true, "An error occurred while sending your email");
        }
    }
}