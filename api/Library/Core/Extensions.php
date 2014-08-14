<?php
Abstract class Library_Core_Extensions
{
	private $_tExendInstances = array();
        
    public function __construct($exts=array()){
		foreach($exts as $ext){
			$this->_tExendInstances[] = new $ext;
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
		return $this->setApiResult(false, false, '', true, 'Server Error, Method not Found');
	}  
}