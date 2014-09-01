<?php
class Client_Controllers_Articles extends Client_Core_Controllers{
	private $_client;
	
	public function __construct($_client){
		$this->_client = $_client;
	}
	
	public function get_all_articles($data=""){
		$articles = array("pdf"=>array(),"videos"=>array());
		/* Recupérer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=allpdf")));
		$error = $this->getError();
		if($error===false){
			$articles["pdf"] = $this->getResponse();
		}
		
		/* Recupérer les vidéos */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=allvideo")));
		$error = $this->getError();
		if($error===false){
			$articles["videos"] = $this->getResponse();
		}
		
		
		return $articles;
	}
	
	public function get_article($data){
		$id_article = (isset($data["id"]) && is_numeric($data["id"]))? $data["id"]:null;
		
		
		/* Recupérer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=article&article_id=".$id_article)));
		$error = $this->getError();
		if($error===false){
			$article = $this->getResponse();
			return $article[0];
		}
				
		return array();
	}
	
	public function get_other_articles($data){
		$article_id = (isset($data["article_id"]) && is_numeric($data["article_id"]))? $data["article_id"]:null;
		$article_limit = (isset($data["article_limit"]) && is_numeric($data["article_limit"]))? $data["article_limit"]:null;
		$type = (isset($data["type"]) && is_numeric($data["type"]))? $data["type"]:null;
		
		/* Recupérer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=other_articles&article_id=".$article_id."&article_limit=".$article_limit."&type=".$type)));
		$error = $this->getError();
		if($error===false){
			$article = $this->getResponse();
			return $article;
		}
				
		return array();
	}
	
	public function get_next_article($data){
		$article_id = (isset($data["article_id"]) && is_numeric($data["article_id"]))? $data["article_id"]:null;
		$type = (isset($data["type"]) && is_numeric($data["type"]))? $data["type"]:null;
		
		/* Recupérer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=next_article&article_id=".$article_id."&type=".$type)));
		$error = $this->getError();
		if($error===false){
			$article = $this->getResponse();
			return $article[0];
		}
				
		
	}
	
	public function get_prev_article($data){
		$article_id = (isset($data["article_id"]) && is_numeric($data["article_id"]))? $data["article_id"]:null;
		$type = (isset($data["type"]) && is_numeric($data["type"]))? $data["type"]:null;
		
		/* Recupérer les pdf */
		$this->parseQueryResult(json_decode($this->_client->query("GET","method=prev_article&article_id=".$article_id."&type=".$type)));
		$error = $this->getError();
		if($error===false){
			$article = $this->getResponse();
			return $article[0];
		}
				
		
	}
	
}