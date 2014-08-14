<?php
class Application_Controllers_Paiements extends Library_Core_Controllers{
    private $paiementsTable;
	private $as;
	
	private $paiement_vars = array('paiement_id',
					   		   'paiement_name',
							   'paiement_description',
							   'paiement_prix',
							    'paiement_link',
					   		   'paiement_date',
							   'user_id');
	
	public function __construct(){
        global $iDB;
        $this->paiementsTable = new Application_Models_Paiements($iDB->getConnexion());
		$as = $this->paiementsTable->getAlias();
	}
	
	public function get_paiement($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses paiement OU webmarketeur OU admin
		
        $paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];
        if($paiement_id==null){return $this->setApiResult(false, true, 'param \'paiement_id\' undefined');}
        if(!is_numeric($paiement_id)){return $this->setApiResult(false, true, 'param \'paiement_id\' is not numeric');}
		$this->paiementsTable->addJoin("users","u","user_id","user_id","","left");
		$this->paiementsTable->addWhere("paiement_id",$paiement_id);
        $res = (array)$this->paiementsTable->search();
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
		
	public function get_allpaiement($data){
		//!!!Seulement l'admin a cette fonction A FAIRE
		
		$this->paiementsTable->addJoin("users","u","user_id","user_id","","left");
        $res = (array)$this->paiementsTable->search();
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
	
	public function get_allpaiement_user($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses paiement OU webmarketeur OU admin
		
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->paiementsTable->addWhere("user_id",$user_id);
		$res = (array)$this->paiementsTable->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no paiements found');
		}
	
        return $this->setApiResult($res);
	}
	
	 public function post_paiement($data){
		
		$add_paiement_role = (empty ($data['add_paiement_role']))?null:$data['add_paiement_role'];
        if($add_paiement_role==null){return $this->setApiResult(false, true, 'param \'add_paiement_role\' undefined');}
		
		switch($add_paiement_role){
			// On récupere l'id du role, si c'est un administrateur ou webmarketeur, il peut ajouter un paiement effectué sinon non autorisation
			case "1":case "2":
				// Récupération des parametres utiles
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
				$paiement_name = (empty ($data['paiement_name']))?null:$data['paiement_name'];
				$paiement_description = (empty ($data['paiement_description']))?null:$data['paiement_description'];
				$paiement_prix = (empty ($data['paiement_prix']))?null:$data['paiement_prix'];
				$paiement_link = (empty ($data['paiement_link']))?null:$data['paiement_link'];
				
				// Tests des variables
				if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
				if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}
				if($paiement_name==null){return $this->setApiResult(false, true, 'param \'paiement_name\' undefined');}
				if($paiement_description==null){return $this->setApiResult(false, true, 'param \'paiement_description\' undefined');}
				if($paiement_prix==null){return $this->setApiResult(false, true, 'param \'paiement_prix\' undefined');}
				if(!is_numeric($paiement_prix)){return $this->setApiResult(false, true, 'param \'paiement_prix\' must be numeric');}
				if($paiement_link==null){return $this->setApiResult(false, true, 'param \'paiement_link\' undefined');}
				
				// Préparation de la requete
				$this->paiementsTable->addNewField("paiement_name",$paiement_name);
				$this->paiementsTable->addNewField("paiement_description",$paiement_description);
				$this->paiementsTable->addNewField("paiement_prix",$paiement_prix);
				$this->paiementsTable->addNewField("paiement_link",$paiement_link);
				$this->paiementsTable->addNewField("user_id",$user_id);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $insert = $this->paiementsTable->insert();
		if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }

 public function put_paiement($data){
		
		$put_paiement_role = (empty ($data['put_paiement_role']))?null:$data['put_paiement_role'];
        if($put_paiement_role==null){return $this->setApiResult(false, true, 'param \'put_paiement_role\' undefined');}
		
		switch($put_paiement_role){
			// On récupere l'id du role, si c'est un administrateur il peut modifier un paiement effectué sinon non autorisation
			case "1":
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
				$this->paiementsTable->addNewField("paiement_name",$paiement_name);
				$this->paiementsTable->addNewField("paiement_description",$paiement_description);
				$this->paiementsTable->addNewField("paiement_prix",$paiement_prix);
				$this->paiementsTable->addNewField("paiement_link",$paiement_link);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $this->paiementsTable->addWhere("paiement_id",$paiement_id);
		$this->paiementsTable->update();
	
        return $this->setApiResult(true);
    }
	
	 public function delete_paiement($data){
		 // SEUL L'ADMIN POURRA SUPPRIMER UN PAIEMENT
		 
		// Récupération des parametres utiles
		$paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];
				
		// Tests des variables
		if($paiement_id==null){return $this->setApiResult(false, true, 'param \'paiement_id\' undefined');}
		if(!is_numeric($paiement_id)){return $this->setApiResult(false, true, 'param \'paiement_id\' not numeric');}
		
		//------------- Test existance en base --------------------------------------------//
		$exist_paiement = $this->get_paiement(array("paiement_id"=>$paiement_id));
        if($exist_paiement->apiError==true){ return $this->setApiResult(false,true,'paiement doesn\'t look existt'); }
		$this->paiementsTable->addWhere("paiement_id",$paiement_id);
        $this->paiementsTable->delete();
        return $this->setApiResult(true);
    }

 
}