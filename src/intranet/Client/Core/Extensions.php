<?php
/**
 * La classe Client_Core_Extensions permet d'étendre plusieurs classes
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
Abstract class Client_Core_Extensions
{
    /**
     * Tableau contenant toutes les classes instanciées
     * @var array 
     */
    private $_tExendInstances = array();
        
    /**
     * Méthode magique __construct($exts=array())
     * Instancier toutes les classes requises à la construction de la classe
     * @param array $exts Tableau contenant le noms des classes à instancier
     */
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