<?php if(isset($_GET['aff']) && $_GET['aff']!=''){ $aff = $_GET['aff'];}else{$aff='pdf';}
if(isset($_GET['article_id']) && is_numeric($_GET['article_id'])){
	$article = $client->get_article(array("id"=>$_GET['article_id']));
	
}
$allpdf = $client->get_allpdf();
$allvideo = $client->get_allvideo(); ?>
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
          
         <?php 
		 //Si modification d'un pdf ou video
		 	if(($aff=='pdf' ||$aff=='videos')  && isset($article) && is_numeric($article->article_id)){ 
	      		?>
                <div class="span12">  
               <div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Modifier <?php echo $aff; ?></h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
                    <?php if(isset($_SESSION['method']) && $_SESSION['method']=='put_article'){echo'modification enregistrée avec succés';} ?>
								
                   <form class="form-horizontal" action="index.php?aff=<?php echo $aff; ?>&article_id=<?php echo $article->article_id ; ?>" method="post">
                        <fieldset>
                            <input type="hidden" name="method" value="put_article" />
                             <input type="hidden" name="article_id" value="<?php echo $article->article_id ; ?>" />
                             <input type="hidden" name="type" value="<?php echo $aff; ?>" />
                            <div class="control-group">											
                                <label class="control-label" for="article_name">Nom article</label>
                                <div class="controls">
                                    <input type="text" class="span4" name="article_name" value="<?php echo $article->article_name ; ?>">
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                            
                            
                            <div class="control-group">											
                                <label class="control-label" for="article_courte_description">Courte description</label>
                                <div class="controls">
                                    <input type="text" class="span4" name="article_courte_description" value="<?php echo $article->article_courte_description ; ?>">
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                            
                            
                            <div class="control-group">											
                                <label class="control-label" for="article_description">Description</label>
                                <div class="controls">
                                    <textarea class="span8" name="article_description" ><?php echo $article->article_description ; ?></textarea>
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                            
                            <?php if($aff=='videos')
							{ ?>
                            
                            <div class="control-group">											
                                <label class="control-label" for="article_link">Lien</label>
                                <div class="controls">
                                    <input type="text" class="span4" name="article_link" value="<?php echo $article->article_link ; ?>"/>
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                            <?php } ?>
                            
                            
                            
                            
                           <button type="submit" class="btn btn-primary">Modifier</button> </center>
                                <a href="index.php?aff=<?php echo $aff; ?>" class="btn">Annuler</a>
                            
                        </fieldset>
                    </form>
                    </div>
                    </div></div>
                
         <?php } ?>
	      	<div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-dashboard"></i>
	      				<h3>Tableau de bord</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li  <?php if($aff=='pdf'){echo 'class="active"';} ?> > <a href="#pdf" data-toggle="tab">PDF</a></li>
                           <li  <?php if($aff=='videos'){echo 'class="active"';} ?> > <a href="#videos" data-toggle="tab">Videos</a></li>
						  <li  <?php if($aff=='add_article'){echo 'class="active"';} ?> > <a href="#add_article" data-toggle="tab">Ajouter un article</a></li>
						 
                          <li  <?php if($aff=='entreprise'){echo 'class="active"';} ?>><a href="#entre" data-toggle="tab">Ajouter une entreprise</a></li>
                      		   </ul>
						
						<br>
						
							<div class="tab-content">
                           		<div class="tab-pane <?php if($aff=='pdf'){echo 'active';} ?>" id="pdf">
									<?php if(count($allpdf)>0){ ?>
                                    
                                
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom pdf</td><td>Options</td></tr>
                                    <?php foreach($allpdf as $key=>$value){ ?>
                                    <tr><td><?php echo $value->article_name; ?></td>
                                    <td><a href="../siteweb/article.php?id=<?php echo $value->article_id; ?>" target="_blank"><?php echo 'voir' ?></a><a href="index.php?aff=pdf&article_id=<?php echo $value->article_id; ?>"><?php echo 'Modifier' ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de pdf';} ?>
								</div>
                                
                             
                           		<div class="tab-pane <?php if($aff=='videos'){echo 'active';} ?>" id="videos">
									<?php if(count($allvideo)>0){ ?>
                                    
                                
                                    <table width="100%" style="margin-top:-25px;"><tr><td>Nom video</td><td>Options</td></tr>
                                    <?php foreach($allvideo as $key=>$value){ ?>
                                    <tr><td><?php echo $value->article_name; ?></td>
                                    <td><a href="../siteweb/video.php?id=<?php echo $value->article_id; ?>" target="_blank"><?php echo 'voir' ?></a><a href="index.php?aff=videos&article_id=<?php echo $value->article_id; ?>"><?php echo 'Modifier' ?></a></td></tr>
                                    <?php } ?>
                                    
                                    </table>
                                    
                                    <?php }else{echo'Pas de pdf';} ?>
								</div>
                                
                                 <div class="tab-pane <?php if($aff=='add_article'){echo 'active';} ?>" id="add_article">
										
									<span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
							<?php if(isset($_SESSION['method']) && $_SESSION['method']=='put_article'){echo'Ajout enregistrée avec succés';} ?>
                                    
                           <form class="form-horizontal" action="index.php?aff=add_article" method="post">
                                <fieldset>
                                    <input type="hidden" name="method" value="post_article" />
                                      <div class="control-group">											
                                        <label class="control-label" for="article_name">Nom article</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="article_name" value="<?php echo (array_key_exists("article_name",$_POST))?$_POST["article_name"]:""; ?>">
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    <div class="control-group">											
                                        <label class="control-label" for="article_name">Type article</label>
                                        <div class="controls">
                                            <input type="radio" class="btn_radio_type" id="btn1" name="type" value="1"/> PDF<br/>
                                            <input type="radio" class="btn_radio_type" id="btn2" name="type" value="2"/> Vidéo
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    <div class="control-group">											
                                        <label class="control-label" for="article_courte_description">Courte description</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="article_courte_description" value="<?php echo (array_key_exists("article_courte_description",$_POST))?$_POST["article_courte_description"]:""; ?>">
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    
                                    <div class="control-group">											
                                        <label class="control-label" for="article_description">Description</label>
                                        <div class="controls">
                                            <textarea class="span8" name="article_description" ><?php echo (array_key_exists("article_description",$_POST))?$_POST["article_description"]:""; ?></textarea>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    
                                    <div class="bloc_type" id="bloc_type1" style="display:none;">
                                    <div class="control-group">											
                                        <label class="control-label" for="article_link">Télécharger</label>
                                        <div class="controls">
                                            <input type="file" class="span4" name="document" value="<?php echo (array_key_exists("document",$_POST))?$_POST["document"]:""; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                   </div>
                                   
                                   <div class="bloc_type" id="bloc_type2" style="display:none;">
                                    <div class="control-group">											
                                        <label class="control-label" for="article_link">Lien</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="article_link" value="<?php echo (array_key_exists("article_link",$_POST))?$_POST["article_link"]:""; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                   </div>
                                    
                                    
                                    
                                    
                                   <button type="submit" class="btn btn-primary">Ajouter</button> </center>
                                   
                                </fieldset>
                            </form>

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
