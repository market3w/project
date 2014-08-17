<?php
class Application_Controllers_Documents extends Library_Core_Controllers{
    private $documentsTable;
	private $as;
	
	private $document_vars = array('document_id',
					   		   'document_name',
							   'document_description',
							   'document_link',
					   		   'document_date',
							   'user_id');
	
	public function __construct(){
        global $iDB;
        $this->documentsTable = new Application_Models_Documents($iDB->getConnexion());
		$as = $this->documentsTable->getAlias();
	}
	
	public function get_document($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses document OU webmarketeur OU admin
		
          $document_id = (empty ($data['document_id']))?null:$data['document_id'];
        if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
        if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' is not numeric');}
		$this->documentsTable->addJoin("users","u","user_id","user_id","","left");
		$this->documentsTable->addWhere("document_id",$document_id);
        $res = (array)$this->documentsTable->search();
		$tab = array();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'document not found');
		}
		
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"user")===false)){
				$tab['document_user'][$k]=$v;
			} elseif(in_array($k,$this->document_vars)) {
				$tab[$k] = $v;
			}
		}
		
		if($tab['document_user']['user_id']!=null)
		{
			$tab['document_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['document_user']['user_id'];
		}
		return $this->setApiResult($tab);
	}
	
	public function get_alldocument_user($data){
		//!!!Reste a vérfier si utilisteur connecté et si c'est ses document OU webmarketeur OU admin
		
		$user_id = (empty ($data['user_id']))?null:$data['user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
        if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
		$this->documentsTable->addWhere("user_id",$user_id);
		$res = (array)$this->documentsTable->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no documents found');
		}
	
        return $this->setApiResult($res);
	}
	
	public function get_alldocument($data){
		//!!!Seulement l'admin a cette fonction A FAIRE
		
		$this->documentsTable->addJoin("users","u","user_id","user_id","","left");
        $res = (array)$this->documentsTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no documents found');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"user")===false)){
					$tab[$k]['document_user'][$k2]=$v2;
				} elseif(in_array($k2,$this->document_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
			if($tab[$k]['document_user']['user_id']!=null){
				$tab[$k]['document_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['document_user']['user_id'];
			}
		}
        return $this->setApiResult($tab);
	}
	
	 public function post_document($data){
		
		$add_document_role = (empty ($data['add_document_role']))?null:$data['add_document_role'];
        if($add_document_role==null){return $this->setApiResult(false, true, 'param \'add_document_role\' undefined');}
		
		switch($add_document_role){
			// On récupere l'id du role, si c'est un administrateur ou webmarketeur, il peut ajouter un document
			case "1":case "2":
				// Récupération des parametres utiles
				
				$document_name = (empty ($data['document_name']))?null:$data['document_name'];
				$document_description = (empty ($data['document_description']))?null:$data['document_description'];
				$document_link = (empty ($data['document_link']))?null:$data['document_link'];
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
			
				// Tests des variables
				
				if($document_name==null){return $this->setApiResult(false, true, 'param \'document_name\' undefined');}
				if($document_description==null){return $this->setApiResult(false, true, 'param \'document_description\' undefined');}
				if($document_link==null){return $this->setApiResult(false, true, 'param \'document_link\' undefined');}
				if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
				if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}
				
				// Préparation de la requete
				$this->documentsTable->addNewField("document_name",$document_name);
				$this->documentsTable->addNewField("document_description",$document_description);
				$this->documentsTable->addNewField("document_link",$document_link);
				$this->documentsTable->addNewField("user_id",$user_id);
				break;
			
			//propspect et clients peuvent télécharger 
			case "4":case "5":
				// Récupération des parametres utiles
				
				$document_name = (empty ($data['document_name']))?null:$data['document_name'];
				$document_description = (empty ($data['document_description']))?null:$data['document_description'];
				$document_link = (empty ($data['document_link']))?null:$data['document_link'];
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
			
				// Tests des variables
				
				if($document_name==null){return $this->setApiResult(false, true, 'param \'document_name\' undefined');}
				if($document_description==null){return $this->setApiResult(false, true, 'param \'document_description\' undefined');}
				if($document_link==null){return $this->setApiResult(false, true, 'param \'document_link\' undefined');}
				if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
				if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}
				
				// Préparation de la requete
				$this->documentsTable->addNewField("document_name",$document_name);
				$this->documentsTable->addNewField("document_description",$document_description);
				$this->documentsTable->addNewField("document_link",$document_link);
				$this->documentsTable->addNewField("user_id",$user_id);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $insert = $this->documentsTable->insert();
		if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }

 public function put_document($data){
		
		$put_document_role = (empty ($data['put_document_role']))?null:$data['put_document_role'];
        if($put_document_role==null){return $this->setApiResult(false, true, 'param \'put_document_role\' undefined');}
		
		switch($put_document_role){
					//Admin, webmarketteur, propspect et clients peuvent mettre ajour documents 
			case "1":case "2":case "4":case "5":
				// Récupération des parametres utiles
				$document_id = (empty ($data['document_id']))?null:$data['document_id'];
				$document_name = (empty ($data['document_name']))?null:$data['document_name'];
				$document_description = (empty ($data['document_description']))?null:$data['document_description'];
				$document_link = (empty ($data['document_link']))?null:$data['document_link'];
				
				// Tests des variables
				if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
				if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' must be numeric');}
				if($document_name==null){return $this->setApiResult(false, true, 'param \'document_name\' undefined');}
				if($document_description==null){return $this->setApiResult(false, true, 'param \'document_description\' undefined');}
				if($document_link==null){return $this->setApiResult(false, true, 'param \'document_link\' undefined');}
				
				// Préparation de la requete
				$this->documentsTable->addNewField("document_name",$document_name);
				$this->documentsTable->addNewField("document_description",$document_description);
				$this->documentsTable->addNewField("document_link",$document_link);
				
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
			
		
		}
		
		
		
        $this->documentsTable->addWhere("document_id",$document_id);
		$this->documentsTable->update();
	
        return $this->setApiResult(true);
    }
	
	 public function delete_document($data){
		 // l'admin, le ebmarketteur , le client et le prospect pourront supprimer leur document
		 
		// Récupération des parametres utiles
		$document_id = (empty ($data['document_id']))?null:$data['document_id'];
				
		// Tests des variables
		if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
		if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' not numeric');}
		
		//------------- Test existance en base --------------------------------------------//
		$exist_document = $this->get_document(array("document_id"=>$document_id));
        if($exist_document->apiError==true){ return $this->setApiResult(false,true,'document doesn\'t look existt'); }
		$this->documentsTable->addWhere("document_id",$document_id);
        $this->documentsTable->delete();
        return $this->setApiResult(true);
    }

 
}