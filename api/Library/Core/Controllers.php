<?php
/**
 * La classe Library_Core_Controllers permet de formatter les données retournées
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Library_Core_Controllers{
    
    /**
     * @var object $table       Stocke la table associée à un controller
     * @var object $apiResult   Stocke le format des données retournées
     */
    protected $table;
    private $apiResult;
	
    /**
     * Formatte et Retourne les données structurées
     * @param array|object $result
     * @param boolean $error                default value : false
     * @param string $errorMessage          default value : ""
     * @param boolean $errorServer          default value : false
     * @param string $errorServerMessage    default value : ""
     * @return object
     */
    public function setApiResult($result, $error=false, $errorMessage="", $errorServer=false, $errorServerMessage=""){
        $this->apiResult                    	 = new stdClass();
        $this->apiResult->response          	 = $result;
        $this->apiResult->apiError          	 = $error;
        $this->apiResult->apiErrorMessage    	 = $errorMessage;
        $this->apiResult->serverError            = $errorServer;
        $this->apiResult->serverErrorMessage     = $errorServerMessage;
        return $this->apiResult;
    }
	
    /**
     * Retourne la table associée au controller
     * @return object
     */
    public function get_table(){
        return $this->table;
    }
}