<?php
class Application_Controllers_Campains extends Library_Core_Controllers{
    private $campainsTable;
	private $as;
	
	private $campain_vars = array('campain_id',
					   		      'campain_name',
							      'campain_description',
							      'campain_prix',
							      'company_id',
							      'campain_completion',
					   		      'campain_date');
	
	public function __construct(){
        global $iDB;
        $this->campainsTable = new Application_Models_Campains($iDB->getConnexion());
		$as = $this->campainsTable->getAlias();
	}
	
	public function get_campain($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses campain OU webmarketeur OU admin
		
        $campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
        if($campain_id==null){return $this->setApiResult(false, true, 'param \'campain_id\' undefined');}
        if(!is_numeric($campain_id)){return $this->setApiResult(false, true, 'param \'campain_id\' is not numeric');}
		
		// Selectionner tous les champs de la table campains
		$this->campainsTable->addField("*");
		// Selectionner tous les champs de la table users pour le client
		$this->campainsTable->addField("*","u");
		// Selectionner tous les champs de la table companies pour le client
		$this->campainsTable->addField("*","c");
		// Selectionner tous les champs de la table users pour le webmarketter
		$this->campainsTable->addField("user_id","w","webmarketter_id");
		$this->campainsTable->addField("user_name","w","webmarketter_name");
		$this->campainsTable->addField("user_firstname","w","webmarketter_firstname");
		$this->campainsTable->addField("user_email","w","webmarketter_email");
		$this->campainsTable->addField("user_phone","w","webmarketter_phone");
		$this->campainsTable->addField("user_mobile","w","webmarketter_mobile");
		
		// Jointure
		$this->campainsTable->addJoin("users","u","user_id","contact_id","","left");
		$this->campainsTable->addJoin("companies","c","company_id","company_id","u","left");
		$this->campainsTable->addJoin("users","w","user_id","webmarketter_id","","left");
		
		// Condition
		$this->campainsTable->addWhere("campain_id",$campain_id);
        $res = (array)$this->campainsTable->search();
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
	
	public function get_allcampain_company($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses campain OU webmarketeur OU admin
		
		$company_id = (empty ($data['company_id']))?null:$data['company_id'];
        if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
        if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' is not numeric');}
		
		// Selectionner tous les champs de la table campains
		$this->campainsTable->addField("*");
		// Selectionner tous les champs de la table users pour le client
		$this->campainsTable->addField("*","u");
		// Selectionner tous les champs de la table companies pour le client
		$this->campainsTable->addField("*","c");
		// Selectionner tous les champs de la table users pour le webmarketter
		$this->campainsTable->addField("user_id","w","webmarketter_id");
		$this->campainsTable->addField("user_name","w","webmarketter_name");
		$this->campainsTable->addField("user_firstname","w","webmarketter_firstname");
		$this->campainsTable->addField("user_email","w","webmarketter_email");
		$this->campainsTable->addField("user_phone","w","webmarketter_phone");
		$this->campainsTable->addField("user_mobile","w","webmarketter_mobile");
		
		// Jointure
		$this->campainsTable->addJoin("users","u","user_id","contact_id","","left");
		$this->campainsTable->addJoin("companies","c","company_id","company_id","u","left");
		$this->campainsTable->addJoin("users","w","user_id","webmarketter_id","","left");
		$this->campainsTable->addWhere("company_id",$company_id,"c");
		$res = (array)$this->campainsTable->search();
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
	
	public function get_allcampain($data){
		//!!!Seulement l'admin a cette fonction A FAIRE
		
		// Selectionner tous les champs de la table campains
		$this->campainsTable->addField("*");
		// Selectionner tous les champs de la table users pour le client
		$this->campainsTable->addField("*","u");
		// Selectionner tous les champs de la table companies pour le client
		$this->campainsTable->addField("*","c");
		// Selectionner tous les champs de la table users pour le webmarketter
		$this->campainsTable->addField("user_id","w","webmarketter_id");
		$this->campainsTable->addField("user_name","w","webmarketter_name");
		$this->campainsTable->addField("user_firstname","w","webmarketter_firstname");
		$this->campainsTable->addField("user_email","w","webmarketter_email");
		$this->campainsTable->addField("user_phone","w","webmarketter_phone");
		$this->campainsTable->addField("user_mobile","w","webmarketter_mobile");
		
		// Jointure
		$this->campainsTable->addJoin("users","u","user_id","contact_id","","left");
		$this->campainsTable->addJoin("companies","c","company_id","company_id","u","left");
		$this->campainsTable->addJoin("users","w","user_id","webmarketter_id","","left");
        $res = (array)$this->campainsTable->search();
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
	
	 public function post_campain($data){
		
		$add_campain_role = (empty ($data['add_campain_role']))?null:$data['add_campain_role'];
        if($add_campain_role==null){return $this->setApiResult(false, true, 'param \'add_campain_role\' undefined');}
		
		switch($add_campain_role){
			// On récupere l'id du role, si c'est un administrateur ou webmarketeur, il peut ajouter un campain effectué sinon non autorisation
			case "1":case "2":
				// Récupération des parametres utiles
				
				$campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
				$campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
				$campain_prix = (empty ($data['campain_prix']))?null:$data['campain_prix'];
				$company_id = (empty ($data['company_id']))?null:$data['company_id'];
				$webmarketter_id = (empty ($data['webmarketter_id']))?null:$data['webmarketter_id'];
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
				$this->campainsTable->addNewField("campain_name",$campain_name);
				$this->campainsTable->addNewField("campain_description",$campain_description);
				$this->campainsTable->addNewField("campain_prix",$campain_prix);
				$this->campainsTable->addNewField("company_id",$company_id);
				$this->campainsTable->addNewField("webmarketter_id",$webmarketter_id);
				$this->campainsTable->addNewField("campain_completion",$campain_completion);
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
			// On récupere l'id du role, si c'est un administrateur ou webmarketeur, il peut ajouter un campain effectué sinon non autorisation
			case "1":case "2":
				// Récupération des parametres utiles
				$campain_id = (empty ($data['campain_id']))?null:$data['campain_id'];
				$campain_name = (empty ($data['campain_name']))?null:$data['campain_name'];
				$campain_description = (empty ($data['campain_description']))?null:$data['campain_description'];
				$campain_prix = (empty ($data['campain_prix']))?null:$data['campain_prix'];
				$company_id = (empty ($data['company_id']))?null:$data['company_id'];
				$webmarketter_id = (empty ($data['webmarketter_id']))?null:$data['webmarketter_id'];
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
				if($webmarketter_id==null){return $this->setApiResult(false, true, 'param \'webmarketter_id\' undefined');}
				if(!is_numeric($webmarketter_id)){return $this->setApiResult(false, true, 'param \'webmarketter_id\' must be numeric');}
				if($campain_completion==null){return $this->setApiResult(false, true, 'param \'campain_completion\' undefined');}
				
				// Préparation de la requete
				$this->campainsTable->addNewField("campain_name",$campain_name);
				$this->campainsTable->addNewField("campain_description",$campain_description);
				$this->campainsTable->addNewField("campain_prix",$campain_prix);
				$this->campainsTable->addNewField("company_id",$company_id);
				$this->campainsTable->addNewField("webmarketter_id",$webmarketter_id);
				$this->campainsTable->addNewField("campain_completion",$campain_completion);
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