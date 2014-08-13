<?php
abstract class Library_Core_Model{
    protected $db;
    protected $table;
    protected $table_as;
    protected $primary;
	protected $fieldsList = array();
	protected $newFieldList = array();
	protected $newFieldValueList = array();
	protected $joinsList = array();
	protected $whereList = array();
	protected $whereValueList = array();
	protected $whereOpeList = array();
	protected $groupList = array();
	protected $orderList = array();
	protected $limit = array();
    
    public function __construct($connexion) {
        $this->db = $connexion;
    }
	
	public function getAlias(){
		return $this->table_as;
	}
    
    public function search(){
		$fields = $this->getFields();
		$join = $this->getJoins();
		$where = $this->getWhere("select");
		$group = $this->getGroup();
		$order = $this->getOrder();
		$limit = $this->getLimit();
        
        $request = 'SELECT '.$fields.' FROM '.$this->table.' AS '.$this->table_as.$join.$where.$group.$order.$limit;
        //echo $request
		$sql = $this->db->prepare($request);
        $sql->execute($this->whereValueList);
        return $sql->fetchAll();
    }
    
    public function insert(){
		$fields = $this->getNewFields("insert");
        
        $request = "INSERT INTO `".$this->table."`".$fields;		
        $sql = $this->db->prepare($request);
        $sql->execute($this->newFieldValueList);
        $errorInfo = $sql->errorInfo();
		if($errorInfo[2]!=null){
			return $errorInfo[2];
		}
        return "ok";
    }
    
    public function update(){
		$fields = $this->getNewFields("update");
		$where = $this->getWhere();
		$values = array_merge($this->newFieldValueList,$this->whereValueList);
        
        $request = "UPDATE `".$this->table."`".$fields.$where;
        $sql = $this->db->prepare($request);
        return $sql->execute($values);
    }
    
    public function delete(){
		$where = $this->getWhere();
		
		$request = "DELETE FROM `".$this->table."`".$where;
		foreach($this->whereValueList as $k=>$v){
			echo $k." : ".$v."\n";
		}
		
        $sql = $this->db->prepare($request);
        $sql->execute($this->whereValueList);
        return $sql->rowCount();
    }
	
	public function addField($field="*",$table_as=""){
		if(!($field=="*" && $table_as="")){
			$as = ($table_as=="")?$this->table_as:$table_as;
			$this->fieldsList[]=$as.'.`'.$field.'`';
		}
	}
	
	public function addNewField($field_name,$field_value){
		$count = count($this->newFieldList);
		$this->newFieldList[]='`'.$field_name.'`=:field'.$count;
		$this->newFieldValueList['field'.$count]=$field_value;
	}
	
	public function addJoin($table,$table_as,$local_on,$dist_on,$dist_as="",$join_type=""){
		$as = ($dist_as=="")?$this->table_as:$dist_as;
		$join_type = ($join_type=="")?null:trim(strtoupper($join_type)).' ';
		$this->joinsList[]=$join_type.'JOIN '.$table.' AS '.$table_as.' ON '.$table_as.'.`'.$local_on.'`='.$as.'.`'.$dist_on.'`';
	}
	
	public function addWhere($field_name,$field_value,$table_as="",$where_type="",$where_ope=""){
		$as = ($table_as=="")?$this->table_as:$table_as;
		$where_type = ($where_type=="")?" = ":" ".trim(strtoupper($where_type))." ";
		$where_ope = ($where_ope=="")?" AND ":" ".trim(strtoupper($where_ope))." ";
		$count = count($this->whereList);
		$this->whereList[]=$as.'.`'.$field_name.'`'.$where_type.':where'.$count;
		if($where_type==" LIKE "){
			$this->whereValueList['where'.$count]="%".$field_value."%";
		} else {
			$this->whereValueList['where'.$count]=$field_value;
		}
		$this->whereOpeList['where'.$count]=$where_ope;
	}
	
	public function addGroup($field_name,$table_as=""){
		$as = ($table_as=="")?$this->table_as:$table_as;
		$this->groupList[]=$as.'.`'.$field_name.'`';
	}
	
	public function addOrder($field_name,$order="ASC",$table_as=""){
		$order = (!($order=="ASC" || $order=="asc" || $order=="DESC" || $order=="desc"))?"ASC":$order;
		$as = ($table_as=="")?$this->table_as:$table_as;
		$this->groupList[]=$as.'.`'.$field_name.'` '.$order;
	}
	
	public function setLimit($limit,$offset=""){
		if($limit!=0 && is_numeric($limit)){
			$offset = ($offset=="")?"0":$offset;
			$this->limit='LIMIT '.$offset.', '.$limit;
		}
	}
	
	private function getFields(){
		$fields = "";
        if(count($this->fieldsList)==0){
			$fields = "*";
		} else {
			$fields = implode(",",$this->fieldsList);
		}
		return $fields;
	}
	
	private function getNewFields($mode){
		$newFields = "";
        if(!count($this->newFieldList)==0){
			if($mode == "insert"){
				$fieldName = array();
				$fieldValue = array();
				foreach($this->newFieldList as $k=>$v){
					$temp = explode("=",$v);
					$fieldName[] = $temp[0];
					$fieldValue[] = $temp[1];
				}
				$newFields = " (";
				$newFields .= implode(", ",$fieldName);
				$newFields .= ") VALUES (";
				$newFields .= implode(", ",$fieldValue);
				$newFields .= ")";
			}
			elseif($mode == "update") {
				$newFields = " SET ".implode(", ",$this->newFieldList);
			}
		}
		return $newFields;
	}
	
	private function getJoins(){
		$join = "";
        if(!count($this->joinsList)==0){
			$join = " ".implode(" ",$this->joinsList);
		}
		return $join;
	}
	
	private function getWhere($mode=""){
		$is_select = ($mode==="")?false:true;
		
		$where = "";
		for($count=0;$count<count($this->whereList);$count++){
			if($count>0){
				$where .= $this->whereOpeList["where".$count];
			} else {
				$where .= " WHERE ";
			}
			$where .= $this->whereList[$count];
		}
		
		if(!$is_select){
			$where = str_replace($this->table_as.".","",$where);
		}
		
		return $where;
	}
	
	private function getGroup(){
		$group = "";
        if(!count($this->groupList)==0){
			$group = " GROUP BY ".implode(",",$this->groupList);
		}
		return $group;
	}
	
	private function getOrder(){
		$order = "";
        if(!count($this->orderList)==0){
			$order = " ORDER BY ".implode(",",$this->orderList);
		}
		return $order;
	}
	
	private function getLimit(){
		$limit = (empty ($this->limit))?'':$this->limit;
		return $limit;
	}
	
	public function resetObject(){
		$this->fieldsList = array();
		$this->newFieldList = array();
		$this->newFieldValueList = array();
		$this->joinsList = array();
		$this->whereList = array();
		$this->whereValueList = array();
		$this->whereOpeList = array();
		$this->groupList = array();
		$this->orderList = array();
		$this->limit = array();
	}
}