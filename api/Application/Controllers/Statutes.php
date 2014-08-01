<?php
class Application_Controllers_Statutes extends Library_Core_Controllers{
    private $statusTable;
	private $as;
	
	public $status_id;
	public $status_name;
	
	public function __construct(){
        global $iDB;
        $this->statusTable = new Application_Models_Statutes($iDB->getConnexion());
		$as = $this->statusTable->getAlias();
	}
	
	public function get_status($data){
        $status_id = (empty ($data['status_id']))?null:$data['status_id'];
        if($status_id==null){return $this->setApiResult(false, true, 'param \'status_id\' undefined');}
        if(!is_numeric($status_id)){return $this->setApiResult(false, true, 'param \'status_id\' is not numeric');}
		
		//------------- Where -------------------------------------------------------------//
		//Requête : WHERE current_as.`field_name`=field_value
		$this->statusTable->addWhere("status_id",$status_id);
		
        $res = (array)$this->statusTable->search();
		foreach($res[0] as $k=>$v){
			$this->$k = $v;
		}
        return $this->setApiResult($res);
    }
    
    public function get_allstatus($data){
        $res = (array)$this->statusTable->search();
        return $this->setApiResult($res);
    }
}