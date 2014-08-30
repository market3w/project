<?php
/**
 * La classe Application_Controllers_Documents effectue tous les contôles des données liées aux documents
 * Cette classe fait appel à Application_Models_Documents pour agir sur la base de données
 * 
 * @author Group FKVJ <group.fkvj@gmail.com>
 * @copyright (c) 2014, Group FKVJ
 */
class Application_Controllers_Documents extends Library_Core_Controllers{
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
     * Liste des champs à récupérer de la table liée
     * @var array
     */
    private $document_vars = array('document_id',
                                    'document_name',
                                    'document_description',
                                    'document_link',
                                    'document_date',
                                    'document_auteur',
                                    'user_id',
                                    'author_id');
	
    /**
     * Méthode magique __construct()
     * Stocke la liaision avec la table
     * Récupère l'alias de la table
     * @global object $iDB
     */
    public function __construct(){
        global $iDB;
        $this->table = new Application_Models_Documents($iDB->getConnexion());
            $as = $this->table->getAlias();
    }
	
    /**
     * Récupère un document en fonction de son id
     * Récupère les détails du client lié
     * @param array $data
     * @return object
     */
    public function get_document($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupére le document et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {
            $document_id = (empty ($data['document_id']))?null:$data['document_id'];
            if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
            if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' is not numeric');}
            $this->table->addJoin("users","u","user_id","user_id","","left");
            $this->table->addWhere("document_id",$document_id);
            //Si un membre veut recupérer un document, on vérifie que celui-ci lui appartienne sinon le document sera "not found"
            if($role_id==3){$this->table->addWhere("user_id",$user_id);}
            $res = (array)$this->table->search();
            $tab = array();

            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, 'document not found');
            }

            foreach($res[0] as $k=>$v){
                if(!(strpos($k,"user")===false)){
                    $tab['document_user'][$k]=$v;
                } elseif(in_array($k,$this->document_vars)) {
                    $tab[$k] = $v;
                }
            }
			
            if($tab['document_user']['user_id']!=null)
            {
                $tab['document_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab['document_user']['user_id'];
            }
            return $this->setApiResult($tab);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
	
    /**
     * Récupère tous les documents d'un client
     * Récupère les détails du client lié
     * @param array $data
     * @return object
     */
    public function get_alldocument_user($data){
        $user_id = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupére les documents et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
        if($role_id==1 || $role_id==2 || $role_id==4 )
        {
            //Si c'est un admin ou webmarketeur qui accéde aux dossier du client, il devra renseigne l'id du client
            if($role_id!=4)
            {
                $user_id = (empty ($data['user_id']))?null:$data['user_id'];
                if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
                if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' is not numeric');}
            }

            $this->table->addWhere("user_id",$user_id);
			$this->table->addOrder('document_date' , "desc");
            $res = (array)$this->table->search();

            if(!array_key_exists(0,$res)){
                return $this->setApiResult(false, true, ' no documents found');
            }

            return $this->setApiResult($res);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
	
    /* PAS FORCEMMENT TRES UTILE CETTE FONCTION
    public function get_alldocument($data){
	$this->table->addJoin("users","u","user_id","user_id","","left");
        $res = (array)$this->table->search();
        $tab = array();
        if(!array_key_exists(0,$res)){
            return $this->setApiResult(false, true, ' no documents found');
        }
        foreach($res as $k=>$v){
            foreach($v as $k2=>$v2){
                if(!(strpos($k2,"user")===false)){
                    $tab[$k]['document_user'][$k2]=$v2;
                } elseif(in_array($k2,$this->document_vars)) {
                    $tab[$k][$k2] = $v2;
                }
            }
            if($tab[$k]['document_user']['user_id']!=null){
                $tab[$k]['document_user']['user_url']=API_ROOT."?method=user&user_id=".(int)$tab[$k]['document_user']['user_id'];
            }
        }
        return $this->setApiResult($tab);
    }
    */
    
    /**
     * Ajoute un document
     * @param array $data
     * @return object
     */
    public function post_document($data){
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;
		
		
        //Si c'est un administrateur ou webmarketeur ou client ils peuvent ajouter des docs 
        if($role_id==1 || $role_id==2 || $role_id==4 )
        {
            $document_name = (empty ($data['document_name']))?null:$data['document_name'];
            $document_description = (empty ($data['document_description']))?null:$data['document_description'];
            $document_file = $this->get_file($data['document_file']);
            $dossier = (empty ($document_file['upload_root']))?null:$document_file['upload_root'];
            $document_auteur =  $user_id_connecte;
            //Si admin ou webmarketeur on attend un id de client ou prospect pour indiquer quel client 
            if($role_id!=4){$user_id = (empty ($data['user_id']))?null:$data['user_id'];}
            else{ $user_id = $user_id_connecte;}
            // Tests des variables

            if($document_name==null){return $this->setApiResult(false, true, 'param \'document_name\' undefined');}
            if($document_file==null){return $this->setApiResult(false, true, 'param \'document_file\' undefined');}
            if($document_description==null){return $this->setApiResult(false, true, 'param \'document_description\' undefined');}
            //if($document_link==null){return $this->setApiResult(false, true, 'param \'document_link\' undefined');}
            if($user_id==null){return $this->setApiResult(false, true, 'param \'user_id\' undefined');}
            if(!is_numeric($user_id)){return $this->setApiResult(false, true, 'param \'user_id\' must be numeric');}


            $temp = explode("\\", $document_file['document']['name']);
            $fichier = $temp[(count($temp)-1)];
            //$fichier = basename($document_file['document']['name']);


            $taille_maxi = 1000000;

            $taille = filesize($document_file['document']['tmp_name']);

            $extensions = array('.png', '.gif', '.jpg', '.jpeg');

            $extension = strrchr($document_file['document']['name'], '.'); 


            //Début des vérifications de sécurité...
            if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                return $this->setApiResult(false, true, 'bad extension');
            }
            if($taille>$taille_maxi)
            {
                return $this->setApiResult(false, true, 'document too big');
            }

            //On formate le nom du fichier ici...
            $fichier = strtr($fichier, 
                      'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                      'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
			
			if(!file_exists($dossier.$user_id))
			{
				mkdir($dossier.$user_id, 0777);
			}
			if(!file_exists($dossier.$user_id.'/documents'))
			{
				mkdir($dossier.$user_id.'/documents', 0777);
			}
				
			if(!file_exists($dossier.$user_id.'/documents/'.$fichier))
			{
				
				if(copy($document_file['document']['tmp_name'], $dossier .$user_id.'/documents/'. $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
				{
					unlink($document_file['document']['tmp_name']); //Supprime le fichier temporaire
					// echo 'Upload effectué avec succès !';
				}
				else //Sinon (la fonction renvoie FALSE).
				{
					unlink($document_file['document']['tmp_name']); //Supprime le fichier temporaire
					return $this->setApiResult(false, true, 'download fail');
				}
			}
			//Si le fichier existe on indique une erreur
			else
			{
				return $this->setApiResult(false, true, 'file already exist');
			}
			
            $document_link = INTRANET_ROOT . "upload/".$user_id.'/documents/' . $fichier;

            // Préparation de la requete
            $this->table->addNewField("document_name",$document_name);
            $this->table->addNewField("document_description",$document_description);
            $this->table->addNewField("document_link",$document_link);
            //$this->table->addNewField("document_auteur",$document_auteur);
            $this->table->addNewField("user_id",$user_id);
			$this->table->addNewField("author_id",$user_id_connecte);
            $insert = $this->table->insert();
            if($insert!="ok"){
                return $this->setApiResult(false, true, $insert);
            }
            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }

    /**
     * Modifie un document
     * @param array $data
     * @return object
     */
    public function put_document($data){
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ou client ils peuvent modifier leur docs 
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {
            // Récupération des parametres utiles
            $document_id = (empty ($data['document_id']))?null:$data['document_id'];
            $document_name = (empty ($data['document_name']))?null:$data['document_name'];
            $document_description = (empty ($data['document_description']))?null:$data['document_description'];
            $document_link = (empty ($data['document_link']))?null:$data['document_link'];


            // Tests des variables
            if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
            if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' must be numeric');}
            if($document_name==null){return $this->setApiResult(false, true, 'param \'document_name\' undefined');}
            if($document_description==null){return $this->setApiResult(false, true, 'param \'document_description\' undefined');}
            if($document_link==null){return $this->setApiResult(false, true, 'param \'document_link\' undefined');}

            // Préparation de la requete
            $this->table->addNewField("document_name",$document_name);
            $this->table->addNewField("document_description",$document_description);
            $this->table->addNewField("document_link",$document_link);
            $this->table->addNewField("document_auteur",$document_auteur);


            $this->table->addWhere("document_id",$document_id);
            if($role_id==3){$this->table->addWhere("user_id",$user_id_connecte);}
            $this->table->update();

            return $this->setApiResult(true);
        }
        else
        {
            return $this->setApiResult(false, true, 'You aren\'t authorized to access this page');
        }
    }
	
    /**
     * Delete un document
     * @param array $data
     * @return object
     */
    public function delete_document($data){
        // l'admin, le ebmarketteur , le client et le prospect pourront supprimer leur document
        $user_id_connecte = ($_SESSION['market3w_user_id']==-1)?null:$_SESSION['market3w_user_id'];
        if($user_id_connecte==null){return $this->setApiResult(false, true, 'you are not logged');}

        $role = new Application_Controllers_Roles();
        $role_res = $role->get_currentrole();
        $role_id = $role_res->response[0]->role_id;

        //Si c'est un administrateur ou webmarketeur ils récupére le document et leur utilisateurs// Sinon si c'est un client il ne peut que recuperer ses documents
        if($role_id==1 || $role_id==2 || $role_id==3 )
        {
            // Récupération des parametres utiles
            $document_id = (empty ($data['document_id']))?null:$data['document_id'];

            // Tests des variables
            if($document_id==null){return $this->setApiResult(false, true, 'param \'document_id\' undefined');}
            if(!is_numeric($document_id)){return $this->setApiResult(false, true, 'param \'document_id\' not numeric');}

            //------------- Test existance en base --------------------------------------------//
            $exist_document = $this->get_document(array("document_id"=>$document_id));
            if($exist_document->apiError==true){ return $this->setApiResult(false,true,'document doesn\'t look existt'); }

            $this->table->addWhere("document_id",$document_id);
            if($role_id==3){$this->table->addWhere("user_id",$user_id_connecte);}
            $this->table->delete();
            return $this->setApiResult(true);
        }
    }
}