<?php
class Application_Controllers_Companies extends Library_Core_Controllers{
    private $companyTable;
	private $as;
	//test
	
	private $company_id;
	private $company_siret;
	private $company_siren;
	private $company_name;
	private $company_adress;
	private $company_adress2;
	private $company_zipcode;
	private $company_town;
	private $company_nb_employees;
	
	public function __construct(){
        global $iDB;
        $this->companyTable = new Application_Models_Companies($iDB->getConnexion());
		$as = $this->companyTable->getAlias();
	
	}
	
	public function get_company($data){
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
        if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
        if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' is not numeric');}
		$this->companyTable->addWhere("company_id",$company_id);
        $res = (array)$this->companyTable->search();
        return $this->setApiResult($res);
    }
	
	public function get_currentcompany($data){
        $company_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($company_id==null){return $this->setApiResult(false, true, 'You are not logged');}
		// Jointure
		$this->companyTable->addJoin("users","u","company_id","company_id"); 
		// Condition
		$this->companyTable->addWhere("user_id",$_SESSION['market3w_user_id'],"u");
        $res = (array)$this->companyTable->search();
		if(empty($res)){
			return $this->setApiResult(false, true, 'Company not found');
		}
        return $this->setApiResult($res);
    }
    
    public function get_allcompany($data){
        $res = (array)$this->companyTable->search();
        return $this->setApiResult($res);
    }
    
    public function post_company($data){
		 $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'You are not logged');}
		
		$post = true;
		$add_company_role = (empty ($data['add_company_role']))?null:$data['add_company_role'];
        if($add_company_role==null){return $this->setApiResult(false, true, 'param \'add_company_role\' undefined');}
		
		switch($add_company_role){
			//Administrateur, peut poster une compagnie autant qu'il veut
			case "administrateur": case "webmarketteur":
			
				
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
					$this->companyTable->addNewField("company_siret",$company_siret);
					$this->companyTable->addNewField("company_siren",$company_siren);
					$this->companyTable->addNewField("company_name",$company_name);
					$this->companyTable->addNewField("company_adress",$company_adress);
					$this->companyTable->addNewField("company_adress2",$company_adress2);
					$this->companyTable->addNewField("company_zipcode",$company_zipcode);
					$this->companyTable->addNewField("company_town",$company_town);
					$this->companyTable->addNewField("company_nb_employees",$company_nb_employees);
				
				
				
			break;
			// Cas pour prendre des RDV
			case "client": case "prospet":
				
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
					$this->companyTable->addNewField("company_siret",$company_siret);
					$this->companyTable->addNewField("company_siren",$company_siren);
					$this->companyTable->addNewField("company_name",$company_name);
					$this->companyTable->addNewField("company_adress",$company_adress);
					$this->companyTable->addNewField("company_adress2",$company_adress2);
					$this->companyTable->addNewField("company_zipcode",$company_zipcode);
					$this->companyTable->addNewField("company_town",$company_town);
					$this->companyTable->addNewField("company_nb_employees",$company_nb_employees);
			
				
			break;
			default:
				return $this->setApiResult(false, true, 'param \'add_company_role\' value is different to "marketeur", "client"');
				break;
		}
					
		if($post===true){
        	$insert = $this->companyTable->insert();
		} else {
		}
		
        if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
    
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
		
		//------------- Test existance en base --------------------------------------------//
		$exist_company = $this->get_company(array("company_id"=>$company_id));
        if($exist_company->apiError==true){ return $this->setApiResult(false,true,$exist_company->apiErrorMessage); }
        $update = array();
		
		//------------- Test et ajout des champs ------------------------------------------//
       
		 if($company_siret!=null){
			$this->companyTable->addNewField("company_siret",$company_siret);
		} 
		
		 if($company_siren!=null){
			$this->companyTable->addNewField("company_siren",$company_siren);
		} 
		
		 if($company_name!=null){
			$this->companyTable->addNewField("company_name",$company_name);
		} 
		
		if($company_adress!=null){
			$this->companyTable->addNewField("company_adress",$company_adress);
		}
		if($company_adress2!=null){
			$this->companyTable->addNewField("company_adress2",$company_adress2);
		}
		if($company_zipcode!=null){
			$this->companyTable->addNewField("company_zipcode",$company_zipcode);
		}
		if($company_town!=null){
			$this->companyTable->addNewField("company_town",$company_town);
		}
		if($company_nb_employees!=null){
			$this->companyTable->addNewField("company_nb_employees",$company_nb_employees);
		}
		
        $this->companyTable->update();
        return $this->setApiResult(true);
    }
    
    public function delete_company($data){
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_company = $this->get_company(array("company_id"=>$company_id));
        if($exist_company->apiError==true){ return $this->setApiResult(false,true,$exist_company->apiErrorMessage); }
        $update = array();
		
        $this->companyTable->delete();
        return $this->setApiResult(true);
    }
}