<?php 
include('include/config.php');
$page='rdv';  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Rendez-vous | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php'); 
  
  ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
     
        <div class="span12">
	      	<div id="target-1" class="widget">
	      		<div class="widget-content">
	      			<h1 style="margin-bottom:10px;color:#80B3CA;">Rendez-vous</h1>
			      		
			      	<p>Market3w a mis en place un système de vidéo-conférence sophisitiqué afin de vous éviter certains déplacements. Vous pouvez prendre rendez-vous avec l'un de nos webmarketeurs spécialisés dans le référencement afin d'établir un devis, de poser vos quesions ou pour toute autre demande.
                    <br/><br/> C'est bien évidemment gratuit. Veuillez prendre rendez-vous seulement si l'objet de votre demande nécessite au moins 30 minutes (durée minimum d'un rendez-vous).<br/><br/>Nous pouvons aussi fixer des rendez-vous téléphoniques ainsi que physiques afin que l'un de nos webmarketeurs apporte des solutions pour votre projet.
                    <br/><br/><center><a href="#rdv"> <button class="btn btn-primary">Fixer un rendez-vous</button></a></center>
                    </p>	
			    </div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	    </div> <!-- /span12 -->
        
        
        <?php 
        $agenda_titre = "Prendre un rendez-vous";
        include_once 'include/agenda.php'; 
        ?>
        
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<?php include('include/footer.php'); ?>

<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<?php include('include/end_javascript.php'); ?>
</body>
</html>
