<?php
class Application_Controllers_Companies extends Library_Core_Controllers{
    private $companysTable;
	private $as;
	
	private $company_name;
	
	public function __construct(){
        global $iDB;
        $this->companysTable = new Application_Models_Companies($iDB->getConnexion());
		$as = $this->companysTable->getAlias();
	}
	
	public function get_company($data){
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
        if($company_id==null){return $this->setApiResult(false, true, 'param \'company_id\' undefined');}
        if(!is_numeric($company_id)){return $this->setApiResult(false, true, 'param \'company_id\' is not numeric');}
		$this->companysTable->addWhere("company_id",$company_id);
        $res = (array)$this->companysTable->search();
        return $this->setApiResult($res);
    }
	
	public function get_currentcompany($data){
        $company_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($company_id==null){return $this->setApiResult(false, true, 'You are not logged');}
		// Jointure
		$this->companyTable->addJoin("users","u","company_id","company_id"); 
		// Condition
		$this->companyTable->addWhere("user_id",$_SESSION['market3w_user_id'],"u");
        $res = (array)$this->companysTable->search();
		if(empty($res)){
			return $this->setApiResult(false, true, 'Company not found');
		}
        return $this->setApiResult($res);
    }
    
    public function get_allcompany($data){
        $res = (array)$this->companysTable->search();
        return $this->setApiResult($res);
    }
    
    public function post_company($data){
		$post = true;
		$add_company_method = (empty ($data['add_company_method']))?null:$data['add_company_method'];
        if($add_company_method==null){return $this->setApiResult(false, true, 'param \'add_company_method\' undefined');}
		
		$insert = $this->companysTable->insert();
		
        if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
    
    public function put_company($data){
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
        $company_name = (empty ($data['company_name']))?null:$data['company_name'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_company = $this->get_company(array("company_id"=>$company_id));
        if($exist_company->apiError==true){ return $this->setApiResult(false,true,$exist_company->apiErrorMessage); }
        $update = array();
		
		//------------- Test et ajout des champs ------------------------------------------//
        if($company_name!=null){
			$this->companysTable->addNewField("company_name",$company_name);
		}
        $this->companysTable->update();
        return $this->setApiResult(true);
    }
    
    public function delete_company($data){
        $company_id = (empty ($data['company_id']))?null:$data['company_id'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_company = $this->get_company(array("company_id"=>$company_id));
        if($exist_company->apiError==true){ return $this->setApiResult(false,true,$exist_company->apiErrorMessage); }
        $update = array();
		
        $this->companysTable->delete();
        return $this->setApiResult(true);
    }
}