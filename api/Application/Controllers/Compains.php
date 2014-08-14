<?php
class Application_Controllers_Compains extends Library_Core_Controllers{
    private $compainsTable;
	private $as;
	
	private $compain_vars = array('compain_id',
					   		   'compain_name',
							   'compain_description',
							   'compain_prix',
							    'company_id',
								'webmarketter_id',
							    'compain_link',
					   		   'compain_date',
							   'user_id');
	
	public function __construct(){
        global $iDB;
        $this->compainsTable = new Application_Models_compains($iDB->getConnexion());
		$as = $this->compainsTable->getAlias();
	}
	
	public function get_compain($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses compain OU webmarketeur OU admin
		
        $compain_id = (empty ($data['compain_id']))?null:$data['compain_id'];
        if($compain_id==null){return $this->setApiResult(false, true, 'param \'compain_id\' undefined');}
        if(!is_numeric($compain_id)){return $this->setApiResult(false, true, 'param \'compain_id\' is not numeric');}
		$this->compainsTable->addJoin("users","u","user_id","user_id","","left");
		$this->compainsTable->addWhere("compain_id",$compain_id);
        $res = (array)$this->compainsTable->search();
		$tab = array();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'compain not found');
		}
		
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"user")===false)){
				$tab['compain_user'][$k]=$v;
			} elseif(in_array($k,$this->compain_vars)) {
				$tab[$k] = $v;
			}
		}
		
		if($tab['compain_user']['user_id']!=null)
		{
			$tab['compain_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['compain_user']['user_id'];
		}
		return $this->setApiResult($tab);
	}
		
	public function get_allcompain($data){
		//!!!Seulement l'admin a cette fonction A FAIRE
		
		$this->compainsTable->addJoin("users","u","user_id","user_id","","left");
        $res = (array)$this->compainsTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no compains found');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"user")===false)){
					$tab[$k]['compain_user'][$k2]=$v2;
				} elseif(in_array($k2,$this->compain_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
			if($tab[$k]['compain_user']['user_id']!=null){
				$tab[$k]['compain_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['compain_user']['user_id'];
			}
		}
        return $this->setApiResult($tab);
	}
	
	public function get_allcompain_user($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses compain OU webmarketeur OU admin
		
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->compainsTable->addWhere("user_id",$user_id);
		$res = (array)$this->compainsTable->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no compains found');
		}
	
        return $this->setApiResult($res);
	}
	
	 public function post_compain($data){
		
		$add_compain_role = (empty ($data['add_compain_role']))?null:$data['add_compain_role'];
        if($add_compain_role==null){return $this->setApiResult(false, true, 'param \'add_compain_role\' undefined');}
		
		switch($add_compain_role){
			// On récupere l'id du role, si c'est un administrateur ou webmarketeur, il peut ajouter un compain effectué sinon non autorisation
			case "1":case "2":
				// Récupération des parametres utiles
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
				$compain_name = (empty ($data['compain_name']))?null:$data['compain_name'];
				$compain_description = (empty ($data['compain_description']))?null:$data['compain_description'];
				$compain_prix = (empty ($data['compain_prix']))?null:$data['compain_prix'];
				$compain_link = (empty ($data['compain_link']))?null:$data['compain_link'];
				
				// Tests des variables
				if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
				if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}
				if($compain_name==null){return $this->setApiResult(false, true, 'param \'compain_name\' undefined');}
				if($compain_description==null){return $this->setApiResult(false, true, 'param \'compain_description\' undefined');}
				if($compain_prix==null){return $this->setApiResult(false, true, 'param \'compain_prix\' undefined');}
				if(!is_numeric($compain_prix)){return $this->setApiResult(false, true, 'param \'compain_prix\' must be numeric');}
				if($compain_link==null){return $this->setApiResult(false, true, 'param \'compain_link\' undefined');}
				
				// Préparation de la requete
				$this->compainsTable->addNewField("compain_name",$compain_name);
				$this->compainsTable->addNewField("compain_description",$compain_description);
				$this->compainsTable->addNewField("compain_prix",$compain_prix);
				$this->compainsTable->addNewField("compain_link",$compain_link);
				$this->compainsTable->addNewField("user_id",$user_id);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $insert = $this->compainsTable->insert();
		if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }

 public function put_compain($data){
		
		$put_compain_role = (empty ($data['put_compain_role']))?null:$data['put_compain_role'];
        if($put_compain_role==null){return $this->setApiResult(false, true, 'param \'put_compain_role\' undefined');}
		
		switch($put_compain_role){
			// On récupere l'id du role, si c'est un administrateur il peut modifier un compain effectué sinon non autorisation
			case "1":
				// Récupération des parametres utiles
				$compain_id = (empty ($data['compain_id']))?null:$data['compain_id'];
				$compain_name = (empty ($data['compain_name']))?null:$data['compain_name'];
				$compain_description = (empty ($data['compain_description']))?null:$data['compain_description'];
					
				$compain_prix = (empty ($data['compain_prix']))?null:$data['compain_prix'];
				$compain_link = (empty ($data['compain_link']))?null:$data['compain_link'];
				
				// Tests des variables
				if($compain_id==null){return $this->setApiResult(false, true, 'param \'compain_id\' undefined');}
				if(!is_numeric($compain_id)){return $this->setApiResult(false, true, 'param \'compain_id\' must be numeric');}
				if($compain_name==null){return $this->setApiResult(false, true, 'param \'compain_name\' undefined');}
				if($compain_description==null){return $this->setApiResult(false, true, 'param \'compain_description\' undefined');}
				if($compain_prix==null){return $this->setApiResult(false, true, 'param \'compain_prix\' undefined');}
				if(!is_numeric($compain_prix)){return $this->setApiResult(false, true, 'param \'compain_prix\' must be numeric');}
				if($compain_link==null){return $this->setApiResult(false, true, 'param \'compain_link\' undefined');}
				
				// Préparation de la requete
				$this->compainsTable->addNewField("compain_name",$compain_name);
				$this->compainsTable->addNewField("compain_description",$compain_description);
				$this->compainsTable->addNewField("compain_prix",$compain_prix);
				$this->compainsTable->addNewField("compain_link",$compain_link);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $this->compainsTable->addWhere("compain_id",$compain_id);
		$this->compainsTable->update();
	
        return $this->setApiResult(true);
    }
	
	 public function delete_compain($data){
		 // SEUL L'ADMIN POURRA SUPPRIMER UN compain
		 
		// Récupération des parametres utiles
		$compain_id = (empty ($data['compain_id']))?null:$data['compain_id'];
				
		// Tests des variables
		if($compain_id==null){return $this->setApiResult(false, true, 'param \'compain_id\' undefined');}
		if(!is_numeric($compain_id)){return $this->setApiResult(false, true, 'param \'compain_id\' not numeric');}
		
		//------------- Test existance en base --------------------------------------------//
		$exist_compain = $this->get_compain(array("compain_id"=>$compain_id));
        if($exist_compain->apiError==true){ return $this->setApiResult(false,true,'compain doesn\'t look existt'); }
		$this->compainsTable->addWhere("compain_id",$compain_id);
        $this->compainsTable->delete();
        return $this->setApiResult(true);
    }

 
}