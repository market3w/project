<?php
class Client_Controllers_Appointments extends Client_Core_Controllers{
    private $_client;

    public function __construct($_client){
        $this->_client = $_client;
    }

    public function get_allappointment($data=""){
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=allappointment")));
        $error = $this->getError();
        if($error===false){
            $videos = $this->getResponse();
            return $videos;
        }
    }
}