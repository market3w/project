<?php if(isset($_GET['aff']) && $_GET['aff']!=''){ $aff = $_GET['aff'];}else{$aff='clients';}
$users = $client->get_all_users(); ?>
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Tableau de bord</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li  <?php if($aff=='clients'){echo 'class="active"';} ?> > <a href="#clients" data-toggle="tab">Clients</a></li>
                           <li  <?php if($aff=='prospects'){echo 'class="active"';} ?> > <a href="#prospects" data-toggle="tab">Prospects</a></li>
						  <li  <?php if($aff=='visiteurs'){echo 'class="active"';} ?> > <a href="#visiteurs" data-toggle="tab">Visiteurs</a></li>
						 
                          <li  <?php if($aff=='entreprise'){echo 'class="active"';} ?>><a href="#entre" data-toggle="tab">Ajouter une entreprise</a></li>
                      		   </ul>
						
						<br>
						
							<div class="tab-content">
                           		<div class="tab-pane <?php if($aff=='clients'){echo 'active';} ?>" id="clients">
									<?php if(count($users["clients"])>0){ ?>
                                    
                                
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom client</td><td>Société</td></tr>
                                    <?php foreach($users["clients"] as $key=>$value){ ?>
                                    <tr><td><a href="#"><?php echo $value->user_firstname; ?> <?php echo $value->user_name; ?></a></td><td><a href="#"><?php echo $value->user_company->company_name; ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de clients encore inscrit';} ?>
								</div>
                                
                                <div class="tab-pane <?php if($aff=='prospects'){echo 'active';} ?>" id="prospects">
									<?php if(count($users["prospects"])>0){ ?>
                                    
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom client</td><td>Société</td></tr>
                                    <?php foreach($users["prospects"] as $key=>$value){ ?>
                                    <tr><td><a href="#"><?php echo $value->user_firstname; ?> <?php echo $value->user_name; ?></a></td><td><a href="#"><?php echo $value->user_company->company_name; ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de prospects encore inscrit';} ?>

								</div>
                                
                                 <div class="tab-pane <?php if($aff=='visiteurs'){echo 'active';} ?>" id="visiteurs">
										
									<?php if(count($users["visiteurs"])>0){ ?>
                                    
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom client</td></tr>
                                    <?php foreach($users["visiteurs"] as $key=>$value){ ?>
                                    <tr><td><a href="#"><?php echo $value->user_firstname; ?> <?php echo $value->user_name; ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de visiteurs encore inscrit';} ?>

								</div>
                                
								<div class="tab-pane <?php if($aff=='entreprise'){echo 'active';} ?>" id="entre">
									<form id="edit-profile" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="campany_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_name" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="campany_siret">Siret</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_siret" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="campany_siren">Siren</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_siren" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="campany_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_adress" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="campany_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" id="campany_adress2" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="campany_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_town" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="campany_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_zipcode" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="campany_nb_employees">Nombre d'employés</label>
											<div class="controls">
												<input type="text" class="span4" id="campany_nb_employees" value="">
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
