<?php
/**
 * La classe Library_Core_Model contient les méthodes pour construire et exécuter les requêtes sql
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
abstract class Library_Core_Model{
    /**
     * @var object $db                  Contient la connexion à la base de données
     * @var string $table               Contient le nom de la table
     * @var string $table_as            Contient l'alias de la table
     * @var array|string $primary       Contient la/les clefs primaires
     * @var array $fieldsList           Contient la liste des champs à retourner
     * @var array $newFieldList         Contient la liste des champs à ajouter ou modifier
     * @var array $newFieldValueList    Contient la liste des valeurs des champs à ajouter ou modifier
     * @var array $joinsList            Contient la liste des jointures
     * @var array $whereList            Contient la liste des conditions
     * @var array $whereValueList       Contient la liste des valeurs des conditions
     * @var integer $whereCount         Contient le nombre de conditions
     * @var array $groupList            Contient la liste des groupes
     * @var array $orderList            Contient la liste de tris
     * @var string $limit               Contient la limite de la recherche
     */
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
    protected $whereCount = 0;
    protected $groupList = array();
    protected $orderList = array();
    protected $limit = "";
    
    /**
     * Méthode magique __construct($connexion)
     * Stocke la connexion à la base de données
     * @param object $connexion
     */
    public function __construct($connexion) {
        $this->db = $connexion;
    }
	
    /**
     * Retourne l'alias de la table
     * @return string
     */
    public function getAlias(){
        return $this->table_as;
    }
    
    /**
     * Construit et éxecute une requête sql de type SELECT
     * @param boolean $print    Affiche la requête générée et les valeurs fournies en paramètre si valeur : true (valeur par défaut : false)
     * @return object
     */
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
    
    /**
     * Construit et éxecute une requête sql de type INSERT
     * @param boolean $print    Affiche la requête générée et les valeurs fournies en paramètre si valeur : true (valeur par défaut : false)
     * @return string           Retrourne "ok" ou une erreur sql
     */
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
    
    /**
     * Construit et éxecute une requête sql de type UPDATE
     * @param boolean $print    Affiche la requête générée et les valeurs fournies en paramètre si valeur : true (valeur par défaut : false)
     * @return string           Retrourne "ok" ou une erreur sql
     */
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
    
    /**
     * Construit et éxecute une requête sql de type DELETE
     * @param boolean $print    Affiche la requête générée et les valeurs fournies en paramètre si valeur : true (valeur par défaut : false)
     * @return string           Retrourne "ok" ou une erreur sql
     */
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
	
    /**
     * Ajoute un champ à la liste des champs à récupérer
     * @param string $field       Nom du champ à récupérer (valeur par défaut : "*")
     * @param string $table_as    Alias de la table de ce champs (valeur par défaut : "", sera remplacer par l'alias de table courante)
     * @param string $field_as    Alias du champ à récupérer (valeur par défaut : "")
     */
    public function addField($field="*",$table_as="",$field_as=""){
        $as = ($table_as=="")?$this->table_as:$table_as;
        $field_as = ($field_as=="")?null:' AS '.$field_as;
        if($field!="*"){
            $this->fieldsList[]=$as.'.`'.$field.'`'.$field_as;
        } else {
            $this->fieldsList[]=$as.'.'.$field.$field_as;
        }
    }

    /**
     * Ajoute un champ et sa valeur à ajouter ou modifier à leurs listes respectifs
     * @param string $field_name     Nom du champ à ajouter ou modifier
     * @param mixed $field_value     Valeur du champ à ajouter ou modifier
     */
    public function addNewField($field_name,$field_value){
        $count = count($this->newFieldList);
        $this->newFieldList[]='`'.$field_name.'`=:field'.$count;
        $this->newFieldValueList['field'.$count]=$field_value;
    }

    /**
     * Construit et ajoute une jointure à la liste
     * @param string $table         Nom de la table à joindre
     * @param string $table_as      Alias de la table à joindre
     * @param string $local_on      Nom du champs de la table à joindre utilisé pour la liaison
     * @param string $dist_on       Nom du champs de l'autre table à joindre utilisé pour la liaison
     * @param string $dist_as       Alias de l'autre table à joindre (valeur par défaut : "", sera remplacer par l'alias de la table courante)
     * @param string $join_type     Type de jointure (valeur par défaut : "", sera remplacer par "JOIN")
     */
    public function addJoin($table,$table_as,$local_on,$dist_on,$dist_as="",$join_type=""){
        $as = ($dist_as=="")?$this->table_as:$dist_as;
        $join_type = ($join_type=="")?null:trim(strtoupper($join_type)).' ';
        $this->joinsList[]=$join_type.'JOIN '.$table.' AS '.$table_as.' ON '.$table_as.'.`'.$local_on.'`='.$as.'.`'.$dist_on.'`';
    }

    /**
     * Construit et ajoute une condition à la liste et ajoute la valeur à sa liste
     * @param string $field_name    Nom du champs pour la condition
     * @param mixed $field_value    Valeur de la condition
     * @param string $table_as      Alias de la table de ce champs (valeur par défaut : "", sera remplacer par l'alias de table courante)
     * @param string $where_type    Type de la condition (valeur par défaut : "", sera remplacer par "=")
     * @param string $where_ope     Opérateur de la condition (valeur par défaut : "", sera remplacer par "AND" si ce n'est pas le premier ajout)
     * @param string $where_par     Parenthèse de la condition (valeur par défaut : "")
     */
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

    /**
     * Ajoute un champs à la liste pour le GROUP BY
     * @param string $field_name    Nom du champs
     * @param string $table_as      Alias de la table de ce champs (valeur par défaut : "", sera remplacer par l'alias de table courante)
     */
    public function addGroup($field_name,$table_as=""){
        $as = ($table_as=="")?$this->table_as:$table_as;
        $this->groupList[]=$as.'.`'.$field_name.'`';
    }

    /**
     * Ajoute un champs et un ordre de tri à la liste pour le ORDER BY
     * @param string $field_name    Nom du champ à trier
     * @param string $order         Ordre de tri : "asc" | "desc" | "ASC" | "DESC" (valeur par défaut : "ASC")
     * @param string $table_as      Alias de la table de ce champs (valeur par défaut : "", sera remplacer par l'alias de table courante)
     */
    public function addOrder($field_name,$order="ASC",$table_as=""){
        $order = (!($order=="ASC" || $order=="asc" || $order=="DESC" || $order=="desc"))?"ASC":strtoupper($order);
        $as = ($table_as=="")?$this->table_as:$table_as;
        $this->groupList[]=$as.'.`'.$field_name.'` '.$order;
    }

    /**
     * Ajoute des bornes à la recherche
     * @param string|integer $limit     Nombre de champs à récupérer au maximum
     * @param string|integer $offset    Récupérer à partir du resultat n°... (valeur par défaut : "", sera remplacer par "0")
     */
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

    /**
     * Formatte les champs et valeurs associées pour un INSERT ou UPDATE et retourne le résultat
     * @param string $mode (insert ou update)
     * @return string
     */
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

    /**
     * Formatte les jointures et retourne le résultat
     * @return string
     */
    private function getJoins(){
        $join = "";
        if(!count($this->joinsList)==0){
            $join = " ".implode(" ",$this->joinsList);
        }
        return $join;
    }

    /**
     * Formatte et retourne la chaine de caractères de la condition
     * @param string $mode
     * @return string
     */
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

    /**
     * Formatte et retourne la chaine de caractères pour le GROUP BY
     * @return string
     */
    private function getGroup(){
        $group = "";
        if(!count($this->groupList)==0){
            $group = " GROUP BY ".implode(",",$this->groupList);
        }
        return $group;
    }

    /**
     * Formatte et retourne la chaine de caractères pour le ORDER BY
     * @return string
     */
    private function getOrder(){
        $order = "";
        if(!count($this->orderList)==0){
            $order = " ORDER BY ".implode(",",$this->orderList);
        }
        return $order;
    }

    /**
     * Formatte et retourne la chaine de caractères pour le LIMIT
     * @return string
     */
    private function getLimit(){
        $limit = (empty ($this->limit))?'':$this->limit;
        return $limit;
    }

    /**
     * Réinitialise toutes variables de la classe (sauf $db, $table, $table_as et $primary)
     */
    public function resetObject(){
        $this->fieldsList = array();
        $this->newFieldList = array();
        $this->newFieldValueList = array();
        $this->joinsList = array();
        $this->whereList = array();
        $this->whereValueList = array();
        $this->whereCount = 0;
        $this->groupList = array();
        $this->orderList = array();
        $this->limit = array();
    }

    /**
     * Affiche la requête sql et les valeurs associées
     * @param string $request   Requête sql au format PDO
     */
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