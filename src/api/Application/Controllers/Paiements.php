<?php
/**
 * La classe Application_Controllers_Paiements effectue tous les contôles des données liées aux paiements
 * Cette classe fait appel à Application_Models_Paiements pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Paiements extends Library_Core_Controllers{
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
    private $paiement_vars = array('paiement_id',
                                    'paiement_name',
                                    'paiement_description',
                                    'paiement_prix',
                                    'user_id',
                                    'paiement_link',
                                    'paiement_date');
	
    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Paiements($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
	
    /**
     * Récupère une facture en fonction de son id
     * Récupère les détails du client lié
     * @param array $data
     * @return object
     */
    public function get_paiement($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupère le paiement et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses paiemets
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {
            $paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];
            if($paiement_id==null){return $this->setApiResult(false, true, 'param \'paiement_id\' undefined');}
            if(!is_numeric($paiement_id)){return $this->setApiResult(false, true, 'param \'paiement_id\' is not numeric');}
            $this->table->addJoin("users","u","user_id","user_id","","left");
            $this->table->addWhere("paiement_id",$paiement_id);
            //Si un membre veut recupérer un paiement, on vérifie que celui-ci lui appartienne sinon le paiement sera "not found"
            if($role_id==3){$this->table->addWhere("user_id",$user_id);}

            $res = (array)$this->table->search();
            $tab = array();

            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, 'paiement not found');
            }

            foreach($res[0] as $k=>$v){
                if(!(strpos($k,"user")===false)){
                    $tab['paiement_user'][$k]=$v;
                } elseif(in_array($k,$this->paiement_vars)) {
                    $tab[$k] = $v;
                }
            }

            if($tab['paiement_user']['user_id']!=null)
            {
                $tab['paiement_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['paiement_user']['user_id'];
            }
            return $this->setApiResult($tab);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }  
    }
	
    /**
     * Récupère toutes les factures
     * Récupère les détails des clients liés
     * @param array $data
     * @return object
     */	
    public function get_allpaiement($data){
        //!!!Seulement l'admin a cette fonction
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
         if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si admin alors ou webmarketeur ou client ok
        if($role_id==1 || $role_id==2 || $role_id==4)
        {
			//Si c'est un admin ou webmarketeur qui accéde aux dossier du client, il devra renseigne l'id du client ou prospect
            if($role_id!=4)
            {
                $user_id = (empty ($data['user_id']))?null:$data['user_id'];
            }
			//Sinon cest un client ou prospect, il récupére que ses campagnes le concernant
			else
			{
				$user_id = $user_id_connecte;
			}
            $this->table->addJoin("users","u","user_id","user_id","","left");
            $this->table->addWhere("user_id", $user_id);
            $res = (array)$this->table->search();

            $tab = array();
            if(!array_key_exists(0,$res)){
                    return $this->setApiResult(false, true, ' no paiements found');
            }
            foreach($res as $k=>$v){
                foreach($v as $k2=>$v2){
                    if(!(strpos($k2,"user")===false)){
                        $tab[$k]['paiement_user'][$k2]=$v2;
                    } elseif(in_array($k2,$this->paiement_vars)) {
                        $tab[$k][$k2] = $v2;
                    }
                }
                if($tab[$k]['paiement_user']['user_id']!=null){
                    $tab[$k]['paiement_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['paiement_user']['user_id'];
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
     * Récupère toutes les factures d'un client
     * Récupère les détails du clients lié
     * @param array $data
     * @return object
     */	
    public function get_allpaiement_user($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupère les paiements et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses paiements
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {
            //Si c'est un admin ou webmarketeur  qui accède aux paiements du client, il devra renseigne l'id du client
            if($role!=3)
            {
                $user_id = (empty ($data['user_id']))?null:$data['user_id'];
                if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
                if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
            }

            $this->table->addWhere("user_id",$user_id);
            $res = (array)$this->table->search();

            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, ' no paiements found');
            }

            return $this->setApiResult($res);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
	
    /**
     * Ajoute une facture
     * @param array $data
     * @return object
     */	
    public function post_paiement($data){
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un admin ou un webmarketteur il peut alors poster un paiement.
        if($role_id==1 || $role_id==2)
        {
            // Récupération des parametres utiles
            $user_id = (empty ($data['user_id']))?null:$data['user_id'];
            $paiement_name = (empty ($data['paiement_name']))?null:$data['paiement_name'];
            $paiement_description = (empty ($data['paiement_description']))?null:$data['paiement_description'];
            $paiement_prix = (empty ($data['paiement_prix']))?null:$data['paiement_prix'];
            $paiement_link = (empty ($data['paiement_link']))?null:$data['paiement_link'];
            $paiement_auteur = $user_id_connecte;

            // Tests des variables
            if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
            if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}
            if($paiement_name==null){return $this->setApiResult(false, true, 'param \'paiement_name\' undefined');}
            if($paiement_description==null){return $this->setApiResult(false, true, 'param \'paiement_description\' undefined');}
            if($paiement_prix==null){return $this->setApiResult(false, true, 'param \'paiement_prix\' undefined');}
            if(!is_numeric($paiement_prix)){return $this->setApiResult(false, true, 'param \'paiement_prix\' must be numeric');}
            if($paiement_link==null){return $this->setApiResult(false, true, 'param \'paiement_link\' undefined');}

            // Préparation de la requete
            $this->table->addNewField("paiement_name",$paiement_name);
            $this->table->addNewField("paiement_description",$paiement_description);
            $this->table->addNewField("paiement_prix",$paiement_prix);
            $this->table->addNewField("paiement_link",$paiement_link);
            $this->table->addNewField("paiement_auteur",$paiement_auteur);
            $this->table->addNewField("user_id",$user_id);	

            $insert = $this->table->insert();
            if($insert!="ok"){
                return $this->setApiResult(false, true, $insert);
            }
            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'No authorization to access to this page');
        }
    }

    /**
     * Modifie une facture
     * @param array $data
     * @return object
     */	
    public function put_paiement($data){
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un admin lui seul peut modifier un paiement.
        if($role_id==1)
        {
            // Récupération des parametres utiles
            $paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];
            $paiement_name = (empty ($data['paiement_name']))?null:$data['paiement_name'];
            $paiement_description = (empty ($data['paiement_description']))?null:$data['paiement_description'];

            $paiement_prix = (empty ($data['paiement_prix']))?null:$data['paiement_prix'];
            $paiement_link = (empty ($data['paiement_link']))?null:$data['paiement_link'];

            // Tests des variables
            if($paiement_id==null){return $this->setApiResult(false, true, 'param \'paiement_id\' undefined');}
            if(!is_numeric($paiement_id)){return $this->setApiResult(false, true, 'param \'paiement_id\' must be numeric');}
            if($paiement_name==null){return $this->setApiResult(false, true, 'param \'paiement_name\' undefined');}
            if($paiement_description==null){return $this->setApiResult(false, true, 'param \'paiement_description\' undefined');}
            if($paiement_prix==null){return $this->setApiResult(false, true, 'param \'paiement_prix\' undefined');}
            if(!is_numeric($paiement_prix)){return $this->setApiResult(false, true, 'param \'paiement_prix\' must be numeric');}
            if($paiement_link==null){return $this->setApiResult(false, true, 'param \'paiement_link\' undefined');}

            // Préparation de la requete
            $this->table->addNewField("paiement_name",$paiement_name);
            $this->table->addNewField("paiement_description",$paiement_description);
            $this->table->addNewField("paiement_prix",$paiement_prix);
            $this->table->addNewField("paiement_link",$paiement_link);	

            $this->table->addWhere("paiement_id",$paiement_id);
            $this->table->update();

            return $this->setApiResult(true);	
        }
        else
        {
            return $this->setApiResult(false, true, 'No authorization to access to this page');
        }
    }
	
    /**
     * Supprime une facture
     * @param array $data
     * @return object
     */	
    public function delete_paiement($data){
        // SEUL L'ADMIN POURRA SUPPRIMER UN PAIEMENT
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un admin lui seul peut supprimer un paiement.
        if($role_id==1)
        {
            // Récupération des parametres utiles
            $paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];

            // Tests des variables
            if($paiement_id==null){return $this->setApiResult(false, true, 'param \'paiement_id\' undefined');}
            if(!is_numeric($paiement_id)){return $this->setApiResult(false, true, 'param \'paiement_id\' not numeric');}

            //------------- Test existance en base --------------------------------------------//
            $exist_paiement = $this->get_paiement(array("paiement_id"=>$paiement_id));
            if($exist_paiement->apiError==true){ return $this->setApiResult(false,true,'paiement doesn\'t look existt'); }
            $this->table->addWhere("paiement_id",$paiement_id);
            $this->table->delete();
            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'No authorization to access to this page');
        }
    }
}