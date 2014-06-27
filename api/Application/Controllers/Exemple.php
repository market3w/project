<?php
class Application_Controllers_Exemple extends Library_Core_Controllers{
    private $exempleTable;
	private $as;
	
	public function __construct(){
        global $iDB;
        $this->exempleTable = new Application_Models_Exemple($iDB->getConnexion());
		$as = $this->exempleTable->getAlias();
	}
	
	public function get_exemple($data){
        $exemple_id = (empty ($data['exemple_id']))?null:$data['exemple_id'];
        if($exemple_id==null){return $this->setApiResult(false, true, 'param \'exemple_id\' undefined');}
        if(!is_numeric($exemple_id)){return $this->setApiResult(false, true, 'param \'exemple_id\' is not numeric');}
		
		//------------- Les champs à récupérer --------------------------------------------//
		//Récupère tous les champs de la table principale
		//$this->exempleTable->addField("*",$as); 
		
		//Récupère tous les champs de la table sélectionnée
		//$this->exempleTable->addField("*","table_as"); 
		
		//Récupère le champs sélectionné de la table principale
		//$this->exempleTable->addField("field_name"); 
		
		//Récupère le champs sélectionné de la table sélectionnée
		//$this->exempleTable->addField("field_name","table_as");   
		//---------------------------------------------------------------------------------//
		
		//------------- Les jointures -----------------------------------------------------//
		//Requête : JOIN table1_name as table1_as ON table1_as.`local1_on` = current_as.`dist_on`
		//$this->exempleTable->addJoin("table1_name","table1_as","local1_on","dist_on"); 
		
		//Requête : JOIN table2_name as table2_as ON table2_as.`local2_on` = table1_name.`dist_on`
		//$this->exempleTable->addJoin("table2_name","table2_as","local2_on","dist_on","table1_as");  
		//---------------------------------------------------------------------------------//
		
		//------------- Where -------------------------------------------------------------//
		//Requête : WHERE current_as.`field_name`=field_value
		$this->exempleTable->addWhere("exemple_id",$exemple_id);
		
		//Requête : WHERE table1_as.`field_name`=field_value
		//$this->exempleTable->addWhere("field_name","field_value","table1_as");
		//---------------------------------------------------------------------------------//
		
		//------------- Group By ----------------------------------------------------------//
		//Requête : GROUP BY current_as.`field_name`
		//$this->exempleTable->addGroup("field_name");
		
		//Requête : GROUP BY table1_as.`field_name`
		//$this->exempleTable->addGroup("field_name","table1_as");
		//---------------------------------------------------------------------------------//
		
		//------------- Order -------------------------------------------------------------//
		//Requête : ORDER BY current_as.`field_name` ASC
		//$this->exempleTable->addOrder("field_name");
		
		//Requête : ORDER BY current_as.`field_name` DESC
		//$this->exempleTable->addOrder("field_name","DESC");
		
		//Requête : ORDER BY table1_as.`field_name` ASC
		//$this->exempleTable->addOrder("field_name","ASC","table1_as");
		//---------------------------------------------------------------------------------//
		
        $res = (array)$this->exempleTable->search();
        return $this->setApiResult($res);
    }
    
    public function get_allexemple($data){
		
		//------------- Les champs à récupérer --------------------------------------------//
		//Récupère tous les champs de la table principale
		//$this->exempleTable->addField("*",$as); 
		
		//Récupère tous les champs de la table sélectionnée
		//$this->exempleTable->addField("*","table_as"); 
		
		//Récupère le champs sélectionné de la table principale
		//$this->exempleTable->addField("field_name"); 
		
		//Récupère le champs sélectionné de la table sélectionnée
		//$this->exempleTable->addField("field_name","table_as");   
		//---------------------------------------------------------------------------------//
		
		//------------- Les jointures -----------------------------------------------------//
		//Requête : JOIN table1_name as table1_as ON table1_as.`local1_on` = current_as.`dist_on`
		//$this->exempleTable->addJoin("table1_name","table1_as","local1_on","dist_on"); 
		
		//Requête : JOIN table2_name as table2_as ON table2_as.`local2_on` = table1_name.`dist_on`
		//$this->exempleTable->addJoin("table2_name","table2_as","local2_on","dist_on","table1_as");  
		//---------------------------------------------------------------------------------//
		
		//------------- Where -------------------------------------------------------------//
		//Requête : WHERE current_as.`field_name`=field_value
		//$this->exempleTable->addWhere("field_name","field_value");
		
		//Requête : WHERE table1_as.`field_name`=field_value
		//$this->exempleTable->addWhere("field_name","field_value","table1_as");
		//---------------------------------------------------------------------------------//
		
		//------------- Group By ----------------------------------------------------------//
		//Requête : GROUP BY current_as.`field_name`
		//$this->exempleTable->addGroup("field_name");
		
		//Requête : GROUP BY table1_as.`field_name`
		//$this->exempleTable->addGroup("field_name","table1_as");
		//---------------------------------------------------------------------------------//
		
		//------------- Order -------------------------------------------------------------//
		//Requête : ORDER BY current_as.`field_name` ASC
		//$this->exempleTable->addOrder("field_name");
		
		//Requête : ORDER BY current_as.`field_name` DESC
		//$this->exempleTable->addOrder("field_name","DESC");
		
		//Requête : ORDER BY table1_as.`field_name` ASC
		//$this->exempleTable->addOrder("field_name","ASC","table1_as");
		//---------------------------------------------------------------------------------//
		
        $res = (array)$this->exempleTable->search();
        return $this->setApiResult($res);
    }
    
    public function post_exemple($data){
        $exemple_name = (empty ($data['exemple_name']))?null:$data['exemple_name'];
		
        if($exemple_name==null){return $this->setApiResult(false, true, 'param \'exemple_name\' undefined');}
		
		$this->exempleTable->addNewField("exemple_name",$exemple_name);
        $insert = $this->exempleTable->insert();
		
        if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
    
    public function put_exemple($data){
        $exemple_id = (empty ($data['exemple_id']))?null:$data['exemple_id'];
        $exemple_name = (empty ($data['exemple_name']))?null:$data['exemple_name'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_exemple = $this->get_exemple(array("exemple_id"=>$exemple_id));
        if($exist_exemple->apiError==true){ return $this->setApiResult(false,true,$exist_exemple->apiErrorMessage); }
        $update = array();
		
		//------------- Test et ajout des champs ------------------------------------------//
        if($exemple_name!=null){
			$this->exempleTable->addNewField("exemple_name",$exemple_name);
		}
        $this->exempleTable->update();
        return $this->setApiResult(true);
    }
    
    public function delete_exemple($data){
        $exemple_id = (empty ($data['exemple_id']))?null:$data['exemple_id'];
		
		//------------- Test existance en base --------------------------------------------//
		$exist_exemple = $this->get_exemple(array("exemple_id"=>$exemple_id));
        if($exist_exemple->apiError==true){ return $this->setApiResult(false,true,$exist_exemple->apiErrorMessage); }
        $update = array();
		
        $this->exempleTable->delete();
        return $this->setApiResult(true);
    }
}