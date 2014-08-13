<?php
class Application_Controllers_Paiements extends Library_Core_Controllers{
    private $paiementsTable;
	private $as;
	
	private $paiement_vars = array('paiement_id',
					   		   'paiement_intitule',
							   'paiement_prix',
					   		   'paiement_date',
							   'user_id');
	
	public function __construct(){
        global $iDB;
        $this->paiementsTable = new Application_Models_Paiements($iDB->getConnexion());
		$as = $this->paiementsTable->getAlias();
	}
	
	public function get_paiement($data){
        $paiement_id = (empty ($data['paiement_id']))?null:$data['paiement_id'];
        if($paiement_id==null){return $this->setApiResult(false, true, 'param \'paiement_id\' undefined');}
        if(!is_numeric($paiement_id)){return $this->setApiResult(false, true, 'param \'paiement_id\' is not numeric');}
		$this->paiementsTable->addJoin("users","u","user_id","user_id","","left");
		$this->paiementsTable->addWhere("paiement_id",$paiement_id);
        $res = (array)$this->paiementsTable->search();
		$tab = array();
		
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, 'paiement not found');
		}
		
		foreach($res[0] as $k=>$v){
			if(!(strpos($k,"user")===false)){
				$tab['paiement_user'][$k]=$v;
			} elseif(in_array($k,$this->paiement_vars)) {
				$tab[$k] = $v;
			}
		}
		
		if($tab['paiement_user']['user_id']!=null)
		{
			$tab['paiement_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['paiement_user']['user_id'];
		}
		return $this->setApiResult($tab);
	}
		
	public function get_allpaiement($data){
		$this->paiementsTable->addJoin("users","u","user_id","user_id","","left");
        $res = (array)$this->paiementsTable->search();
		$tab = array();
		if(!array_key_exists(0,$res)){
			return $this->setApiResult(false, true, ' no paiements found');
		}
		foreach($res as $k=>$v){
			foreach($v as $k2=>$v2){
				if(!(strpos($k2,"user")===false)){
					$tab[$k]['paiement_user'][$k2]=$v2;
				} elseif(in_array($k2,$this->paiement_vars)) {
					$tab[$k][$k2] = $v2;
				}
			}
			if($tab[$k]['paiement_user']['user_id']!=null){
				$tab[$k]['paiement_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['paiement_user']['user_id'];
			}
		}
        return $this->setApiResult($tab);
	}

 
}