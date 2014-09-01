<?php
class Client_Controllers_Appointments extends Client_Core_Controllers{
    private $_client;

    public function __construct($_client){
        $this->_client = $_client;
    }

	public function get_appointment($data){
	  $appointment_id = (empty ($data['appointment_id']))?null:$data['appointment_id'];
    
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=appointment&appointment_id=".$appointment_id)));
        $error = $this->getError();
        if($error===false){
            $videos = $this->getResponse();
            return $videos;
        }
    }
	
    public function get_allappointment($data=""){
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=allappointment")));
        $error = $this->getError();
        if($error===false){
            $videos = $this->getResponse();
            return $videos;
        }
    }
	
	 public function get_allappointmentuser($data){
		 $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=allappointmentuser&user_id=".$user_id)));
        $error = $this->getError();
        if($error===false){
            $videos = $this->getResponse();
            return $videos;
        }
    }
}