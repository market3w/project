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
	protected $whereCount = 0;
	protected $groupList = array();
	protected $orderList = array();
	protected $limit = array();
    
    public function __construct($connexion) {
        $this->db = $connexion;
    }
	
	public function getAlias(){
		return $this->table_as;
	}
    
    public function search($print=false){
		$fields = $this->getFields();
		$join = $this->getJoins();
		$where = $this->getWhere("select");
		$group = $this->getGroup();
		$order = $this->getOrder();
		$limit = $this->getLimit();
        
        $request = 'SELECT '.$fields.' FROM '.$this->table.' AS '.$this->table_as.$join.$where.$group.$order.$limit;
        if($print===true){
			$this->printRequest($request);
		}
		$sql = $this->db->prepare($request);
        $sql->execute($this->whereValueList);
        $errorInfo = $sql->errorInfo();
		if($errorInfo[2]!=null){
			return $errorInfo[2];
		}
        return $sql->fetchAll();
    }
    
    public function insert($print=false){
		$fields = $this->getNewFields("insert");
        
        $request = "INSERT INTO `".$this->table."`".$fields;	
        if($print===true){
			$this->printRequest($request);
		}	
        $sql = $this->db->prepare($request);
        $sql->execute($this->newFieldValueList);
        $errorInfo = $sql->errorInfo();
		if($errorInfo[2]!=null){
			return $errorInfo[2];
		}
        return "ok";
    }
    
    public function update($print=false){
		$fields = $this->getNewFields("update");
		$where = $this->getWhere();
		$values = array_merge($this->newFieldValueList,$this->whereValueList);
        
        $request = "UPDATE `".$this->table."`".$fields.$where;
        if($print===true){
			$this->printRequest($request);
		}
        $sql = $this->db->prepare($request);
        $sql->execute($values);
        $errorInfo = $sql->errorInfo();
		if($errorInfo[2]!=null){
			return $errorInfo[2];
		}
        return "ok";
    }
    
    public function delete($print=false){
		$where = $this->getWhere();
		
		$request = "DELETE FROM `".$this->table."`".$where;
        if($print===true){
			$this->printRequest($request);
		}
		
        $sql = $this->db->prepare($request);
        $sql->execute($this->whereValueList);
        $errorInfo = $sql->errorInfo();
		if($errorInfo[2]!=null){
			return $errorInfo[2];
		}
        return "ok";
    }
	
	public function addField($field="*",$table_as="",$field_as=""){
		$as = ($table_as=="")?$this->table_as:$table_as;
		$field_as = ($field_as=="")?null:' AS '.$field_as;
		if($field!="*"){
			$this->fieldsList[]=$as.'.`'.$field.'`'.$field_as;
		} else {
			$this->fieldsList[]=$as.'.'.$field.$field_as;
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
	
	public function addWhere($field_name,$field_value,$table_as="",$where_type="",$where_ope="",$where_par=""){
		$as = ($table_as=="")?$this->table_as:$table_as;
		$where_type = ($where_type=="")?" = ":" ".trim(strtoupper($where_type))." ";
		$where_ope = ($where_ope=="")?" AND ":" ".trim(strtoupper($where_ope))." ";
		$where_str = "";
		if($this->whereCount>0){
			$where_str .= $where_ope;
		}
		if($where_par!=""){
			if(!(strpos($where_par,"(")===false)){
				$where_str .= $where_par;
			}
			if($where_type==" BETWEEN "){
				$where_str .= '('.$as.'.`'.$field_name.'`'.$where_type.':where'.$this->whereCount. ' AND :where'.($this->whereCount+1).')';
			} else {
				$where_str .= $as.'.`'.$field_name.'`'.$where_type.':where'.$this->whereCount;
			}
			if(!(strpos($where_par,")")===false)){
				$where_str .= $where_par;
			}
		} else {
			$where_str .= $as.'.`'.$field_name.'`'.$where_type.':where'.$this->whereCount;
		}
		$this->whereList[]=$where_str;
		if($where_type==" LIKE "){
			$this->whereValueList['where'.$this->whereCount]="%".$field_value."%";
			$this->whereCount++;
		} elseif($where_type==" BETWEEN "){
			$this->whereValueList['where'.$this->whereCount]=$field_value[0];
			$this->whereValueList['where'.($this->whereCount+1)]=$field_value[1];
			$this->whereCount += 2;
		} else {
			$this->whereValueList['where'.$this->whereCount]=$field_value;
			$this->whereCount++;
		}
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
			if($count==0){
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
		$this->whereCount = 0;
		$this->groupList = array();
		$this->orderList = array();
		$this->limit = array();
	}
	
	private function printRequest($request){
		echo '<p style="border:1px solid #ff0000; color:#ff0000; padding:5px; margin:5px 0 10px; font-weight:bold;"><u>Request :</u><br />'.$request.'</p>';
		if(count($this->newFieldValueList)!=0){
			var_dump($this->newFieldValueList);
		}
		if(count($this->whereValueList)!=0){
			var_dump($this->whereValueList);
		}
	}
}