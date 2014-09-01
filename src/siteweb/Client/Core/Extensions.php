<?php
Abstract class Client_Core_Extensions
{
	private $_tExendInstances = array();
        
    public function __construct($exts=array(),$_client){
		foreach($exts as $ext){
			$this->_tExendInstances[] = new $ext($_client);
		}
	}
    
    /**
	 * Méthode magique __call()
	 * On va reporter chaque appel sur une des instances des classes mères
	 * @param string $funcName
	 * @param array $tArgs
	 * @return mixed
	 */
	public function __call($funcName, $tArgs) {
		foreach($this->_tExendInstances as &$object) {
			if(method_exists($object, $funcName)) return call_user_func_array(array($object, $funcName), $tArgs);
		}
	}  
}