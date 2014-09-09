<?php 
if($_SESSION["market3w_user"]=="")
{
	header("Location: login.php"); die;
}
$currentuser = $client->get_currentuser();
$currentuser = $currentuser[0];
?>

<form action="<?php echo WEB_ROOT.'login.php'; ?>" name="deconnexionForm" id="deconnexionForm" method="POST" style="display:none;"><input type="hidden" name="method" value="logout"/></form>
<body>
<?php
//affichage d'une alerte en cas d'erreur du serveur
if($_SESSION["errorServer"]!=""){
?>
    <script>
        alert("<?php echo $_SESSION["errorServer"]; ?>");
    </script>
<?php } ?>
<!-- popup -->
<div class="fermer_pop_up" style="position:fixed; cursor:pointer; z-index:13000; display:none; background-color: rgba(0, 0, 0, 0.70); width:100%; height:100%; "></div>
<div class="popup_rdv" style="position:fixed; overflow:auto; display:none;z-index:14000;background-color:#ffffff; width:80%; max-height:70%; margin-top:5%; margin-left:10%; margin-right:10%;">
    <div style="background-color:#81B7CF;color:#ffffff; padding:10px; text-align:center; font-size:16px;">Détails du rendez-vous<div style="float:right; cursor:pointer;" class="fermer_pop_up">X</div></div>
    <?php if($_SESSION["errorMessage"]!=""){ ?>
    <div style="background-color:#e51212;color:#ffffff; padding:3px; text-align:center; font-size:12px;"><b><?php echo $_SESSION["errorMessage"]; ?></b></div>
    <?php } ?>
    <form id="add-appointment" class="form-horizontal" style="margin:15px 15px 35px;" method="POST">
            <input type="hidden" name="method" value="add_appointment">
            <?php if($currentuser_role_id==4){ ?>
            <input type="hidden" name="user_id" value="<?php echo $currentuser->user_id; ?>">
            <?php } elseif ($currentuser_role_id==2 || $currentuser_role_id==4) { ?>
            <input type="hidden" name="webmarketter_id" value="<?php echo ($currentuser_role_id==2)?$currentuser->user_id:$currentuser->webmarketter_id; ?>">
            <?php } ?>
            <fieldset>
                <div class="control-group">											
                    <label class="control-label" for="appointment_name">Intitulé rendez-vous</label>
                    <div class="controls">
                        <input type="text" class="span4" name="appointment_name" value="<?php echo (isset($_POST["appointment_name"]))?$_POST["appointment_name"]:""; ?>">
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" for="appointment_description">Description</label>
                    <div class="controls">
                        <textarea class="span8" name="appointment_description"><?php echo (isset($_POST["appointment_description"]))?$_POST["appointment_description"]:""; ?></textarea>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" for="appointment_start_date">Début</label>
                    <div class="controls">
                        <input type="text" class="span2" name="appointment_start_date" value="<?php echo (isset($_POST["appointment_start_date"]))?$_POST["appointment_start_date"]:""; ?>">
                        <input type="text" class="span2" name="appointment_start_date2" value="<?php echo (isset($_POST["appointment_start_date2"]))?$_POST["appointment_start_date2"]:""; ?>">
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
        
                <div class="control-group">											
                    <label class="control-label" for="appointment_end_date">Fin</label>
                    <div class="controls">
                        <input type="text" class="span2" name="appointment_end_date" value="<?php echo (isset($_POST["appointment_end_date"]))?$_POST["appointment_end_date"]:""; ?>">
                        <input type="text" class="span2" name="appointment_end_date2" value="<?php echo (isset($_POST["appointment_end_date2"]))?$_POST["appointment_end_date2"]:""; ?>">
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <?php if($currentuser_role_id==1) { ?>
                <div class="control-group">											
                    <label class="control-label" for="webmarketter_id">Webmarketeur</label>
                    <div class="controls">
                        <select name="webmarketter_id">
                            <option value="1"<?php echo (isset($_POST["webmarketter_id"]) && $_POST["webmarketter_id"]=="1")?' selected="selected"':""; ?>>Webmarketeur1</option>
                            <option value="2"<?php echo (isset($_POST["webmarketter_id"]) && $_POST["webmarketter_id"]=="2")?' selected="selected"':""; ?>>Webmarketeur2</option>
                            <option value="3"<?php echo (isset($_POST["webmarketter_id"]) && $_POST["webmarketter_id"]=="3")?' selected="selected"':""; ?>>Webmarketeur3</option>
                        </select>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <?php } ?>
                
                <?php if($currentuser_role_id==2 || $currentuser_role_id==1) { ?>
                <?php if($currentuser_role_id==2) {
                    $users = $client->get_alluserbywebmarketter();
                } else {
                    $user = array();
                } ?>
                <div class="control-group">											
                    <label class="control-label" for="user_id">Interlocuteur</label>
                    <div class="controls">
                        <select name="user_id">
                            <option value="">Sélectionnez un interlocuteur</option>
                            <?php foreach ($users as $user) { ?>
                            <option value="<?php echo $user->user_id; ?>"<?php echo (isset($_POST["user_id"]) && $_POST["user_id"]==$user->user_id)?' selected="selected"':""; ?>><?php echo $user->user_firstname; ?> <?php echo $user->user_name; ?> (<?php echo $user->user_company->company_name; ?>)</option>
                            <?php } ?>
                        </select>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <?php } ?>
        
                <div class="control-group">											
                    <label class="control-label" for="type_id">Type de rendez-vous</label>
                    <div class="controls">
                        <select name="type_id">
                            <option value="2"<?php echo (isset($_POST["type_id"]) && $_POST["type_id"]=="2")?' selected="selected"':""; ?>>Physique</option>
                            <option value="3"<?php echo (isset($_POST["type_id"]) && $_POST["type_id"]=="3")?' selected="selected"':""; ?>>Appel téléphonique</option>
                            <option value="1"<?php echo (isset($_POST["type_id"]) && $_POST["type_id"]=="1")?' selected="selected"':""; ?>>Vidéo-conférence</option>
                        </select>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <br />
                <center><button type="submit" class="btn">Ajouter le rendez-vous</button></center>
            </fieldset>
        </form>
        <form id="edit-appointment" class="form-horizontal" style="margin:15px 15px 35px;" method="POST">
            <input type="hidden" name="method" value="">
            <input type="hidden" name="appointment_id" value="<?php echo (isset($_POST["appointment_id"]))?$_POST["appointment_id"]:""; ?>">
            <input type="hidden" name="user_id" value="<?php echo (isset($_POST["user_id"]))?$_POST["user_id"]:""; ?>">
            <input type="hidden" name="webmarketter_id" value="<?php echo (isset($_POST["webmarketter_id"]))?$_POST["webmarketter_id"]:""; ?>">
            <fieldset>
                <div class="control-group">											
                    <label class="control-label" for="appointment_name">Intitulé rendez-vous</label>
                    <div class="controls">
                        <input type="text" class="span4" name="appointment_name" value="<?php echo (isset($_POST["appointment_name"]))?$_POST["appointment_name"]:""; ?>">
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" for="appointment_description">Description</label>
                    <div class="controls">
                        <textarea class="span8" name="appointment_description"><?php echo (isset($_POST["appointment_description"]))?$_POST["appointment_description"]:""; ?></textarea>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" for="appointment_start_date">Début</label>
                    <div class="controls">
                        <input type="text" class="span2" name="appointment_start_date" value="<?php echo (isset($_POST["appointment_start_date"]))?$_POST["appointment_start_date"]:""; ?>">
                        <input type="text" class="span2" name="appointment_start_date2" value="<?php echo (isset($_POST["appointment_start_date2"]))?$_POST["appointment_start_date2"]:""; ?>">
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
        
                <div class="control-group">											
                    <label class="control-label" for="appointment_end_date">Fin</label>
                    <div class="controls">
                        <input type="text" class="span2" name="appointment_end_date" value="<?php echo (isset($_POST["appointment_end_date"]))?$_POST["appointment_end_date"]:""; ?>">
                        <input type="text" class="span2" name="appointment_end_date2" value="<?php echo (isset($_POST["appointment_end_date2"]))?$_POST["appointment_end_date2"]:""; ?>">
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
        
                <div class="control-group">											
                    <label class="control-label" for="type_id">Type de rendez-vous</label>
                    <div class="controls">
                        <select name="type_id">
                            <option value="2"<?php echo (isset($_POST["type_id"]) && $_POST["type_id"]=="2")?' selected="selected"':""; ?>>Physique</option>
                            <option value="3"<?php echo (isset($_POST["type_id"]) && $_POST["type_id"]=="3")?' selected="selected"':""; ?>>Appel téléphonique</option>
                            <option value="1"<?php echo (isset($_POST["type_id"]) && $_POST["type_id"]=="1")?' selected="selected"':""; ?>>Vidéo-conférence</option>
                        </select>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
        
                <div class="control-group">											
                    <label class="control-label" for="status_id">Statut</label>
                    <div class="controls">
                        <select name="status_id">
                            <option value="1"<?php echo (isset($_POST["status_id"]) && $_POST["status_id"]=="1")?' selected="selected"':""; ?>>A confirmer</option>
                            <option value="2"<?php echo (isset($_POST["status_id"]) && $_POST["status_id"]=="2")?' selected="selected"':""; ?>>Confirmé</option>
                        </select>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <br />
                <center><button type="button" id="appointment_edit" class="btn">Modifier le rendez-vous</button><button type="button" class="btn" id="appointment_cancel" style="background-color:#e51212; color: #ffffff; margin-left: 50px;">Annuler le rendez-vous</button><button type="button" id="appointment_valid" class="btn" style="background-color:#218c0c; color: #ffffff; margin-left: 50px;">Le rendez-vous est effectué</button></center>
            </fieldset>
        </form>
    </div> 			
</div>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" style="margin-top:-5px;" href="<?php echo VITRINE_ROOT; ?>index.php"><img src="img/logo_mini.png" alt="logo market3w" width="130" /> </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
        
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $currentuser->user_name; ?>  <?php echo $currentuser->user_firstname; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
            <li><a href="v">Revenir au site</a></li>
              <li><a href="<?php echo WEB_ROOT.'profil.php'; ?>">Mon profil</a></li>
              <li><a href="#" class="deconnexion">Déconnexion</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Rechercher">
        </form>
        
     
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>

<!-- /navbar -->