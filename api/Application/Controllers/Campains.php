<?php
/**
 * La classe Application_Controllers_Campains effectue tous les contôles des données liées aux campagnes
 * Cette classe fait appel à Application_Models_Campains pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Campains extends Library_Core_Controllers{
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
    private $campain_vars = array('campain_id',
                                    'campain_name',
                                    'campain_courte_description',
                                    'campain_description',
                                    'campain_prix',
                                    'company_id',
                                    'campain_completion',
                                    'campain_date',
                                    'campain_date_modif');
	
    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Campains($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
	
    /**
     * Récupère la campagne en fonction de son id
     * Récupère les détails de l'utilisateur, de la société et du webmarketeur liés
     * @param array $data
     * @return object
     */
    public function get_campain($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupère le document et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
        if($role_id==1 || $role_id==2 || $role_id==4 )
        {
            $campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
            if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
            if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' is not numeric');}

            // Selectionner tous les champs de la table campains
            $this->table->addField("*");
            // Selectionner tous les champs de la table users pour le client
            $this->table->addField("*","u");
            // Selectionner tous les champs de la table companies pour le client
            $this->table->addField("*","c");
            // Selectionner tous les champs de la table users pour le webmarketter
            $this->table->addField("user_id","w","webmarketter_id");
            $this->table->addField("user_name","w","webmarketter_name");
            $this->table->addField("user_firstname","w","webmarketter_firstname");
            $this->table->addField("user_email","w","webmarketter_email");
            $this->table->addField("user_phone","w","webmarketter_phone");
            $this->table->addField("user_mobile","w","webmarketter_mobile");

            // Jointure
            $this->table->addJoin("users","u","user_id","contact_id","","left");
            $this->table->addJoin("companies","c","company_id","company_id","u","left");
            $this->table->addJoin("users","w","user_id","webmarketter_id","","left");

            // Condition
            $this->table->addWhere("campain_id",$campain_id);
            if($role_id==4){ $this->table->addWhere("contact_id",$user_id); }

            //Si un membre veut recupérer une campagne, on vérifie que celui-ci lui appartienne sinon la campagne sera "not found"
            if($role_id==3){$this->documentsTable->addWhere("user_id",$user_id);}
            $res = (array)$this->table->search();
            $tab = array();

            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, 'campain not found');
            }

            foreach($res[0] as $k=>$v){
                if(!(strpos($k,"user")===false)){
                    $tab['campain_contact'][$k]=$v;
                } elseif(!(strpos($k,"company")===false)){
                    $tab['campain_company'][$k]=$v;
                } elseif(!(strpos($k,"webmarketter")===false)){
                    $tab['campain_webmarketter'][$k]=$v;
                } elseif(in_array($k,$this->campain_vars)) {
                    $tab[$k] = $v;
                }
            }
            if($tab['campain_company']['company_id']!=null){
                $tab['campain_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab['campain_company']['company_id'];
            }
            if($tab['campain_contact']['user_id']!=null){
                $tab['campain_contact']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['campain_contact']['user_id'];
            }
            if($tab['campain_webmarketter']['webmarketter_id']!=null){
                $tab['campain_webmarketter']['webmarketter_url']=API_ROOT."?method=user&user_id=".(int)$tab['campain_webmarketter']['webmarketter_id'];
            }
            return $this->setApiResult($tab);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
	
    /**
     * Récupère toutes les campagnes d'une société
     * Récupère les détails des utilisateurs, des sociétés et des webmarketeurs liés
     * @param array $data
     * @return object
     */
    public function get_allcampain_company($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupère les campagnes et leur compagnies// Sinon si c'est un client il ne peut que recuperer les campagnes de leur société
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {	
            $company_id = (empty ($data['company_id']))?null:$data['company_id'];
            if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
            if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' is not numeric');}

            // Selectionner tous les champs de la table campains
            $this->table->addField("*");
            // Selectionner tous les champs de la table users pour le client
            $this->table->addField("*","u");
            // Selectionner tous les champs de la table companies pour le client
            $this->table->addField("*","c");
            // Selectionner tous les champs de la table users pour le webmarketter
            $this->table->addField("user_id","w","webmarketter_id");
            $this->table->addField("user_name","w","webmarketter_name");
            $this->table->addField("user_firstname","w","webmarketter_firstname");
            $this->table->addField("user_email","w","webmarketter_email");
            $this->table->addField("user_phone","w","webmarketter_phone");
            $this->table->addField("user_mobile","w","webmarketter_mobile");

            // Jointure
            $this->table->addJoin("users","u","user_id","contact_id","","left");
            $this->table->addJoin("companies","c","company_id","company_id","u","left");
            $this->table->addJoin("users","w","user_id","webmarketter_id","","left");
            $this->table->addWhere("company_id",$company_id,"c");

            $res = (array)$this->table->search();
            $tab = array();
            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, ' no campains found');
            }
            foreach($res as $k=>$v){
                foreach($v as $k2=>$v2){
                    if(!(strpos($k2,"user")===false)){
                        $tab[$k]['campain_contact'][$k2]=$v2;
                    } elseif(!(strpos($k2,"company")===false)){
                        $tab[$k]['campain_company'][$k2]=$v2;
                    } elseif(!(strpos($k2,"webmarketter")===false)){
                        $tab[$k]['campain_webmarketter'][$k2]=$v2;
                    } elseif(in_array($k2,$this->campain_vars)) {
                        $tab[$k][$k2] = $v2;
                    }
                }
                if($tab[$k]['campain_company']['company_id']!=null){
                    $tab[$k]['campain_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab[$k]['campain_company']['company_id'];
                }
                if($tab[$k]['campain_contact']['user_id']!=null){
                    $tab[$k]['campain_contact']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['campain_contact']['user_id'];
                }
                if($tab[$k]['campain_webmarketter']['webmarketter_id']!=null){
                    $tab[$k]['campain_webmarketter']['webmarketter_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['campain_webmarketter']['webmarketter_id'];
                }
            }
            return $this->setApiResult($tab);
        }
    }
	
    /**
     * Récupère toutes les campagnes
     * Récupère les détails des utilisateurs, des sociétés et des webmarketeurs liés
     * @param array $data
     * @return object
     */
    public function get_allcampain($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur peut récupèrer toutes les campagnes en court
        if($role_id==1 || $role_id==2 || $role_id==4)
        {
            // Selectionner tous les champs de la table campains
            $this->table->addField("*");
            // Selectionner tous les champs de la table users pour le client
            $this->table->addField("*","u");
            // Selectionner tous les champs de la table companies pour le client
            $this->table->addField("*","c");
            // Selectionner tous les champs de la table users pour le webmarketter
            $this->table->addField("user_id","w","webmarketter_id");
            $this->table->addField("user_name","w","webmarketter_name");
            $this->table->addField("user_firstname","w","webmarketter_firstname");
            $this->table->addField("user_email","w","webmarketter_email");
            $this->table->addField("user_phone","w","webmarketter_phone");
            $this->table->addField("user_mobile","w","webmarketter_mobile");

            // Jointure
            $this->table->addJoin("users","u","user_id","contact_id","","left");
            $this->table->addJoin("companies","c","company_id","company_id","u","left");
            $this->table->addJoin("users","w","user_id","webmarketter_id","","left");

            if($role_id==4)
            {
                $this->table->addWhere("contact_id", $user_id);
            }

            $res = (array)$this->table->search();
            $tab = array();
            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, ' no campains found');
            }
            foreach($res as $k=>$v){
                foreach($v as $k2=>$v2){
                    if(!(strpos($k2,"user")===false)){
                        $tab[$k]['campain_contact'][$k2]=$v2;
                    } elseif(!(strpos($k2,"company")===false)){
                        $tab[$k]['campain_company'][$k2]=$v2;
                    } elseif(!(strpos($k2,"webmarketter")===false)){
                        $tab[$k]['campain_webmarketter'][$k2]=$v2;
                    } elseif(in_array($k2,$this->campain_vars)) {
                        $tab[$k][$k2] = $v2;
                    }
                }
                if($tab[$k]['campain_company']['company_id']!=null){
                    $tab[$k]['campain_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab[$k]['campain_company']['company_id'];
                }
                if($tab[$k]['campain_contact']['user_id']!=null){
                    $tab[$k]['campain_contact']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['campain_contact']['user_id'];
                }
                if($tab[$k]['campain_webmarketter']['webmarketter_id']!=null){
                    $tab[$k]['campain_webmarketter']['webmarketter_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['campain_webmarketter']['webmarketter_id'];
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
     * Ajoute une campagne
     * @param array $data
     * @return object
     */
    public function post_campain($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou un webmarketteur il peut publier une campagne pour société
        if($role_id==1 || $role_id==2)
        {
            $campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
            $campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
            $campain_prix = (empty ($data['campain_prix']))?null:$data['campain_prix'];
            $company_id = (empty ($data['company_id']))?null:$data['company_id'];
            $webmarketter_id = $user_id;
            $campain_completion = (empty ($data['campain_completion']))?null:$data['campain_completion'];

            // Tests des variables

            if($campain_name==null){return $this->setApiResult(false, true, 'param \'campain_name\' undefined');}
            if($campain_description==null){return $this->setApiResult(false, true, 'param \'campain_description\' undefined');}
            if($campain_prix==null){return $this->setApiResult(false, true, 'param \'campain_prix\' undefined');}
            if(!is_numeric($campain_prix)){return $this->setApiResult(false, true, 'param \'campain_prix\' must be numeric');}
            if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
            if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' must be numeric');}
            if($webmarketter_id==null){return $this->setApiResult(false, true, 'param \'webmarketter_id\' undefined');}
            if(!is_numeric($webmarketter_id)){return $this->setApiResult(false, true, 'param \'webmarketter_id\' must be numeric');}
            if($campain_completion==null){return $this->setApiResult(false, true, 'param \'campain_completion\' undefined');}

            // Préparation de la requete
            $this->table->addNewField("campain_name",$campain_name);
            $this->table->addNewField("campain_description",$campain_description);
            $this->table->addNewField("campain_prix",$campain_prix);
            $this->table->addNewField("company_id",$company_id);
            $this->table->addNewField("webmarketter_id",$webmarketter_id);
            $this->table->addNewField("campain_completion",$campain_completion);

            $insert = $this->table->insert();
            if($insert!="ok"){
                return $this->setApiResult(false, true, $insert);
            }
            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }

    /**
     * Modifie une campagne
     * @param array $data
     * @return object
     */
    public function put_campain($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou un webmarketteur il peut publier une campagne pour société
        if($role_id==1 || $role_id==2)
        {
            // Récupération des parametres utiles
            $campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
            $campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
            $campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
            $campain_prix = (empty ($data['campain_prix']))?null:$data['campain_prix'];
            $company_id = (empty ($data['company_id']))?null:$data['company_id'];
            $campain_completion = (empty ($data['campain_completion']))?null:$data['campain_completion'];

            // Tests des variables
            if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
            if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' must be numeric');}
            if($campain_name==null){return $this->setApiResult(false, true, 'param \'campain_name\' undefined');}
            if($campain_description==null){return $this->setApiResult(false, true, 'param \'campain_description\' undefined');}
            if($campain_prix==null){return $this->setApiResult(false, true, 'param \'campain_prix\' undefined');}
            if(!is_numeric($campain_prix)){return $this->setApiResult(false, true, 'param \'campain_prix\' must be numeric');}
            if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
            if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' must be numeric');}
            if($campain_completion==null){return $this->setApiResult(false, true, 'param \'campain_completion\' undefined');}

            // Préparation de la requete
            $this->table->addNewField("campain_name",$campain_name);
            $this->table->addNewField("campain_description",$campain_description);
            $this->table->addNewField("campain_prix",$campain_prix);
            $this->table->addNewField("company_id",$company_id);
            $this->table->addNewField("webmarketter_id",$webmarketter_id);
            $this->table->addNewField("campain_completion",$campain_completion);

            $this->table->addWhere("campain_id",$campain_id);
            $this->table->update();

            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
	
    /**
     * Supprime une campagne
     * @param array $data
     * @return object
     */
    public function delete_campain($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur il peut supprimer une campagne pour société
        if($role_id==1)
        {
            // Récupération des parametres utiles
            $campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];

            // Tests des variables
            if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
            if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' not numeric');}

            //------------- Test existance en base --------------------------------------------//
            $exist_campain = $this->get_campain(array("campain_id"=>$campain_id));
            if($exist_campain->apiError==true){ return $this->setApiResult(false,true,'campain doesn\'t look existt'); }
            $this->table->addWhere("campain_id",$campain_id);
            $this->table->delete();
            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
}