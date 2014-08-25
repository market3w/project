<?php  $page='index';

if(isset($_GET['aff']) && $_GET['aff']!=''){$aff = $_GET['aff'];}else{$aff='infos_perso';} ?>
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
	      				<i class="icon-dashboard"></i>
	      				<h3>Nom client / prospect / visiteur</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li  <?php if($aff=='infos_perso'){echo 'class="active"';} ?> > <a href="#infos_perso" data-toggle="tab">Infos personnelles</a></li>
    					  <li  <?php if($aff=='entreprise'){echo 'class="active"';} ?>><a href="#entre" data-toggle="tab">Entreprise</a></li>
                           <li  <?php if($aff=='document'){echo 'class="active"';} ?>><a href="#doc" data-toggle="tab">Télécharger un Document</a></li>
						    <li  <?php if($aff=='campagnes'){echo 'class="active"';} ?>><a href="#campagnes" data-toggle="tab">Ses campagnes</a></li>
                             <li  <?php if($aff=='ajout_campagne'){echo 'class="active"';} ?>><a href="#ajout_campagne" data-toggle="tab">Ajouter une campagne</a></li>
					<li  <?php if($aff=='factures'){echo 'class="active"';} ?>><a href="#factures" data-toggle="tab">Ses factures</a></li>
                             <li  <?php if($aff=='ajout_facture'){echo 'class="active"';} ?>><a href="#ajout_facture" data-toggle="tab">Ajouter une facture</a></li>
						</ul>
						
						<br>
						
							<div class="tab-content">
								<div class="tab-pane <?php if($aff=='infos_perso'){echo 'active';} ?>" id="infos_perso">
										
									<form id="edit-profile" class="form-horizontal">
									<fieldset>
										
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
												<input type="text" class="span4" id="user_name" value="John">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_firstname">Prénom</label>
											<div class="controls">
												<input type="text" class="span4" id="user_firstname" value="Donga">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="email">Adresse email</label>
											<div class="controls">
												<input type="text" class="span4" id="email" value="john.donga@egrappler.com">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="user_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" id="user_adress" value="11 Rue de l'éléphant">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" id="user_adress2" value="Dans la fôret">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" id="user_town" value="Paris">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" id="user_zipcode" value="75123">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_phone">Téléphone</label>
											<div class="controls">
												<input type="text" class="span4" id="user_phone" value="0102030405">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_mobile">Portable</label>
											<div class="controls">
												<input type="text" class="span4" id="user_mobile" value="0601020304">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                          <div class="control-group">											
											<label class="control-label" for="user_function">Poste occupé</label>
											<div class="controls">
												<input type="text" class="span4" id="user_function" value="75123">
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
									<form id="edit-profile" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="campany_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_name" value="nom entreprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="campany_siret">Siret</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_siret" value="siret entreprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="campany_siren">Siren</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_siren" value="siren entreprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="campany_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_adress" value="adresse entreprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="campany_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" id="campany_adress2" value="adresse 2 erntreprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="campany_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_town" value="ville entreprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="campany_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_zipcode" value="code postal en treprise">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="campany_nb_employees">Nombre d'employés</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_nb_employees" value="55">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
                                        
										 <br />
										
										<div class="form-actions">
											<center><button type="submit" class="btn btn-primary">Ajouter</button> </center>
											<!--<button class="btn">Cancel</button>-->
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
								</div>
                                
                                <div class="tab-pane <?php if($aff=='document'){echo 'active';} ?>" id="doc">
									<form id="edit-profile" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="document_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" id="document_name" value="John">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="document_description">Description</label>
											<div class="controls">
												<textarea class="span4" id="document_description"></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="document_description">Télécharger</label>
											<div class="controls">
												<input type="file" />
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
                                        
										 <br />
								
										<div class="form-actions">
											<center><button type="submit" class="btn btn-primary">Télécharger le document</button> </center>
											<!--<button class="btn">Cancel</button>-->
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
								</div>
                                
                                <div class="tab-pane <?php if($aff=='campagnes'){echo 'active';} ?>" id="campagnes">
							
								<table width="100%" style="margin-top:-25px;"><tr><td>Nom campagne</td><td>date</td>
                                <tr><td><a href="#">Campagne 1</a></td><td><a href="#">22 juin 2014</a></td></tr>
                                <tr><td><a href="#">Campagne 2</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 3</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 4</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 5</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 6</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 7</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 8</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 9</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Campagne 10</a></td><td><a href="#">22 juin 2014</a></td></tr>
                             </table>
								</div>
                                
                                
                                  <div class="tab-pane <?php if($aff=='ajout_campagne'){echo 'active';} ?>" id="ajout_campagne">
									<form id="add_campains" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="facture_name">Nom Campagne</label>
											<div class="controls">
												<input type="text" class="span4" id="facture_name" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="facture_description">Description</label>
											<div class="controls">
												<textarea class="span4" id="facture_description"></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
								
										 <br />
								
										<div class="form-actions">
											<center><button type="submit" class="btn btn-primary">Ajouter une campagne</button> </center>
											<!--<button class="btn">Cancel</button>-->
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
								</div>
								
                                 <div class="tab-pane <?php if($aff=='factures'){echo 'active';} ?>" id="factures">
							
								<table width="100%" style="margin-top:-25px;"><tr><td>Nom facture</td><td>date</td>
                                <tr><td><a href="#">Facture 1</a></td><td><a href="#">22 juin 2014</a></td></tr>
                                <tr><td><a href="#">Facture 2</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 3</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 4</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 5</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 6</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 7</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 8</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 9</a></td><td><a href="#">22 juin 2014</a></td></tr>
                               <tr><td><a href="#">Facture 10</a></td><td><a href="#">22 juin 2014</a></td></tr>
                             </table>
								</div>
                                
                                
                                  <div class="tab-pane <?php if($aff=='ajout_facture'){echo 'active';} ?>" id="ajout_facture">
									<form id="add_campains" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="facture_name">Nom facture</label>
											<div class="controls">
												<input type="text" class="span4" id="facture_name" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="facture_description">Description</label>
											<div class="controls">
												<textarea class="span4" id="facture_description"></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="facture_download">Télécharger</label>
											<div class="controls">
												<input type="file" />
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
                                        
										 <br />
								
										<div class="form-actions">
											<center><button type="submit" class="btn btn-primary">Ajouter la facture</button> </center>
											<!--<button class="btn">Cancel</button>-->
										</div> <!-- /form-actions -->
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
