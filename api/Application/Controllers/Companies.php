<?php
/**
 * La classe Application_Controllers_Companies effectue tous les contôles des données liées aux sociétés
 * Cette classe fait appel à Application_Models_Companies pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Companies extends Library_Core_Controllers{
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
    private $company_vars = array('company_id',
                                    'company_siret',
                                    'company_siren',
                                    'company_name',
                                    'company_adress',
                                    'company_adress2',
                                    'company_zipcode',
                                    'company_town',
                                    'company_nb_employees');
	
    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Companies($iDB->getConnexion());
        $as = $this->table->getAlias();
	
    }
	
    /**
     * Récupère la société en fonction de son id
     * Récupère les détails des utilisateurs liés
     * @param array $data
     * @return object
     */
    public function get_company($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupère la société et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer sa société
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {			
            $company_id = (empty ($data['company_id']))?null:$data['company_id'];
            if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
            if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' is not numeric');}
            // Jointure
            $this->table->addJoin("users","u","company_id","company_id","","left");
            $this->table->addJoin("roles","r","role_id","role_id","u","left"); 
            // Condition
            $this->table->addWhere("company_id",$company_id);
            //Si c'est un client on regarde si c'est sa société sinon "company not found"
            //if($role_id==3){$this->table->addWhere("u.user_id",$user_id);}
            $res = (array)$this->table->search();

            $tab = array();
            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, 'Company not found');
            }
            foreach($res as $k=>$v){
                foreach($v as $k2=>$v2){
                    if(!(strpos($k2,"role")===false)){
                        $tab['company_users'][$k]['user_role'][$k2]=$v2;
                    } elseif(!(strpos($k2,"user")===false)){
                        $tab['company_users'][$k][$k2]=$v2;
                    } elseif(in_array($k2,$this->company_vars)) {
                        $tab[$k2] = $v2;
                    }
                }
                if($tab['company_users'][$k]['user_id']!=null){
                    $tab['company_users'][$k]['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['company_users'][$k]['user_id'];
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
     * Récupère la société de l'utilisateur connecté
     * Récupère les détails des utilisateurs liés
     * @param array $data
     * @return object
     */
    public function get_currentcompany($data){
        $company_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($company_id==null){return $this->setApiResult(false, true, 'You are not logged');}
        // Jointure
        $this->table->addJoin("users","u","company_id","company_id","","left");
        $this->table->addJoin("roles","r","role_id","role_id","u"); 
        // Condition
        $this->table->addWhere("user_id",$_SESSION['market3w_user_id'],"u");
        $res = (array)$this->table->search();
		
        $tab = array();
        if(!array_key_exists(0,$res)){
            return $this->setApiResult(false, true, 'Company not found');
        }
        foreach($res as $k=>$v){
            foreach($v as $k2=>$v2){
                if(!(strpos($k2,"role")===false)){
                    $tab['company_users'][$k]['user_role'][$k2]=$v2;
                } elseif(!(strpos($k2,"user")===false)){
                    $tab['company_users'][$k][$k2]=$v2;
                } elseif(in_array($k2,$this->company_vars)) {
                    $tab[$k2] = $v2;
                }
            }
            if($tab['company_users'][$k]['user_id']!=null){
                $tab['company_users'][$k]['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['company_users'][$k]['user_id'];
            }
        }
        return $this->setApiResult($tab);
    }
	
    /**
     * Récupère toutes les sociétés
     * Récupère les détails des utilisateurs liés
     * @param array $data
     * @return object
     */
    public function get_allcompany($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils peuvent récupèrer toutes les sociétés
        if($role_id==1 || $role_id==2)
        {
            // Jointure
            $this->table->addJoin("users","u","company_id","company_id","","left");
            $this->table->addJoin("roles","r","role_id","role_id","u","left");  
            $res = (array)$this->table->search();

            $tab = array();
            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, 'No companies found');
            }
            $count = 0;
            $countUser = 0;
            foreach($res as $k=>$v){
                if($k!=0){
                    if($v->company_id!=$last->company_id){
                        $count++;
                        $countUser = 0;
                    } else {
                        $countUser++;
                    }
                }
                foreach($v as $k2=>$v2){
                    if(!(strpos($k2,"role")===false)){
                        $tab[$count]['company_users'][$countUser]['user_role'][$k2]=$v2;
                    } elseif(!(strpos($k2,"user")===false)){
                        $tab[$count]['company_users'][$countUser][$k2]=$v2;
                    } elseif(in_array($k2,$this->company_vars)) {
                        $tab[$count][$k2] = $v2;
                    }
                }
                if($tab[$count]['company_users'][$countUser]['user_id']!=null){
                    $tab[$count]['company_users'][$countUser]['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$count]['company_users'][$countUser]['user_id'];
                }
                $last = $v;
            }
            return $this->setApiResult($tab);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
    
    /**
     * Récupère toutes les sociétés dont le nom est en partie trouvé en base de données (3 caractères minimum)
     * Récupère les détails des utilisateurs liés
     * @param array $data
     * @return object
     */
    public function get_autocompletioncompany($data){
        $company_search = (empty ($data['company_search']))?null:$data['company_search'];
        if($company_search==null){return $this->setApiResult(false, true, 'param \'company_search\' undefined');}
        if(strlen($company_search)<3){return $this->setApiResult(false, true, '3 characters minimum for autocompletion');}
        // Jointure
        $this->table->addJoin("users","u","company_id","company_id","","left");
        $this->table->addJoin("roles","r","role_id","role_id","u","left"); 
        // Condition 
        $this->table->addWhere("company_name",$company_search,"","like");
        $res = (array)$this->table->search();
        $tab = array();
        if(!array_key_exists(0,$res)){
            return $this->setApiResult(false, true, 'No companies found');
        }
        $count = 0;
        $countUser = 0;
        foreach($res as $k=>$v){
            if($k!=0){
                if($v->company_id!=$last->company_id){
                    $count++;
                    $countUser = 0;
                } else {
                    $countUser++;
                }
            }
            foreach($v as $k2=>$v2){
                if(!(strpos($k2,"role")===false)){
                    $tab[$count]['company_users'][$countUser]['user_role'][$k2]=$v2;
                } elseif(!(strpos($k2,"user")===false)){
                    $tab[$count]['company_users'][$countUser][$k2]=$v2;
                } elseif(in_array($k2,$this->company_vars)) {
                    $tab[$count][$k2] = $v2;
                }
            }
            if($tab[$count]['company_users'][$countUser]['user_id']!=null){
                $tab[$count]['company_users'][$countUser]['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$count]['company_users'][$countUser]['user_id'];
            }
            $last = $v;
        }
        return $this->setApiResult($tab);
    }
    
    /**
     * Ajoute une société
     * @param array $data
     * @return object
     */
    public function post_company($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'You are not logged');}
		
        $post = true;
        $add_company_role = (empty ($data['add_company_role']))?null:$data['add_company_role'];
        if($add_company_role==null){return $this->setApiResult(false, true, 'param \'add_company_role\' undefined');}
		
        switch($add_company_role){
            //Administrateur, peut poster une compagnie autant qu'il veut
            case "administrateur": 
            case "webmarketteur":
                    // Récupération des parametres
                    $company_siret = (empty ($data['company_siret']))?null:$data['company_siret'];
                    $company_siren = (empty ($data['company_siren']))?null:$data['company_siren'];
                    $company_name = (empty ($data['company_name']))?null:$data['company_name'];
                    $company_adress = (empty ($data['company_adress']))?null:$data['company_adress'];
                    $company_adress2 = (empty ($data['company_adress2']))?null:$data['company_adress2'];
                    $company_zipcode = (empty ($data['company_zipcode']))?null:$data['company_zipcode'];
                    $company_town = (empty ($data['company_town']))?null:$data['company_town'];
                    $company_nb_employees = (empty ($data['company_nb_employees']))?null:$data['company_nb_employees'];
                    // Tests des variables
                    if($company_siret==null){return $this->setApiResult(false, true, 'param \'company_siret\' undefined');}
                    if(!is_numeric($company_siret)){return $this->setApiResult(false, true, 'param \'company_siret\' unvalid');}
                    if($company_siren==null){return $this->setApiResult(false, true, 'param \'company_siren\' undefined');}
                    if(!is_numeric($company_siren)){return $this->setApiResult(false, true, 'param \'company_siren\' unvalid');}
                    if($company_name==null){return $this->setApiResult(false, true, 'param \'company_name\' undefined');}
                    if($company_adress==null){return $this->setApiResult(false, true, 'param \'company_adress\' undefined');}
                    if($company_zipcode==null){return $this->setApiResult(false, true, 'param \'company_zipcode\' undefined');}
                    if(!is_numeric($company_zipcode)){return $this->setApiResult(false, true, 'param \'company_zipcode\' unvalid');}
                    if($company_town==null){return $this->setApiResult(false, true, 'param \'company_town\' undefined');}
                    if(!is_numeric($company_nb_employees)){return $this->setApiResult(false, true, 'param \'company_nb_employees\' unvalid');}

                    // Préparation de la requete
                    $this->table->addNewField("company_siret",$company_siret);
                    $this->table->addNewField("company_siren",$company_siren);
                    $this->table->addNewField("company_name",$company_name);
                    $this->table->addNewField("company_adress",$company_adress);
                    $this->table->addNewField("company_adress2",$company_adress2);
                    $this->table->addNewField("company_zipcode",$company_zipcode);
                    $this->table->addNewField("company_town",$company_town);
                    $this->table->addNewField("company_nb_employees",$company_nb_employees);
                    break;
            // Cas pour prendre des RDV
            case "client": 
            case "prospet":
                    // Récupération des parametres
                    $company_siret = (empty ($data['company_siret']))?null:$data['company_siret'];
                    $company_siren = (empty ($data['company_siren']))?null:$data['company_siren'];
                    $company_name = (empty ($data['company_name']))?null:$data['company_name'];
                    $company_adress = (empty ($data['company_adress']))?null:$data['company_adress'];
                    $company_adress2 = (empty ($data['company_adress2']))?null:$data['company_adress2'];
                    $company_zipcode = (empty ($data['company_zipcode']))?null:$data['company_zipcode'];
                    $company_town = (empty ($data['company_town']))?null:$data['company_town'];
                    $company_nb_employees = (empty ($data['company_nb_employees']))?null:$data['company_nb_employees'];
                    // Tests des variables
                    if($company_siret==null){return $this->setApiResult(false, true, 'param \'company_siret\' undefined');}
                    if(!is_numeric($company_siret)){return $this->setApiResult(false, true, 'param \'company_siret\' unvalid');}
                    if($company_siren==null){return $this->setApiResult(false, true, 'param \'company_siren\' undefined');}
                    if(!is_numeric($company_siren)){return $this->setApiResult(false, true, 'param \'company_siren\' unvalid');}
                    if($company_name==null){return $this->setApiResult(false, true, 'param \'company_name\' undefined');}
                    if($company_adress==null){return $this->setApiResult(false, true, 'param \'company_adress\' undefined');}
                    if($company_zipcode==null){return $this->setApiResult(false, true, 'param \'company_zipcode\' undefined');}
                    if(!is_numeric($company_zipcode)){return $this->setApiResult(false, true, 'param \'company_zipcode\' unvalid');}
                    if($company_town==null){return $this->setApiResult(false, true, 'param \'company_town\' undefined');}
                    if($company_nb_employees==null){return $this->setApiResult(false, true, 'param \'company_nb_employees\' undefined');}
                    if(!is_numeric($company_nb_employees)){return $this->setApiResult(false, true, 'param \'company_nb_employees\' unvalid');}

                    // Préparation de la requete
                    $this->table->addNewField("company_siret",$company_siret);
                    $this->table->addNewField("company_siren",$company_siren);
                    $this->table->addNewField("company_name",$company_name);
                    $this->table->addNewField("company_adress",$company_adress);
                    $this->table->addNewField("company_adress2",$company_adress2);
                    $this->table->addNewField("company_zipcode",$company_zipcode);
                    $this->table->addNewField("company_town",$company_town);
                    $this->table->addNewField("company_nb_employees",$company_nb_employees);


                    break;
            default:
                    return $this->setApiResult(false, true, 'param \'add_company_role\' value is different to "marketeur", "client"');
                    break;
        }

        if($post===true){
            $insert = $this->table->insert();
        } else {
        }
		
        if($insert!="ok"){
            return $this->setApiResult(false, true, $insert);
        }
        return $this->setApiResult(true);
    }
    
    /**
     * Modifie une société
     * @param array $data
     * @return object
     */
    public function put_company($data){
        // Récupération des parametres
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
        $company_siret = (empty ($data['company_siret']))?null:$data['company_siret'];
        $company_siren = (empty ($data['company_siren']))?null:$data['company_siren'];
        $company_name = (empty ($data['company_name']))?null:$data['company_name'];
        $company_adress = (empty ($data['company_adress']))?null:$data['company_adress'];
        $company_adress2 = (empty ($data['company_adress2']))?null:$data['company_adress2'];
        $company_zipcode = (empty ($data['company_zipcode']))?null:$data['company_zipcode'];
        $company_town = (empty ($data['company_town']))?null:$data['company_town'];
        $company_nb_employees = (empty ($data['company_nb_employees']))?null:$data['company_nb_employees'];

        // Tests des variables
        if($company_siret==null){return $this->setApiResult(false, true, 'param \'company_siret\' undefined');}
        if(!is_numeric($company_siret)){return $this->setApiResult(false, true, 'param \'company_siret\' unvalid');}
        if($company_siren==null){return $this->setApiResult(false, true, 'param \'company_siren\' undefined');}
        if(!is_numeric($company_siren)){return $this->setApiResult(false, true, 'param \'company_siren\' unvalid');}
        if($company_name==null){return $this->setApiResult(false, true, 'param \'company_name\' undefined');}
        if($company_adress==null){return $this->setApiResult(false, true, 'param \'company_adress\' undefined');}
        if($company_zipcode==null){return $this->setApiResult(false, true, 'param \'company_zipcode\' undefined');}
        if(!is_numeric($company_zipcode)){return $this->setApiResult(false, true, 'param \'company_zipcode\' unvalid');}
        if($company_town==null){return $this->setApiResult(false, true, 'param \'company_town\' undefined');}
        if($company_nb_employees==null){return $this->setApiResult(false, true, 'param \'company_nb_employees\' undefined');}
        if(!is_numeric($company_nb_employees)){return $this->setApiResult(false, true, 'param \'company_nb_employees\' unvalid');}

        //------------- Test existance en base --------------------------------------------//
        $exist_company = $this->get_company(array("company_id"=>$company_id));
        if($exist_company->apiError==true){ return $this->setApiResult(false,true,$exist_company->apiErrorMessage); }
        $update = array();
		
		//------------- Test et ajout des champs ------------------------------------------//
        $this->table->addNewField("company_siret",$company_siret); 
        $this->table->addNewField("company_siren",$company_siren);
        $this->table->addNewField("company_name",$company_name);
        $this->table->addNewField("company_adress",$company_adress);
        $this->table->addNewField("company_adress2",$company_adress2);
        $this->table->addNewField("company_zipcode",$company_zipcode);
        $this->table->addNewField("company_town",$company_town);
        $this->table->addNewField("company_nb_employees",$company_nb_employees);
		
        $this->table->update();
        return $this->setApiResult(true);
    }
    
    /**
     * Supprime une société
     * @param array $data
     * @return object
     */
    public function delete_company($data){	
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur il peut supprimer une société
        if($role_id==1)
        {
            $company_id = (empty ($data['company_id']))?null:$data['company_id'];

            //------------- Test existance en base --------------------------------------------//
            $exist_company = $this->get_company(array("company_id"=>$company_id));
            if($exist_company->apiError==true){ return $this->setApiResult(false,true,$exist_company->apiErrorMessage); }
            $deleteMethod = true;
            $users = array();
            if(count($exist_company->response["company_users"])!=0){
                foreach($exist_company->response["company_users"] as $k=>$v){
                    if(!is_null($v["user_id"])){
                        $users[] = $v["user_id"];
                        if($v["user_role"]["role_id"]==4){
                            $deleteMethod = false;
                        }
                    }
                }
            }
            $this->table->resetObject();
            $this->table->addWhere("company_id",$company_id);
            if($deleteMethod===true){
                $delete = $this->table->delete();
            } else {
                $this->table->addNewField("company_active",0);
                $delete = $this->table->update();
            }

            if($delete!="ok"){
                return $this->setApiResult(false, true, $delete);
            }

            if(count($users)!=0){
                if($this->delete_company_users($users)===false){
                    return $this->setApiResult(false, true, 'There is an error during users deletion');
                }
            }

            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'You can\'t delete this company');
        }
    }
	
    /**
     * Supprime les utilisateurs d'une société 
     * @param array $ids
     * @return boolean
     */
    private function delete_company_users($ids){
        $users = new Application_Controllers_Users();
        $usersTable = $users->get_table();
        foreach($ids as $k=>$id){
            $usersTable->resetObject();
            $delete = $users->delete_user(array("user_id"=>$id));
            if($delete->apiError==true){ 
                return false; 
            }
        }
        return true;
    }
}