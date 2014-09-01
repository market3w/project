<?php if(isset($_GET['aff']) && $_GET['aff']!=''){ $aff = $_GET['aff'];}else{$aff='clients';}
 if(isset($_GET['view_user_id']) && $_GET['view_user_id']!=''){ $view_user_id = $_GET['view_user_id'];}else{$view_user_id = '';}
  if(isset($_GET['option']) && $_GET['option']!=''){ $option = $_GET['option'];}else{$option = '';}
  if(isset($_GET['option_id']) && $_GET['option_id']!=''){ $option_id = $_GET['option_id'];}else{$option_id = '';}
 
 if(is_numeric($view_user_id))
{
	$user = $client->get_user(array("user_id"=>$view_user_id));
	$allappointmentuser = $client->get_allappointmentuser(array("user_id"=>$view_user_id));
	$alldocumentuser = $client->get_alldocument(array("user_id"=>$view_user_id));
	$allcampainuser = $client->get_allcampain(array("user_id"=>$view_user_id));
	$allfactureuser = $client->get_allpaiement(array("user_id"=>$view_user_id));
	//Si voir détail rendez vous on appelle get_appointment
	if($aff=='rdv' && $option="voir" && is_numeric($option_id))
	{
		$rdvselectuser = $client->get_appointment(array("appointment_id"=>$option_id));
	}
	//Si voir détail document on appelle get_document
	elseif($aff=='documents' && $option="voir" && is_numeric($option_id))
	{
		$documentselectuser = $client->get_document(array("document_id"=>$option_id));
	}
	//Si voir détail campagne on appelle get_campain
	elseif($aff=='campagnes' && is_numeric($option_id))
	{
		$campagneselectuser = $client->get_campain(array("campain_id"=>$option_id));
	}
	//Si voir détail facture on appelle get_paiements
	elseif($aff=='factures' && $option="voir" && is_numeric($option_id))
	{
		$factureselectuser = $client->get_paiement(array("paiement_id"=>$option_id));
	}
}
$users = $client->get_all_users(); ?>
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
           <?php 
		  //Si option sélectionner et si element sélectionner
		  if($option!='' && is_numeric($option_id))
		  {
			  //Si c'est une opton de rendez-vous
			  if($aff=="rdv")
			  { ?>
				  <div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Rendez-vous </h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    <table width="100%" cellpadding="5" cellspacing="5">
                    <tr><td width="30%"><b>Intitulé du rendez-vous :</b></td><td> <?php echo $rdvselectuser[0]->appointment_name; ?></td></tr>
                    <tr><td><b>Description :</b></td><td>  <?php echo $rdvselectuser[0]->appointment_description; ?></td></tr>
                    <tr><td><b>Début : </b></td><td> <?php echo $rdvselectuser[0]->appointment_start_date; ?></td></tr>
                    <tr><td><b>Fin : </b></td><td> <?php echo $rdvselectuser[0]->appointment_end_date; ?></td></tr>
                    <tr><td><b>Webmarketeur :</b></td><td> <?php echo $rdvselectuser[0]->appointment_webmarketter->webmarketter_name; ?></td></tr>
                    <tr><td><b>Statut : </b></td><td><?php echo $rdvselectuser[0]->status_id; ?></td></tr>
                    </table>
                  
                    </div>
                    </div></div>
				<?php		
			  }
			  elseif($aff=="documents")
			  { ?>
				  <div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Document </h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    <table width="100%" cellpadding="5" cellspacing="5">
                    <tr><td width="30%"><b>Nom document</b></td><td> <?php echo $documentselectuser[0]->document_name; ?></td></tr>
                    <tr><td><b>Description :</b></td><td>  <?php echo $documentselectuser[0]->document_description; ?></td></tr>
                    <tr><td><b>Date : </b></td><td> <?php echo $documentselectuser[0]->document_date; ?></td></tr>
                     <tr><td><b>Télécharger le document : </b></td><td> <a class="btn" href="<?php echo $documentselectuser[0]->document_link; ?>">Télécharger</a></td></tr>
                    </table>
                  
                    </div>
                    </div></div>
				<?php		
			  }
			    elseif($aff=="campagnes")
			  { ?>
				  <div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Campagne </h3>
	  				</div> <!-- /widget-header -->
					
                    
					<div class="widget-content">
                   
                   <!-- Si on est dans une modification on afficher formulaire-->
                   <?php if($option=="modifier"){ ?>
                   <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
                  <?php if(isset($_SESSION['method']) && $_SESSION['method']=='put_user'  && $_SESSION["errorMessage"]==''){echo'modification enregistrée avec succés';} ?>
					<form class="form-horizontal" action="index.php.?aff=<?php echo $aff; ?>&view_user_id=<?php echo $user->user_id; ?>&option=<?php echo $option; ?>option_id=&" method="post">
						<fieldset>
							<input type="hidden" name="method" value="put_campain" />
                             <input type="hidden" name="campain_id" value="<?php echo $option_id; ?>" />
                             
					<?php } ?>				
										
                    <table width="100%" cellpadding="5" cellspacing="5">
                    <tr><td width="30%"><b>Nom campagne</b></td>
                    <td> <?php if($option=="modifier")
					{ ?>
						 <input type="text" class="span4" name="campain_name" value="<?php echo $campagneselectuser[0]->campain_name; ?>">
                       <?php					
					}
					else
					{
						echo  $campagneselectuser[0]->campain_name.'!';;
					} ?></td></tr>
                    
                    <tr><td><b>Courte description :</b></td>
                    <td> 
                     <?php if($option=="modifier")
					{ ?>
						 <textarea class="span8" name="campain_courte_description" style="min-height:60px;"><?php echo $campagneselectuser[0]->campain_courte_description.'!'; ?></textarea>
                       <?php					
					}
					else
					{
						echo  $campagneselectuser[0]->campain_courte_description.'!';;
					} ?>
                    </td></tr>
                    <tr><td><b>Description :</b></td><td>
                    <?php if($option=="modifier")
					{ ?>
						 <textarea class="span8" name="campain_description" style="min-height:120px;"><?php echo $campagneselectuser[0]->campain_description.''; ?></textarea>
                       <?php					
					}
					else
					{
						echo  $campagneselectuser[0]->campain_description.'!';;
					} ?>
                    </td></tr>
                   <tr><td><b>Complément d'informations :</b></td><td>
                   <?php if($option=="modifier")
					{ ?>
						<textarea class="span8" name="campain_completion" style="min-height:60px;"><?php echo $campagneselectuser[0]->campain_completion.'!'; ?></textarea>
                       <?php					
					}
					else
					{
						echo  $campagneselectuser[0]->campain_completion.'!';;
					} ?>
                    </td></tr>
                    <tr><td><b>Webmarketeur :</b></td><td> <?php echo $campagneselectuser[0]->campain_webmarketter->webmarketter_name.' '. $campagneselectuser[0]->campain_webmarketter->webmarketter_firstname; ?></td></tr>
                    <tr><td><b>Date de création : </b></td><td> <?php echo $campagneselectuser[0]->campain_date; ?></td></tr>
                    <tr><td><b>Dernière modification : </b></td><td> <?php echo $campagneselectuser[0]->campain_date_modif; ?></td></tr>
                     </table>
                     <?php if($option=="modifier"){ ?>
                    <br/> <center><input type="submit" class="btn" value="Modifier" /></center>
                  	</fieldset>
                    </form>
                    <?php } ?>
                    </div>
                    </div></div>
				<?php		
			  }
			    elseif($aff=="factures")
			  { ?>
				  <div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Facture </h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    <table width="100%" cellpadding="5" cellspacing="5">
                    <tr><td width="30%"><b>Nom facture</b></td><td> <?php echo $factureselectuser[0]->paiement_name; ?></td></tr>
                    <tr><td><b>Description :</b></td><td>  <?php echo $factureselectuser[0]->paiement_description; ?></td></tr>
                   <tr><td><b>Montant HT :</b></td><td>  <?php echo $factureselectuser[0]->paiement_prix; ?> €</td></tr>
                     <tr><td><b>Date d'émission : </b></td><td> <?php echo $factureselectuser[0]->paiement_description; ?></td></tr>
                     <tr><td><b>Télécharger la facture : </b></td><td> <a class="btn" href="<?php echo $factureselectuser[0]->paiement_link; ?>">Télécharger</a></td></tr>
                   
                     </table>
                  
                    </div>
                    </div></div>
				<?php		
			  }
		  ?>
          	
          <?php } ?>
          
          <?php 
		  //Si user sélectionné on affiche alors les informations de l'utilisateur
		  if(is_numeric($view_user_id))
		  {
		  ?>
	      	<div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3><?php echo $user->user_name; ?> <?php echo $user->user_firstname;
						if($user->user_role->role_id==4)
						{
							echo' <i>(Client)</i>';
						}
						elseif($user->user_role->role_id==5)
						{
							echo' <i>(prospect)</i>';
						}
						elseif($user->user_role->role_id==6)
						{
							echo' <i>(Visiteur)</i>';
						}
												
						?> </h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li  <?php if($aff=='infos_perso'){echo 'class="active"';} ?> > <a href="#infos_perso" data-toggle="tab">Infos personnelles</a></li>
    					  <li  <?php if($aff=='entreprise'){echo 'class="active"';} ?>><a href="#entre" data-toggle="tab">Entreprise</a></li>
                          <li  <?php if($aff=='rdv'){echo 'class="active"';} ?>><a href="#rdv" data-toggle="tab">Rendez-vous</a></li>
                           <li  <?php if($aff=='documents'){echo 'class="active"';} ?>><a href="#doc" data-toggle="tab">Documents</a></li>
						    <li  <?php if($aff=='campagnes'){echo 'class="active"';} ?>><a href="#campagnes" data-toggle="tab">Campagnes</a></li>
                            <li  <?php if($aff=='factures'){echo 'class="active"';} ?>><a href="#factures" data-toggle="tab">Factures</a></li>
						</ul>
						
						<br>
						
							<div class="tab-content">
								<div class="tab-pane <?php if($aff=='infos_perso'){echo 'active';} ?>" id="infos_perso">
										
									<span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
                                <?php if(isset($_SESSION['method']) && $_SESSION['method']=='put_user'  && $_SESSION["errorMessage"]==''){echo'modification enregistrée avec succés';} ?>
								<form id="edit-profile" class="form-horizontal" action="index.php.?aff=infos_perso&view_user_id=<?php echo $user->user_id; ?>" method="post">
									<fieldset>
										<input type="hidden" name="method" value="put_user" />
                                        <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>" />
                                          <input type="hidden" name="company_id" value="1" />
									
										<div class="control-group">											
											<label class="control-label" for="user_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" name="user_name" value="<?php echo $user->user_name; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_firstname">Prénom</label>
											<div class="controls">
												<input type="text" class="span4" name="user_firstname" value="<?php echo $user->user_firstname; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="email">Adresse email</label>
											<div class="controls">
												<input type="text" class="span4" name="user_email" value="<?php echo $user->user_email; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="user_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" name="user_adress" value="<?php echo $user->user_adress; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="user_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" name="user_adress2" value="<?php echo $user->user_adress2; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" name="user_town" value="<?php echo $user->user_town; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" name="user_zipcode" value="<?php echo $user->user_zipcode; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_phone">Téléphone</label>
											<div class="controls">
												<input type="text" class="span4" name="user_phone" value="<?php echo $user->user_phone; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="user_mobile">Portable</label>
											<div class="controls">
												<input type="text" class="span4" name="user_mobile" value="<?php echo $user->user_mobile; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                          <div class="control-group">											
											<label class="control-label" for="user_function">Poste occupé</label>
											<div class="controls">
												<input type="text" class="span4" name="user_function" value="<?php echo $user->user_function; ?>">
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
										
											
									<button type="submit" class="btn btn-primary">Enregistrer</button> </center>
										
									</fieldset>
								</form>
								</div>
							
                                
								<div class="tab-pane <?php if($aff=='entreprise'){echo 'active';} ?>" id="entre">
                                	<span class="responseError" id="put_companyError"><?php echo $_SESSION["errorMessage"]; ?></span>
                                <?php if(isset($_SESSION['method']) && $_SESSION['method']=='put_company' && $_SESSION["errorMessage"]==''){echo'modification enregistrée avec succés';} ?>
							
									<form class="form-horizontal" action="index.php.?aff=entreprise&view_user_id=<?php echo $user->user_id; ?>" method="post">
								
                                    <input type="hidden" name="method" value="put_company" />
                                        <input type="hidden" name="company_id" value="<?php echo $user->user_company->company_id; ?>" />
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="company_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" name="company_name" value="<?php echo $user->user_company->company_name; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="company_siret">Siret</label>
											<div class="controls">
												<input type="text" class="span4" name="company_siret" value="<?php echo $user->user_company->company_siret; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="company_siren">Siren</label>
											<div class="controls">
												<input type="text" class="span4" name="company_siren" value="<?php echo $user->user_company->company_siren; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="company_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" name="company_adress" value="<?php echo $user->user_company->company_adress; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="company_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" name="company_adress2" value="<?php echo $user->user_company->company_adress2; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="company_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" name="company_town" value="<?php echo $user->user_company->company_town; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="company_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" name="company_zipcode" value="<?php echo $user->user_company->company_zipcode; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="company_nb_employees">Nombre d'employés</label>
											<div class="controls">
												<input type="text" class="span4" name="company_nb_employees" value="<?php echo $user->user_company->company_nb_employees; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
                                        
										 <br />
										
											<button type="submit" class="btn btn-primary">Modifier</button>
											
									</fieldset>
								</form>
								</div>
                                
                                 <div class="tab-pane <?php if($aff=='rdv'){echo 'active';} ?>" id="rdv">
							
								<?php if(count($allappointmentuser)>0){ ?>
                                    
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Intitulé rendez-vous</td><td>Début rendez-vous</td><td>Fin rendez-vous</td><td>Webmarketeur</td><td>Statut</td></tr>
                                    <?php foreach($allappointmentuser as $key=>$value){ ?>
                                    <tr><td><a href="index.php?aff=rdv&view_user_id=<?php echo $value->appointment_user->user_id; ?>&option=voir&option_id=<?php echo $value->appointment_id; ?>"><?php echo $value->appointment_name; ?></a></td><td><?php echo $value->appointment_start_date; ?></td><td><?php echo $value->appointment_end_date; ?></td><td><?php echo $value->appointment_webmarketter->webmarketter_name.' '.$value->appointment_webmarketter->webmarketter_firstname; ?></td><td>A changer</td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de rendez-vous programmés ou réalisés pour cet utilisateur.';} ?>
								</div>
                                
                                
                                <div class="tab-pane <?php if($aff=='documents'){echo 'active';} ?>" id="doc">
								
                                <?php if(count($alldocumentuser)>0){ ?>
                                    
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Intitulé document</td><td>Date</td></tr>
                                    <?php foreach($alldocumentuser as $key=>$value){ ?>
                                    <tr><td><a href="index.php?aff=documents&view_user_id=<?php echo $value->user_id; ?>&option=voir&option_id=<?php echo $value->document_id; ?>"><?php echo $value->document_name; ?></a></td><td><?php echo $value->document_date; ?></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de documents téléchargés pour cet utilisateur.';} ?>
								</div>
                                
								
                                
                                <div class="tab-pane <?php if($aff=='campagnes'){echo 'active';} ?>" id="campagnes">
							 	<?php if(count($allcampainuser)>0){ ?>
                                    
								 <table width="100%" style="margin-top:-25px;"><tr><td>Intitulé campagne</td><td>Dernière modification</td></tr>
                                    <?php foreach($allcampainuser as $key=>$value){ ?>
                                    <tr><td><a href="index.php?aff=campagnes&view_user_id=<?php echo $value->contact_id; ?>&option=voir&option_id=<?php echo $value->campain_id; ?>"><?php echo $value->campain_name; ?></a></td><td><?php echo $value->campain_date_modif; ?></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de campagnes effectués ou en préparation pour cet utilisateur.';} ?>
								</div>
                                
								
                                 <div class="tab-pane <?php if($aff=='factures'){echo 'active';} ?>" id="factures">
							
								<?php if(count($allfactureuser)>0){ ?>
                                    
								 <table width="100%" style="margin-top:-25px;"><tr><td>Intitulé facture</td><td>Date</td></tr>
                                    <?php foreach($allfactureuser as $key=>$value){ ?>
                                    <tr><td><a href="index.php?aff=factures&view_user_id=<?php echo $view_user_id; ?>&option=voir&option_id=<?php echo $value->paiement_id; ?>"><?php echo $value->paiement_name; ?></a></td><td><?php echo $value->paiement_date; ?></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de fatures enregistrés pour cet utilisateur.';} ?>
								</div>
                                
                                
							</div>
						  
						  
						</div>
						
						
						
						
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
	      		
		    </div> <!-- /span12 -->
            <?php } ?>
            <!-- fin si user sélectionné -->
            
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
                                    <tr><td><a href="index.php?aff=clients&view_user_id=<?php echo $value->user_id; ?>"><?php echo $value->user_firstname; ?> <?php echo $value->user_name; ?></a></td><td><a href="#"><?php echo $value->user_company->company_name; ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de clients encore inscrit';} ?>
								</div>
                                
                                <div class="tab-pane <?php if($aff=='prospects'){echo 'active';} ?>" id="prospects">
									<?php if(count($users["prospects"])>0){ ?>
                                    
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom client</td><td>Société</td></tr>
                                    <?php foreach($users["prospects"] as $key=>$value){ ?>
                                    <tr><td><a href="index.php?aff=prospects&view_user_id=<?php echo $value->user_id; ?>"><?php echo $value->user_firstname; ?> <?php echo $value->user_name; ?></a></td><td><a href="#"><?php echo $value->user_company->company_name; ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de prospects encore inscrit';} ?>

								</div>
                                
                                 <div class="tab-pane <?php if($aff=='visiteurs'){echo 'active';} ?>" id="visiteurs">
										
									<?php if(count($users["visiteurs"])>0){ ?>
                                    
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom client</td></tr>
                                    <?php foreach($users["visiteurs"] as $key=>$value){ ?>
                                    <tr><td><a href="index.php?aff=visiteurs&view_user_id=<?php echo $value->user_id; ?>"><?php echo $value->user_firstname; ?> <?php echo $value->user_name; ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de visiteurs encore inscrit';} ?>

								</div>
                                
								<div class="tab-pane <?php if($aff=='entreprise'){echo 'active';} ?>" id="entre">
									<form id="edit-profile" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="company_name">Nom</label>
											<div class="controls">
												<input type="text" class="span4" id="company_name" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="company_siret">Siret</label>
											<div class="controls">
												<input type="text" class="span4" id="company_siret" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="company_siren">Siren</label>
											<div class="controls">
												<input type="text" class="span4" id="company_siren" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
                                        <div class="control-group">											
											<label class="control-label" for="company_adress">Adresse</label>
											<div class="controls">
												<input type="text" class="span4" id="company_adress" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="company_adress2">Adresse 2 <i>(falcultatif)</i></label>
											<div class="controls">
												<input type="text" class="span4" id="company_adress2" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="company_town">Ville</label>
											<div class="controls">
												<input type="text" class="span4" id="company_town" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="company_zipcode">Code postal</label>
											<div class="controls">
												<input type="text" class="span4" id="company_zipcode" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
											<label class="control-label" for="company_nb_employees">Nombre d'employés</label>
											<div class="controls">
												<input type="text" class="span4" id="company_nb_employees" value="">
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
