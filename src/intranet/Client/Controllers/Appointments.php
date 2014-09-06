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
            $appointment = $this->getResponse();
            return $appointment;
        }
    }
	
    public function get_allappointment($data=""){
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=allappointment")));
        $error = $this->getError();
        if($error===false){
            return $this->getResponse();
        }
    }
	
    public function get_allappointmentcurrent($data=""){
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=allappointmentcurrent&appointment_active=1")));
        $error = $this->getError();
        if($error===false){
            return $this->getResponse();
        }
    }
	
    public function get_allappointmentuser($data){
        $user_id = (empty ($data['user_id']))?null:$data['user_id'];
        $this->parseQueryResult(json_decode($this->_client->query("GET","method=allappointmentuser&user_id=".$user_id)));
        $error = $this->getError();
        if($error===false){
            return $this->getResponse();
        }
    }
    
    public function add_appointment($data) {
        $user_id = ($data["user_id"]!="")? $data["user_id"]:null;
        $webmarketter_id = ($data["webmarketter_id"]!="")? $data["webmarketter_id"]:null;
        $appointment_name = ($data["appointment_name"]!="")? $data["appointment_name"]:null;
        $appointment_description = ($data["appointment_description"]!="")? $data["appointment_description"]:null;
        $appointment_start_date = ($data["appointment_start_date"]!="")? $data["appointment_start_date"]:null;
        $appointment_start_date2 = ($data["appointment_start_date2"]!="")? $data["appointment_start_date2"]:null;
        $appointment_end_date = ($data["appointment_end_date"]!="")? $data["appointment_end_date"]:null;
        $appointment_end_date2 = ($data["appointment_end_date2"]!="")? $data["appointment_end_date2"]:null;
        $type_id = ($data["type_id"]!="")? $data["type_id"]:null;
        
        $user = (is_null($user_id))? "" : "&user_id=".$user_id;
        $webmarketter = (is_null($webmarketter_id))? "" : "&webmarketter_id=".$webmarketter_id;
        $appointment_name = (is_null($appointment_name))? "" : "&appointment_name=".$appointment_name;
        $appointment_description = (is_null($appointment_description))? "" : "&appointment_description=".$appointment_description;
        $appointment_start_date = (is_null($appointment_start_date))?"":"&appointment_start_date=".$appointment_start_date;
        $appointment_start_hour = (is_null($appointment_start_date2))?"":"&appointment_start_hour=".$appointment_start_date2;
        $appointment_end_date = (is_null($appointment_end_date))?"":"&appointment_end_date=".$appointment_end_date;
        $appointment_end_hour = (is_null($appointment_end_date2))?"":"&appointment_end_hour=".$appointment_end_date2;
        $type_id = (is_null($type_id))? "" : "&type_id=".$type_id;

        $this->parseQueryResult(json_decode($this->_client->query("POST","method=appointment".$user.$webmarketter.$appointment_name.$appointment_description.$appointment_start_date.$appointment_start_hour.$appointment_end_date.$appointment_end_hour.$type_id)));
        $error = $this->getError();
        if($error===false){
            $_SESSION["validMessage"] = "Votre rendez-vous a bien été pris en compte";
            unset($_POST);
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "You are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'êtes pas connecté";
                        $_SESSION["market3w_user"] = "";
                        break;

                case "You can't make appointments" :
                        $_SESSION["errorMessage"] = "Vous ne pouvez pas prendre de rendez-vous";
                        break;

                case "user not found" :
                        $_SESSION["errorMessage"] = "Utilisateur non trouvé";
                        break;

                case "webmarketter not found" :
                        $_SESSION["errorMessage"] = "Webmarketeur non trouvé";
                        break;

                case "this is a past date" :
                        $_SESSION["errorMessage"] = "Cette date est déjà passée";
                        break;

                case "this time is not available" :
                        $_SESSION["errorMessage"] = "Cette plage horaire n'est pas disponible";
                        break;
                    
                case "param 'appointment_name' undefined" :
                        $_SESSION["errorMessage"] = "Intitulé du rendez-vous manquant";
                        break;
                    
                case "param 'appointment_start_date' undefined" :
                        $_SESSION["errorMessage"] = "Date du début du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_start_hour' undefined" :
                        $_SESSION["errorMessage"] = "Heure du début du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_end_date' undefined" :
                        $_SESSION["errorMessage"] = "Date de la fin du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_end_hour' undefined" :
                        $_SESSION["errorMessage"] = "Heure de la fin du rendez-vous manquante";
                        break;
                    
                case "param 'user_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du client ou prospect manquant";
                        break;
                    
                case "param 'user_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du client ou prospect n'est pas un nombre";
                        break;
                    
                case "param 'webmarketter_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du webmarketeur manquant";
                        break;
                    
                case "param 'webmarketter_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du webarketeur n'est pas un nombre";
                        break;
                    
                case "param 'type_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du type de rendez-vous manquant";
                        break;
                    
                case "param 'type_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du type de rendez-vous n'est pas un nombre";
                        break;
                    
                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;

            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
    
    public function edit_appointment($data) {
        $appointment_id = ($data["appointment_id"]!="")? $data["appointment_id"]:null;
        $user_id = ($data["user_id"]!="")? $data["user_id"]:null;
        $webmarketter_id = ($data["webmarketter_id"]!="")? $data["webmarketter_id"]:null;
        $appointment_name = ($data["appointment_name"]!="")? $data["appointment_name"]:null;
        $appointment_description = ($data["appointment_description"]!="")? $data["appointment_description"]:null;
        $appointment_start_date = ($data["appointment_start_date"]!="")? $data["appointment_start_date"]:null;
        $appointment_start_date2 = ($data["appointment_start_date2"]!="")? $data["appointment_start_date2"]:null;
        $appointment_end_date = ($data["appointment_end_date"]!="")? $data["appointment_end_date"]:null;
        $appointment_end_date2 = ($data["appointment_end_date2"]!="")? $data["appointment_end_date2"]:null;
        $type_id = ($data["type_id"]!="")? $data["type_id"]:null;
        $status_id = ($data["status_id"]!="")? $data["status_id"]:null;
        
        $appointment = (is_null($appointment_id))? "" : "&appointment_id=".$appointment_id;
        $user = (is_null($user_id))? "" : "&user_id=".$user_id;
        $webmarketter = (is_null($webmarketter_id))? "" : "&webmarketter_id=".$webmarketter_id;
        $appointment_name = (is_null($appointment_name))? "" : "&appointment_name=".$appointment_name;
        $appointment_description = (is_null($appointment_description))? "" : "&appointment_description=".$appointment_description;
        $appointment_start_date = (is_null($appointment_start_date))?"":"&appointment_start_date=".$appointment_start_date;
        $appointment_start_hour = (is_null($appointment_start_date2))?"":"&appointment_start_hour=".$appointment_start_date2;
        $appointment_end_date = (is_null($appointment_end_date))?"":"&appointment_end_date=".$appointment_end_date;
        $appointment_end_hour = (is_null($appointment_end_date2))?"":"&appointment_end_hour=".$appointment_end_date2;
        $type_id = (is_null($type_id))? "" : "&type_id=".$type_id;
        $status_id = (is_null($status_id))? "" : "&status_id=".$status_id;

        $this->parseQueryResult(json_decode($this->_client->query("PUT","method=appointment".$appointment.$user.$webmarketter.$appointment_name.$appointment_description.$appointment_start_date.$appointment_start_hour.$appointment_end_date.$appointment_end_hour.$type_id.$status_id)));
        $error = $this->getError();
        if($error===false){
            $_SESSION["validMessage"] = "Votre rendez-vous a bien été mis à jour";
            unset($_POST);
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "You are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'êtes pas connecté";
                        $_SESSION["market3w_user"] = "";
                        break;

                case "You can't update this appointment" :
                        $_SESSION["errorMessage"] = "Vous ne pouvez pas mettre à jour ce rendez-vous";
                        break;

                case "user not found" :
                        $_SESSION["errorMessage"] = "Utilisateur non trouvé";
                        break;

                case "webmarketter not found" :
                        $_SESSION["errorMessage"] = "Webmarketeur non trouvé";
                        break;

                case "Appointment not found" :
                        $_SESSION["errorMessage"] = "Rendez-vous non trouvé";
                        break;

                case "this is a past date" :
                        $_SESSION["errorMessage"] = "Cette date est déjà passée";
                        break;

                case "this time is not available" :
                        $_SESSION["errorMessage"] = "Cette plage horaire n'est pas disponible";
                        break;
                    
                case "param 'appointment_name' undefined" :
                        $_SESSION["errorMessage"] = "Intitulé du rendez-vous manquant";
                        break;
                    
                case "param 'appointment_start_date' undefined" :
                        $_SESSION["errorMessage"] = "Date du début du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_start_hour' undefined" :
                        $_SESSION["errorMessage"] = "Heure du début du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_end_date' undefined" :
                        $_SESSION["errorMessage"] = "Date de la fin du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_end_hour' undefined" :
                        $_SESSION["errorMessage"] = "Heure de la fin du rendez-vous manquante";
                        break;
                    
                case "param 'appointment_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du rendez-vous manquant";
                        break;
                    
                case "param 'appointment_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du rendez-vous n'est pas un nombre";
                        break;
                    
                case "param 'type_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du type de rendez-vous manquant";
                        break;
                    
                case "param 'type_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du type de rendez-vous n'est pas un nombre";
                        break;
                    
                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;

            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
    
    public function cancel_appointment($data) {
        $appointment_id = ($data["appointment_id"]!="")? $data["appointment_id"]:null;
        
        $appointment = (is_null($appointment_id))? "" : "&appointment_id=".$appointment_id;

        $this->parseQueryResult(json_decode($this->_client->query("DELETE","method=appointment".$appointment)));
        $error = $this->getError();
        if($error===false){
            $_SESSION["validMessage"] = "Votre rendez-vous a bien été annulé";
            unset($_POST);
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "You are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'êtes pas connecté";
                        $_SESSION["market3w_user"] = "";
                        break;

                case "You can't cancel this appointment" :
                        $_SESSION["errorMessage"] = "Vous ne pouvez pas annuler ce rendez-vous";
                        break;
                    
                case "param 'appointment_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du rendez-vous manquant";
                        break;
                    
                case "param 'appointment_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du rendez-vous n'est pas un nombre";
                        break;
                    
                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;

            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
    
    public function valid_appointment($data) {
        $appointment_id = ($data["appointment_id"]!="")? $data["appointment_id"]:null;
        
        $appointment = (is_null($appointment_id))? "" : "&appointment_id=".$appointment_id;

        $this->parseQueryResult(json_decode($this->_client->query("PUT","method=appointmentfinish".$appointment)));
        $error = $this->getError();
        if($error===false){
            $_SESSION["validMessage"] = "Votre rendez-vous a bien été déclaré \"terminé\"";
            unset($_POST);
        } elseif($error["errorType"]=="API ERROR") {
            switch($error["errorMessage"]){
                case "You are not logged" :
                        $_SESSION["errorMessage"] = "Vous n'êtes pas connecté";
                        $_SESSION["market3w_user"] = "";
                        break;

                case "You can't close this appointment" :
                        $_SESSION["errorMessage"] = "Vous ne pouvez pas clore ce rendez-vous";
                        break;
                    
                case "param 'appointment_id' undefined" :
                        $_SESSION["errorMessage"] = "Identifiant du rendez-vous manquant";
                        break;
                    
                case "param 'appointment_id' is not numeric" :
                        $_SESSION["errorMessage"] = "Identifiant du rendez-vous n'est pas un nombre";
                        break;
                    
                default :
                        $_SESSION["errorMessage"] = "Erreur de saisie";
                        break;

            }
        } elseif($error["errorType"]=="SERVER ERROR") {
            $_SESSION["errorServer"]=$error["errorMessage"];
        }
    }
}