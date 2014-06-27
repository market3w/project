<?php
class Service extends Application_Controllers_Exemple{
    
    public function __construct(){
        
        if(empty ($_SESSION['market3w_user_id'])){
            $_SESSION['market3w_user_id'] = -1;
        }
		
		parent::__construct();
    }
}