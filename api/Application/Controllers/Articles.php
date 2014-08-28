<?php
/**
 * La classe Application_Controllers_Articles effectue tous les contôles des données liées aux articles
 * Cette classe fait appel à Application_Articles_Roles pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Articles extends Library_Core_Controllers{
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
	
	private $article_vars = array('article_id',
					   		   'article_name',
					   		   'article_description',
					   		   'article_type_id',
					   		   'article_link',
					   		   'article_date');
	
	public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Articles($iDB->getConnexion());
		$as = $this->table->getAlias();
	}
	
	public function get_article($data){
        $article_id = (empty ($data['article_id']))?null:$data['article_id'];
        if($article_id==null){return $this->setApiResult(false, true, 'param \'article_id\' undefined');}
        if(!is_numeric($article_id)){return $this->setApiResult(false, true, 'param \'article_id\' is not numeric');}
		$this->table->addWhere("article_id",$article_id);
        $res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'article not found');
		}
	
        return $this->setApiResult($res);
    }
	
	public function get_next_article($data)
	{
        $article_id = (empty ($data['article_id']))?null:$data['article_id'];
        if($article_id==null){return $this->setApiResult(false, true, 'param \'article_id\' undefined');}
        if(!is_numeric($article_id)){return $this->setApiResult(false, true, 'param \'article_id\' is not numeric');}
		
		$type = (empty ($data['type']))?null:$data['type'];
		if($type==null){return $this->setApiResult(false, true, 'param \'type\' undefined');}
        if(!is_numeric($type) && $type!=1 && $type!=2 ){return $this->setApiResult(false, true, 'param \'type\' is not correct (value:1 or 2)');}
		
		$this->table->addWhere("article_id", $article_id,"",$where_type=">");
		$this->table->addWhere("article_type_id", $type);
		
        $res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'article not found');
		}
	
        return $this->setApiResult($res);
    }
	
	public function get_prev_article($data)
	{
        $article_id = (empty ($data['article_id']))?null:$data['article_id'];
        if($article_id==null){return $this->setApiResult(false, true, 'param \'article_id\' undefined');}
        if(!is_numeric($article_id)){return $this->setApiResult(false, true, 'param \'article_id\' is not numeric');}
		
		$type = (empty ($data['type']))?null:$data['type'];
		if($type==null){return $this->setApiResult(false, true, 'param \'type\' undefined');}
        if(!is_numeric($type) && $type!=1 && $type!=2 ){return $this->setApiResult(false, true, 'param \'type\' is not correct (value:1 or 2)');}
		
		$this->table->addWhere("article_id", $article_id,"",$where_type="<");
		$this->table->addWhere("article_type_id", $type);
		//$this->table->getOrder("article_id DESC");
        $res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'article not found');
		}
	
        return $this->setApiResult($res);
    }
	
    public function get_allarticle($data){
        $res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no articles found');
		}
        return $this->setApiResult($res);
    }
	
	
	
	 public function get_allpdf($data){
        $this->table->addWhere("article_type_id","1");
		$res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no pdf found');
		}
        return $this->setApiResult($res);
    }
	
	 public function get_allvideo($data){
        $this->table->addWhere("article_type_id","2");
		$res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no videos found');
		}
        return $this->setApiResult($res);
    }
	
	public function get_other_articles($data){
		
         $article_id = (empty ($data['article_id']))?null:$data['article_id'];
        if($article_id==null){return $this->setApiResult(false, true, 'param \'article_id\' undefined');}
        if(!is_numeric($article_id)){return $this->setApiResult(false, true, 'param \'article_id\' is not numeric');}
		
         $article_limit = (empty ($data['article_limit']))?null:$data['article_limit'];
        if($article_limit==null){return $this->setApiResult(false, true, 'param \'article_limit\' undefined');}
        if(!is_numeric($article_limit)){return $this->setApiResult(false, true, 'param \'article_limit\' is not numeric');}
		
		 $type = (empty ($data['type']))?null:$data['type'];
        if($type==null){return $this->setApiResult(false, true, 'param \'type\' undefined');}
        if(!is_numeric($type)){return $this->setApiResult(false, true, 'param \'type\' is not correct (value:1 or 2);');}
		
		$this->table->addWhere("article_type_id", $type);
		$this->table->addWhere("article_id", $article_id,"",$where_type="!=");
		
		$res = (array)$this->table->search();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no pdf found');
		}
		$nb = count($res);
		$rd_article = array();
		$last = array();
		if($nb>$article_limit){
			for($current=0;$current<$article_limit;$current++){
				do{
					$rd_num = rand(0,$nb-1);
				}while(in_array($rd_num,$last));
				$rd_article[] = $res[$rd_num];
				$last[] = $rd_num;
			}
		} else {
			$rd_article = $res;
		}
		
        return $this->setApiResult($rd_article);
    }
	
	
	
 public function post_article($data){
		
		$add_article_role = (empty ($data['add_article_role']))?null:$data['add_article_role'];
        if($add_article_role==null){return $this->setApiResult(false, true, 'param \'add_article_role\' undefined');}
		
		switch($add_article_role){
			// On récupère l'id du role, si c'est un administrateur ou un community manager, il peut ajouter un article
			case "1":case "3":
				// Récupération des paramètres utiles
				$article_name = (empty ($data['article_name']))?null:$data['article_name'];
				$article_description = (empty ($data['article_description']))?null:$data['article_description'];
					//Le type id sera un bouton radio qui aura pour valeur "1" pour les pdf et "2" pour les vidéos
				$article_type_id = (empty ($data['article_type_id']))?null:$data['article_type_id'];
				$article_link = (empty ($data['article_link']))?null:$data['article_link'];
				
				// Tests des variables
				if($article_name==null){return $this->setApiResult(false, true, 'param \'article_name\' undefined');}
				if($article_description==null){return $this->setApiResult(false, true, 'param \'article_description\' undefined');}
				if($article_type_id==null){return $this->setApiResult(false, true, 'param \'article_type_id\' undefined');}
				if($article_type_id!=1 && $article_type_id!=2){return $this->setApiResult(false, true, 'param \'article_type_id\' must have value "1" OR "2"');}
				if($article_link==null){return $this->setApiResult(false, true, 'param \'article_link\' undefined');}
				
				// Préparation de la requête
				$this->table->addNewField("article_name",$article_name);
				$this->table->addNewField("article_description",$article_description);
				$this->table->addNewField("article_type_id",$article_type_id);
				$this->table->addNewField("article_link",$article_link);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		
        $insert = $this->table->insert();
		if($insert!="ok"){
			return $this->setApiResult(false, true, $insert);
		}
        return $this->setApiResult(true);
    }
	
	 public function put_article($data){
		$add_article_role = (empty ($data['add_article_role']))?null:$data['add_article_role'];
        if($add_article_role==null){return $this->setApiResult(false, true, 'param \'add_article_role\' undefined');}
		
		switch($add_article_role){
			// On récupère l'id du role, si c'est un administrateur ou un community manager, il peut ajouter un article
			case "1":case "3":
				// Récupération des paramètres utiles
				$article_id = (empty ($data['article_id']))?null:$data['article_id'];
				$article_name = (empty ($data['article_name']))?null:$data['article_name'];
				$article_description = (empty ($data['article_description']))?null:$data['article_description'];
					//Le type id sera un bouton radio qui aura pour valeur "1" pour les pdf et "2" pour les vidéos
				$article_type_id = (empty ($data['article_type_id']))?null:$data['article_type_id'];
				$article_link = (empty ($data['article_link']))?null:$data['article_link'];
				
				// Tests des variables
				if($article_id==null){return $this->setApiResult(false, true, 'param \'article_id\' undefined');}
				if(!is_numeric($article_id)){return $this->setApiResult(false, true, 'param \'article_id\' not numeric');}
				if($article_name==null){return $this->setApiResult(false, true, 'param \'article_name\' undefined');}
				if($article_description==null){return $this->setApiResult(false, true, 'param \'article_description\' undefined');}
				if($article_type_id==null){return $this->setApiResult(false, true, 'param \'article_type_id\' undefined');}
				if($article_type_id!=1 && $article_type_id!=2){return $this->setApiResult(false, true, 'param \'article_type_id\' must have value "1" OR "2"');}
				if($article_link==null){return $this->setApiResult(false, true, 'param \'article_link\' undefined');}
				
				// Préparation de la requête
				$this->table->addNewField("article_name",$article_name);
				$this->table->addNewField("article_description",$article_description);
				$this->table->addNewField("article_type_id",$article_type_id);
				$this->table->addNewField("article_link",$article_link);
				break;
			
			default:
				return $this->setApiResult(false, true, 'No authorization to access to this page');
				break;
		}
		
		$this->table->addWhere("article_id",$article_id);
		$this->table->update();
		
		
        return $this->setApiResult(true);
    }
  
   public function delete_article($data){
		// Récupération des paramètres utiles
		$article_id = (empty ($data['article_id']))?null:$data['article_id'];
				
		// Tests des variables
		if($article_id==null){return $this->setApiResult(false, true, 'param \'article_id\' undefined');}
		if(!is_numeric($article_id)){return $this->setApiResult(false, true, 'param \'article_id\' not numeric');}
		
		//------------- Test existance en base --------------------------------------------//
		$article_user = $this->get_article(array("article_id"=>$article_id));
        if($article_user->apiError==true){ return $this->setApiResult(false,true,'article doesn\'t look existt'); }
        
		$this->table->addWhere("article_id",$article_id);
        $this->table->delete();
        return $this->setApiResult(true);
    }
}