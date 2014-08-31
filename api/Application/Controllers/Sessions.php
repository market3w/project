<?php
/**
 * La classe Application_Controllers_Sessions effectue tous les contôles des données liées aux sessions
 * Cette classe fait appel à Application_Models_Sessions pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Sessions{
    /**
     * Stocke le modèle de la table
     * @var object
     */
    protected $table;
    /**
     * Stocke l'alias de la table
     * @var string
     */
    private $as;

    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Sessions($iDB->getConnexion());
        $as = $this->table->getAlias();
    }
    
    /**
     * Vérifie si le token est présent en base de données
     * Initialise la session
     * Si token trouvé : génère un nouveau token et le retourne
     * Sinon retourne null
     * @param string|null $token
     * @return string|null
     */
    public function  init_session($token=null){
        $this->kill_old_sessions();
        $this->table->addWhere("session_token", $token);
        $res = $this->table->search();
        if(array_key_exists(0, $res)){
            $_SESSION["market3w_user_id"]=$res[0]->user_id;
            $new_token = $this->generateToken();
            $test = $this->resfresh_session($token, $new_token);
            if($test!="ok"){
                $_SESSION["market3w_user_id"]=-1;
                $new_token = null;
            }
        } else {
            $_SESSION["market3w_user_id"]=-1;
            $new_token = null;
        }
        $_SESSION["token"]=$new_token;
        return $new_token;
    }
    
    /**
     * Insert en base de données la session
     * @param integer $user_id
     * @return null|string
     */
    public function new_session($user_id){
        $new_token = $this->generateToken();
        $date = date("Y-m-d H:i:s", (time()+7200));
        $this->table->addNewField("session_token", $new_token);
        $this->table->addNewField("user_id", $user_id);
        $this->table->addNewField("session_end", $date);
        if($this->table->insert()=="ok"){
            $_SESSION["market3w_user_id"]=$user_id;
        } else {
            $_SESSION["market3w_user_id"]=-1;
            $new_token=null;
        }
        $_SESSION["token"]=$new_token;
        return $new_token;
    }

    /**
     * Met à jour le token et la date de fin de validité de la session en base de données
     * @param string $token
     * @param string $new_token
     * @return string
     */
    public function resfresh_session($token,$new_token){
        $date = date("Y-m-d H:i:s", (time()+7200));
        $this->table->addNewField("session_token", $new_token);
        $this->table->addNewField("session_end", $date);
        $this->table->addWhere("session_token", $token);
        return $this->table->update();
    }
    
    /**
     * Supprime la session en base de données
     * @param string $token
     * @return string
     */
    public function kill_session($token){
        $this->kill_old_sessions();
        $this->table->addWhere("session_token", $token);
        $delete = $this->table->delete();
        $this->table->resetObject();
        $_SESSION["token"]=null;
        return $delete;
    }
    
    /**
     * Supprime toutes les sessions dont la date d'expiration est dépassée en base de données
     */
    private function kill_old_sessions(){
        $date = date("Y-m-d H:i:s");
        $this->table->addWhere("session_end", $date, "", "", "<");
        $this->table->delete();
        $this->table->resetObject();
    }

    /**
     * Génère un token unique
     * @return string
     */
    private function generateToken(){		
        // Faire ... Tant que le token est invalide (au moins une execution)
        do{
            $this->table->resetObject();
            // Initialisation du token
            $random_string = "";
            // Caractères acceptés
            $valid_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-";
            // Nombre de caractères acceptés
            $num_valid_chars = strlen($valid_chars);

            // Selection de 15 caractères
            for ($i = 0; $i < 30; $i++)
            {
                $random_pick = mt_rand(1, $num_valid_chars);
                $random_char = $valid_chars[$random_pick-1];
                $random_string .= $random_char;
            }
            // Test que le token est unique
            $this->table->addWhere("session_token",$random_string);
            $res = $this->table->search();
            // Si le token est unique, le définir comme valide, sinon le définir comme invalide
            if(!array_key_exists(0,$res)){
                $token_valid = true;
            } else {
                $token_valid = false;
            }
        }while($token_valid===false);
        $this->table->resetObject();
        return $random_string;
    }
}