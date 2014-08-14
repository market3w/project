<?php
class Application_Controllers_Campains extends Library_Core_Controllers{
    private $campainsTable;
	private $as;
	
	private $campain_vars = array('campain_id',
					   		   'campain_name',
							   'campain_description',
							   'campain_prix',
							    'company_id',
								'webmarketter_id',
							    'campain_completion',
					   		   'campain_date');
	
	public function __construct(){
        global $iDB;
        $this->campainsTable = new Application_Models_campains($iDB->getConnexion());
		$as = $this->campainsTable->getAlias();
	}
	
	public function get_campain($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses campain OU webmarketeur OU admin
		
          $campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
        if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
        if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' is not numeric');}
		$this->campainsTable->addJoin("companies","c","company_id","company_id","","left");
		$this->campainsTable->addWhere("campain_id",$campain_id);
        $res = (array)$this->campainsTable->search();
		$tab = array();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'campain not found');
		}
		
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"company")===false)){
				$tab['campain_company'][$k]=$v;
			} elseif(in_array($k,$this->campain_vars)) {
				$tab[$k] = $v;
			}
		}
		
		if($tab['campain_company']['company_id']!=null)
		{
			$tab['campain_company']['company_url']=API_ROOT."?method=company&company_id=".(int)$tab['campain_company']['company_id'];
		}
		return $this->setApiResult($tab);
	}
	
	public function get_allcampain_user($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses campain OU webmarketeur OU admin
		
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->campainsTable->addWhere("user_id",$user_id);
		$res = (array)$this->campainsTable->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no campains found');
		}
	
        return $this->setApiResult($res);
	}
	
	 public function post_campain($data){
		
		$add_campain_role = (empty ($data['add_campain_role']))?null:$data['add_campain_role'];
        if($add_campain_role==null){return $this->setApiResult(false, true, 'param \'add_campain_role\' undefined');}
		
		switch($add_campain_role){
			// On récupere l'id du role, si c'est un administrateur ou webmarketeur, il peut ajouter un campain effectué sinon non autorisation
			case "1":case "2":
				// Récupération des parametres utiles
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
				$campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
				$campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
				$campain_prix = (empty ($data['campain_prix']))?null:$data['campain_prix'];
				$campain_link = (empty ($data['campain_link']))?null:$data['campain_link'];
				
				// Tests des variables
				if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
				if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}
				if($campain_name==null){return $this->setApiResult(false, true, 'param \'campain_name\' undefined');}
				if($campain_description==null){return $this->setApiResult(false, true, 'param \'campain_description\' undefined');}
				if($campain_prix==null){return $this->setApiResult(false, true, 'param \'campain_prix\' undefined');}
				if(!is_numeric($campain_prix)){return $this->setApiResult(false, true, 'param \'campain_prix\' must be numeric');}
				if($campain_link==null){return $this->setApiResult(false, true, 'param \'campain_link\' undefined');}
				
				// Préparation de la requete
				$this->campainsTable->addNewField("campain_name",$campain_name);
				$this->campainsTable->addNewField("campain_description",$campain_description);
				$this->campainsTable->addNewField("campain_prix",$campain_prix);
				$this->campainsTable->addNewField("campain_link",$campain_link);
				$this->campainsTable->addNewField("user_id",$user_id);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $insert = $this->campainsTable->insert();
		if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }

 public function put_campain($data){
		
		$put_campain_role = (empty ($data['put_campain_role']))?null:$data['put_campain_role'];
        if($put_campain_role==null){return $this->setApiResult(false, true, 'param \'put_campain_role\' undefined');}
		
		switch($put_campain_role){
			// On récupere l'id du role, si c'est un administrateur il peut modifier un campain effectué sinon non autorisation
			case "1":
				// Récupération des parametres utiles
				$campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
				$campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
				$campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
					
				$campain_prix = (empty ($data['campain_prix']))?null:$data['campain_prix'];
				$campain_link = (empty ($data['campain_link']))?null:$data['campain_link'];
				
				// Tests des variables
				if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
				if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' must be numeric');}
				if($campain_name==null){return $this->setApiResult(false, true, 'param \'campain_name\' undefined');}
				if($campain_description==null){return $this->setApiResult(false, true, 'param \'campain_description\' undefined');}
				if($campain_prix==null){return $this->setApiResult(false, true, 'param \'campain_prix\' undefined');}
				if(!is_numeric($campain_prix)){return $this->setApiResult(false, true, 'param \'campain_prix\' must be numeric');}
				if($campain_link==null){return $this->setApiResult(false, true, 'param \'campain_link\' undefined');}
				
				// Préparation de la requete
				$this->campainsTable->addNewField("campain_name",$campain_name);
				$this->campainsTable->addNewField("campain_description",$campain_description);
				$this->campainsTable->addNewField("campain_prix",$campain_prix);
				$this->campainsTable->addNewField("campain_link",$campain_link);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $this->campainsTable->addWhere("campain_id",$campain_id);
		$this->campainsTable->update();
	
        return $this->setApiResult(true);
    }
	
	 public function delete_campain($data){
		 // SEUL L'ADMIN POURRA SUPPRIMER UN campain
		 
		// Récupération des parametres utiles
		$campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
				
		// Tests des variables
		if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
		if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' not numeric');}
		
		//------------- Test existance en base --------------------------------------------//
		$exist_campain = $this->get_campain(array("campain_id"=>$campain_id));
        if($exist_campain->apiError==true){ return $this->setApiResult(false,true,'campain doesn\'t look existt'); }
		$this->campainsTable->addWhere("campain_id",$campain_id);
        $this->campainsTable->delete();
        return $this->setApiResult(true);
    }

 
}