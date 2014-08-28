<?php  $page='profil';
include('include/config.php');
if(isset($_GET['aff']) && $_GET['aff']!=''){$aff = $_GET['aff'];}else{$aff='info_perso';} ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Profil | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php'); ?>

<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Mon profil</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li  <?php if($aff=='info_perso'){echo 'class="active"';} ?> >
						    <a href="#inform" data-toggle="tab">Mes informations</a>
						  </li>
						  <li  <?php if($aff=='entreprise'){echo 'class="active"';} ?>><a href="#entre" data-toggle="tab">Entreprise</a></li>
                           <li  <?php if($aff=='mdp'){echo 'class="active"';} ?>><a href="#mdp" data-toggle="tab">Mot de passe</a></li>
                          <li  <?php if($aff=='document'){echo 'class="active"';} ?>><a href="#doc" data-toggle="tab">Télécharger un Document</a></li>
						</ul>
						
						<br>
						
							<div class="tab-content">
								<div class="tab-pane <?php if($aff=='info_perso'){echo 'active';} ?>" id="inform">
                                <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
								<form id="edit-profile" class="form-horizontal" action="profil.php?aff=info_perso" method="post">
									<fieldset>
										<input type="hidden" name="method" value="put_user" />
                                        <input type="hidden" name="user_id" value="<?php echo $currentuser_id; ?>" />
                                          <input type="hidden" name="company_id" value="1" />
										<!--<div class="control-group">											
											<label class="control-label" for="username">Username</label>
											<div class="controls">
												<input type="text" class="span6 disabled" id="username" value="Example" disabled>
												<p class="help-block">Your username is for logging in and cannot be changed.</p>
											</div> <!-- /controls -->				
										<!--</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" name="user_name" value="<?php echo $currentuser->user_name; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_firstname">Prénom</label>
											<div class="controls">
												<input type="text" class="span4" name="user_firstname" value="<?php echo $currentuser->user_firstname; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="email">Adresse email</label>
											<div class="controls">
												<input type="text" class="span4" name="user_email" value="<?php echo $currentuser->user_email; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="user_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" name="user_adress" value="<?php echo $currentuser->user_adress; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" name="user_adress2" value="<?php echo $currentuser->user_adress2; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" name="user_town" value="<?php echo $currentuser->user_town; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" name="user_zipcode" value="<?php echo $currentuser->user_zipcode; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_phone">Téléphone</label>
											<div class="controls">
												<input type="text" class="span4" name="user_phone" value="<?php echo $currentuser->user_phone; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_mobile">Portable</label>
											<div class="controls">
												<input type="text" class="span4" name="user_mobile" value="<?php echo $currentuser->user_mobile; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                          <div class="control-group">											
											<label class="control-label" for="user_function">Poste occupé</label>
											<div class="controls">
												<input type="text" class="span4" name="user_function" value="<?php echo $currentuser->user_function; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                  		
                                        <br/>
                                       
                                        <div class="control-group">											
											<label class="control-label">Inscription à la newsletter</label>
											
                                            
                                            <div class="controls">
                                            <label class="radio inline">
                                              <input type="radio"  name="newsletter" value="oui"> Oui
                                            </label>
                                            
                                            <label class="radio inline">
                                              <input type="radio" name="newsletter" value="non"> Non
                                            </label>
                                          </div>	<!-- /controls -->			
										</div> <!-- /control-group -->
                                      
											
										 <br />
										
											
										<div class="form-actions">
											<center><button type="submit" class="btn btn-primary">Enregistrer</button> </center>
											<!--<button class="btn">Cancel</button>-->
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
                                
								</div>
								
								<div class="tab-pane <?php if($aff=='entreprise'){echo 'active';} ?>" id="entre">
                                	<table width="100%">
									<tr><td style="width:40%">Nom entreprise :</td><td> <b><?php echo ($currentuser->user_company->company_name!='') ? $currentuser->user_company->company_name : ''; ?></b></td></tr>
                                    <tr><td>Siret :</td><td> <b><?php echo ($currentuser->user_company->company_siret!='') ? $currentuser->user_company->company_siret : ''; ?></b></td></tr>
                                    <tr><td>Siren :</td><td> <b><?php echo ($currentuser->user_company->company_siren!='') ? $currentuser->user_company->company_siren : ''; ?></b></td></tr>
                                    <tr><td>Adresse :</td><td> <b><?php echo ($currentuser->user_company->company_adress!='') ? $currentuser->user_company->company_adress : ''; ?></b></td></tr>
                                    <tr><td>Adresse complémentaire <i>(facultatif)</i> :</td><td> <b><?php echo ($currentuser->user_company->company_adress2!='') ? $currentuser->user_company->company_adress2 : '<i>non renseigné</i>';  ?></b></td></tr>
                                    <tr><td>Ville </td><td> <b><?php echo ($currentuser->user_company->company_town!='') ? $currentuser->user_company->company_town : '<i>non renseigné</i>';  ?></b></td></tr>
                                    <tr><td>Code postal :</td><td><b><?php ($currentuser->user_company->company_zipcode!='') ? $currentuser->user_company->company_zipcode : '<i>non renseigné</i>';  ?></b></td></tr>
                                    <tr><td>Nombre d'employés :</td><td> <b><?php echo ($currentuser->user_company->company_nb_employees!='') ? $currentuser->user_company->company_nb_employees : '<i>non renseigné</i>';  ?></b></td></tr>
									</table>
                                    
                                   <br/><br/> Si les données de votre entreprise ne sont plus à jour, merci de nous en infomer via le <a href="contact.php">formuaire de contact</a>. 
                                </div>
                                <div class="tab-pane <?php if($aff=='mdp'){echo 'active';} ?>" id="mdp">
                                 <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
                                 <?php if(isset($_POST['method']) && $_POST['method']=='put_password' && $_SESSION["errorMessage"]==''){echo'mot de passe modifié.';} ?>
                                	<form action="profil.php?aff=mdp" method="post">
                                    <input type="hidden" name="method" value="put_password" />
                                    <input type="hidden" name="user_email" value="<?php echo $currentuser->user_email; ?>" />
                                 		<div class="control-group">											
											<label class="control-label" for="user_password">Nouveau mot de passe</label>
											<div class="controls">
												<input type="password" class="span4" name="user_password" value="" placeholder="Tapez votre nouveau mot de passe">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										<div class="control-group">											
											<label class="control-label" for="user_password">Confirmer mot de passe</label>
											<div class="controls">
												<input type="password" class="span4" name="user_password2" value="" placeholder="Confirmez votre nouveau mot de passe">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        <button type="submit" class="btn btn-primary">Modifier</button> 
											
										
                                </form>
                                    
                                 </div>
                                <div class="tab-pane <?php if($aff=='document'){echo 'active';} ?>" id="doc">
                                <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
									<form class="form-horizontal" action="profil.php?aff=document" enctype="multipart/form-data" method="post">
									<fieldset>
										<input type="hidden" name="method" value="post_document" />
										<div class="control-group">											
											<label class="control-label" for="document_name">Nom document</label>
											<div class="controls">
												<input type="text" class="span4" name="document_name" value="<?php echo (array_key_exists("document_name",$_POST))?$_POST["document_name"]:""; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="document_description"></label>
											<div class="controls">
												<textarea class="span4" name="document_description"><?php echo (array_key_exists("document_description",$_POST))?$_POST["document_description"]:""; ?></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="document_téléchargement">Télécharger </label>
											<div class="controls">
												<input type="file" name="document" />
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
                                        
										 <br />
								
										<button type="submit" class="btn btn-primary">Télécharger</button>
									</fieldset>
								</form>
								</div>
								
							</div>
						  
						  
						</div>
						
						
						
						
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
	      		
		    </div> <!-- /span8 -->
	      	
	      	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
      
     
<!-- /main -->
<?php include('include/footer.php'); ?>
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
 
<script src="js/base.js"></script> 
<script>     

      

        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });
    </script><!-- /Calendar -->
</body>
</html>
