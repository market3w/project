<?php $campagnes = $client->get_allcampain();
$paiements = $client->get_allpaiement();
$documents = $client->get_alldocument(); ?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span6">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-user"></i>
              <h3> Informations personnelles </h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h6 class="bigstats" style="margin-bottom:0px;">
                 
                 <div style="float:left;"> Nom : <?php echo $currentuser->user_name; ?><br/>
                  Prénom : <?php echo $currentuser->user_firstname; ?><br/>
                  Email : <?php echo $currentuser->user_email; ?><br/>
                  Adresse : <?php echo ($currentuser->user_adress!='' ? $currentuser->user_adress : '<i>Non renseigné</i>'); ?><br/>
                  Complément adresse : <?php echo ($currentuser->user_adress2!='' ? $currentuser->user_adress2 : '<i>Non renseigné</i>'); ?><br/>
                  Ville : <?php echo ($currentuser->user_town!='' ? $currentuser->user_town : '<i>Non renseigné</i>'); ?><br/>
                  Code postal : <?php echo ($currentuser->user_zipcode!='' ? $currentuser->user_zipcode : '<i>Non renseigné</i>'); ?><br/>
                  Téléphone : <?php echo ($currentuser->user_phone!='' ? $currentuser->user_phone : '<i>Non renseigné</i>'); ?><br/>
                  Mobile : <?php echo ($currentuser->user_mobile!='' ? $currentuser->user_mobile : '<i>Non renseigné</i>'); ?><br/>
                  Poste occupé : <?php echo ($currentuser->user_function!='' ? $currentuser->user_function : '<i>Non renseigné</i>'); ?>
                  </div>
                  <div style="float:right;text-align:right;"><?php echo $currentuser->user_company->company_name; ?><br/>
                  <?php echo $currentuser->user_company->company_nb_employees; ?> employés
                  </div>
                  <div style="clear:both;"></div>
                <a href="profil.php?aff=info_perso" style="color:#ffffff;text-decoration:none;"><button class="btn btn-info" style="float:right;">Modifier</button></a>
                  </h6>
                 
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Agenda</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div id='calendar'>
              </div>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-file"></i>
              <h3> Derniers documents</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="messages_layout">
              <span class="responseError" id="delete_documentError"><?php echo $_SESSION["errorMessage"]; ?></span>
                    <?php if(isset($_SESSION['method']) && $_SESSION['method']=='delete_document'){echo'Suppression effectuée avec succés';} ?>
						
               <?php if(count($documents)>0){ ?>
			 <?php for($i=0; $i < 3 && $i < count($documents); $i++){
	
				  ?>
             
              <?php //echo (($documents->author_id==$_SESSION["market3w_user"]) ? "from_user left" : "by_myself right"); ?>
             <li class="<?php echo (($documents[$i]->author_id==$currentuser_id) ? "from_user left" : "by_myself right"); ?>"> <a href="#" class="avatar"><img src="img/message_avatar<?php echo (($documents[$i]->author_id==$currentuser_id) ? "1" : "2"); ?>.png"/></a>
                  <div class="message_wrap" style="width:auto;"> <span class="arrow"></span>
                    <div class="info"> <a class="name"><?php echo $documents[$i]->document_name; ?></a>  <span class="time" style="margin-left:10px; "><i><?php echo (($documents[$i]->author_id==$currentuser_id) ? "par <b>moi</b>" : "par <b>Market 3W</b>"); ?></i> <?php echo '(le '.$documents[$i]->document_date.')'; ?></span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="<?php echo $documents[$i]->document_link; ?>"><i class=" icon-share icon-large"></i> Télécharger</a></li>
                            <li><a href="#" class="delete_document" document_id="<?php echo  $documents[$i]->document_id; ?>"><i class=" icon-trash icon-large"></i> Supprimer</a></li>
                            
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text" style="min-width:100%;">Ici description du document télé.dfgdgd gddgdbgfdj hbhbdbb hjgbhjghjdbhgfdbhd bh
                    <form action="index.php" name="delete_documentForm<?php echo $documents[$i]->document_id; ?>" id="delete_documentForm<?php echo $documents[$i]->document_id; ?>" method="POST">
                                        <input type="hidden" name="method" value="delete_document"/>
                                        <input type="hidden" name="document_id" value="<?php echo $documents[$i]->document_id; ?>"/>
                                         <input type="hidden" name="document_file_name" value="<?php echo basename($documents[$i]->document_link); ?>"/>
                                     </form> </div>
                  </div>
                </li>
             
             
                 
			 <?php  } ?>
            <?php }else{echo'Pas de documents';} ?>
              
               
               
               <center><a href="profil.php?aff=document" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Télécharger un document</button></a>
               <a href="documents.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin:15px;">Voir tous les documents</button></a></center>
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
        <!-- /span6 -->
        <div class="span6">
          
          
          
          
          <!-- /widget --> 
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Dernières campagnes</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="news-items">
               <?php if(count($campagnes)>0){ ?>
			 <?php for($i=0; $i < 3 && $i < count($campagnes); $i++){ ?>
             
             <li  style="width:90%;">
                  
                    <div class="news-item-detail"> <a href="campagne.php?id=<?php echo $campagnes[$i]->campain_id; ?>" class="news-item-title" target="_blank"><?php echo $campagnes[$i]->campain_name; ?></a>
                    <p class="news-item-preview"><?php echo $campagnes[$i]->campain_description; ?></p>
                      <div style="text-align:center;margin-top:10px;"><a href="campagne.php?id=<?php echo $campagnes[$i]->campain_id; ?>" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la campagne</button></a></div>
           
                  </div>
                  
                </li>
             
                 
			 <?php  } ?>
            <?php }else{echo'Pas de campagnes';} ?>
        
             <?php if(count($campagnes)>0){ ?>
                 <div style="text-align:center;margin-top:20px;margin-bottom:20px;"><a href="campagnes.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir toutes les campagnes</button></a></div>
           	<?php } ?>
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Dernières factures</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="news-items">
                <?php if(count($paiements)>0){ ?>
			 <?php for($i=0; $i < 3 && $i < count($paiements); $i++){ ?>
             
             <li  style="width:90%;">
                  
                    <div class="news-item-detail"> <a href="<?php echo $paiements[$i]->paiement_link; ?>" class="news-item-title" target="_blank"><?php echo $campagnes[$i]->campain_name; ?></a>
                    <p class="news-item-preview"><?php echo $paiements[$i]->paiement_description; ?></p>
                      <div style="text-align:center;margin-top:10px;"><a href="<?php echo $paiements[$i]->paiement_link; ?>" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Télécharger la facture</button></a></div>
           
                  </div>
                  
                </li>
             
                 
			 <?php  } ?>
            <?php }else{echo'Pas de factures';} ?>
              
             <?php if(count($paiements)>0){ ?>
                 <div style="text-align:center;margin-top:20px;margin-bottom:20px;"><a href="factures.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir toutes les factures</button></a></div>
          	 <?php  } ?>
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->