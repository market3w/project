<?php
class Application_Controllers_Documents extends Library_Core_Controllers{
    private $documentsTable;
	private $as;
	
	private $document_vars = array('document_id',
					   		   'document_name',
							   'document_description',
							   'document_link',
					   		   'document_date',
							   'document_auteur',
							   'user_id');
	
	public function __construct(){
        global $iDB;
        $this->documentsTable = new Application_Models_Documents($iDB->getConnexion());
		$as = $this->documentsTable->getAlias();
	}
	
	public function get_document($data){
		 $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		 if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_id = $role_res->response[0]->role_id;
		
		//Si c'est un administrateur ou webmarketeur ils récupére le document et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
		if($role_id==1 || $role_id==2 || $role_id==3 )
		{
			  $document_id = (empty ($data['document_id']))?null:$data['document_id'];
			if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
			if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' is not numeric');}
			$this->documentsTable->addJoin("users","u","user_id","user_id","","left");
			$this->documentsTable->addWhere("document_id",$document_id);
			//Si un membre veut recupérer un document, on vérifie que celui-ci lui appartienne sinon le document sera "not found"
			if($role_id==3){$this->documentsTable->addWhere("user_id",$user_id);}
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
		else
		{
			return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
		}
	}
	
	public function get_alldocument_user($data){
		$user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		 if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_id = $role_res->response[0]->role_id;
		
		//Si c'est un administrateur ou webmarketeur ils récupére les documents et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
		if($role_id==1 || $role_id==2 || $role_id==3 )
		{
			//Si c'est un admin ou webmarketeur qui accéde aux dossier du client, il devra renseigne l'id du client
			if($role_id!=3)
			{
				$user_id = (empty ($data['user_id']))?null:$data['user_id'];
				if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
				if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
			}
			
			$this->documentsTable->addWhere("user_id",$user_id);
			$res = (array)$this->documentsTable->search();
			
			if(!array_key_exists(0,$res)){
				return $this->setApiResult(false, true, ' no documents found');
			}
		
			return $this->setApiResult($res);
		}
		else
		{
			return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
		}
	}
	/* PAS FORCEMMENT TRES UTILE CETTE FONCTION
	public function get_alldocument($data){
	
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
	*/
	 public function post_document($data){
		
	 $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		 if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_id = $role_res->response[0]->role_id;
		
		//Si c'est un administrateur ou webmarketeur ou client ils peuvent ajouter des docs 
		if($role_id==1 || $role_id==2 || $role_id==3 )
		{
			// Récupération des parametres utiles
			
			$document_name = (empty ($data['document_name']))?null:$data['document_name'];
			$document_description = (empty ($data['document_description']))?null:$data['document_description'];
			$document_link = (empty ($data['document_link']))?null:$data['document_link'];
			$document_auteur =  $user_id_connecte;
			//Si admin ou webmarketeur on attend un id de client ou prospect pour indiquer quel client 
			if($role_id!=3){$user_id = (empty ($data['user_id']))?null:$data['user_id'];}
			else{ $user_id = $user_id_connecte;}
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
			$this->documentsTable->addNewField("document_auteur",$document_auteur);
			$this->documentsTable->addNewField("user_id",$user_id);
		
			$insert = $this->documentsTable->insert();
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

 public function put_document($data){
		 $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		 if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_id = $role_res->response[0]->role_id;
		
		//Si c'est un administrateur ou webmarketeur ou client ils peuvent modifier leur docs 
		if($role_id==1 || $role_id==2 || $role_id==3 )
		{
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
			$this->documentsTable->addNewField("document_auteur",$document_auteur);
		
			
			$this->documentsTable->addWhere("document_id",$document_id);
			if($role_id==3){$this->documentsTable->addWhere("user_id",$user_id_connecte);}
			$this->documentsTable->update();
		
			return $this->setApiResult(true);
		}
		else
		{
			return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
		}
    }
	
	 public function delete_document($data){
		 // l'admin, le ebmarketteur , le client et le prospect pourront supprimer leur document
		  $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
		 if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}
		 
		$role = new Application_Controllers_Roles();
		$role_res = $role->get_currentrole();
		$role_id = $role_res->response[0]->role_id;
		
		//Si c'est un administrateur ou webmarketeur ils récupére le document et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
		if($role_id==1 || $role_id==2 || $role_id==3 )
		{
			// Récupération des parametres utiles
			$document_id = (empty ($data['document_id']))?null:$data['document_id'];
					
			// Tests des variables
			if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
			if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' not numeric');}
			
			//------------- Test existance en base --------------------------------------------//
			$exist_document = $this->get_document(array("document_id"=>$document_id));
			if($exist_document->apiError==true){ return $this->setApiResult(false,true,'document doesn\'t look existt'); }
			
			$this->documentsTable->addWhere("document_id",$document_id);
			if($role_id==3){$this->documentsTable->addWhere("user_id",$user_id_connecte);}
			$this->documentsTable->delete();
			return $this->setApiResult(true);
		}
    }

 
}