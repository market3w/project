<?php 
if($_SESSION["market3w_user"]=="")
{
	header("Location: login.php"); die;
}

?>

<form action="<?php echo WEB_ROOT.'login.php'; ?>" name="deconnexionForm" id="deconnexionForm" method="POST" style="display:none;"><input type="hidden" name="method" value="logout"/></form>
<body>
 <div class="fermer_pop_up" style="position:fixed; cursor:pointer; z-index:13000; display:none; background-color: rgba(0, 0, 0, 0.70); width:100%; height:100%; "></div>
 <div class="popup_rdv" style="position:fixed; overflow:scroll; display:none;z-index:14000; padding:top:15px;background-color:#ffffff; width:80%; height:60%; margin-top:5%; margin-left:10%; margin-right:10%;">
<div style="background-color:#81B7CF;color:#ffffff; fixed; padding:10px; text-align:center; font-size:16px;">Intitulé rendez-vous<div style="float:right; cursor:pointer;" class="fermer_pop_up">X</div></div>
 <form id="edit-profile" class="form-horizontal" style="margin:15px;">
    <fieldset>
        
        <div class="control-group">											
            <label class="control-label" for="appointment_name">Intitulé rendez-vous</label>
            <div class="controls">
                <input type="text" class="span4" name="appointment_name" value="">
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        
        <div class="control-group">											
            <label class="control-label" for="appointment_description">Description</label>
            <div class="controls">
                <textarea class="span8" name="appointment_description"></textarea>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        
           <div class="control-group">											
            <label class="control-label" for="appointment_name">Début</label>
            <div class="controls">
                <input type="text" class="span2" name="appointment_start_date" value="">
                <input type="text" class="span2" name="appointment_start_date2" value="">
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        
        <div class="control-group">											
            <label class="control-label" for="appointment_name">Fin</label>
            <div class="controls">
                <input type="text" class="span2" name="appointment_end_date" value="">
                <input type="text" class="span2" name="appointment_end_date2" value="">
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        
          <div class="control-group">											
            <label class="control-label" for="appointment_name">Type de rendez-vous</label>
            <div class="controls">
               <select name="appointment_select">
               	<option>Physique</option>
                <option>Appel téléphonique</option>
                <option>Vidéo-conférence</option>
               </select>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
    
         <br />
        <center><button type="submit" class="btn">Ajouter</button> </center>
            
    </fieldset>
</form>
 </div> 			
        
   </div>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" style="margin-top:-5px;" href="<?php echo VITRINE_ROOT; ?>index.php"><img src="img/logo_mini.png" width="130" /> </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
        
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $currentuser->user_name; ?>  <?php echo $currentuser->user_firstname; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
            <li><a href="v">Revenir au site</a></li>
              <li><a href="<?php echo WEB_ROOT.'profil.php'; ?>">Mon profil</a></li>
              <li><a href="#" class="deconnexion">Déconnexion</a></li>
              <li><a href="#" class="clic_rdv">CLIC RDV</a></li>
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