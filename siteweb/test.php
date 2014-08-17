<!DOCTYPE HTML>
<!--
	Twenty 1.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>MARKET 3W | La société | Agence de référencement et marketing</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php 
			include('include/head.php');
		?>
        <script type="text/javascript">
		  $(document).ready(function() {
	
	 	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Confirmation des parametres !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	   		$(".espace_membre_pc").on('click', function(){
				$(".espace_membre_pc").fadeOut(500);
				$(".clic_espace_membre_pc").fadeIn(500);
				
			});
			
			
		});
		</script>
	</head>
	<body class="index loading">
	
        <!-- Header -->
        
        	 <div class="logo_tablette" ><div style="background-color:#83BBD3;  border-radius:3px; width:40px; height:40px; padding:5px;margin-top:-10px;cursor:pointer; float:right;" class="btn_connexion"><img src="images/em.png" style="width:30px;" /></div><center><a href="index.php" style="text-decoration:none;"><img src="images/logo_mini.png" width="120" /></a></center></div>
             <div class="logo_mobile" ><div style="background-color:#83BBD3;  border-radius:3px; margin-right:3px;width:30px; height:30px; padding:5px;margin-top:3px;cursor:pointer; float:right;" class="btn_connexion"><img src="images/em.png" style="width:20px;" /></div><a href="index.php" style="text-decoration:none;"><img src="images/logo_mini.png" width="100" style="margin-left:10px;  margin-bottom:5px; margin-top:8px;"/></a></div>
            
            <div class="espace_membre_pc" style="position:fixed; z-index:15000; top:14px; font-size:22px; width:100%; color:#ffffff; text-align:center; cursor:pointer;"><img src="images/em.png" style="width:18px;margin-top:5px;"/> Bonjour Vince</div>
			<div class="clic_espace_membre_pc" style="position:fixed; z-index:15000; top:14px; font-size:18px; width:100%; color:#ffffff; text-align:center; display:none;"><a href="#" style="color:#ffffff;">Accéder à votre espace membre</a> | <a href="#" style="color:#ffffff;">Se déconnecter</a></div>
			
            <header id="header">
            	
				<h1 id="logo"><a href="index.php"><img src="images/logo_mini.png" style="width:110px;"/></a></h1>
				<nav id="nav">
					<ul>
						
						<li class="submenu">
							<a href="" style="color:#ffffff; font-weight:700;">Menu</a>
							<ul>
								<li><a href="index.php">Accueil</a></li>
                            <li><a href="societe.php">La société</a></li>
								<li><a href="services.php">Nos services</a></li>
								
								<li class="submenu">
									<a href="tutoriels.php">Les tutoriels</a>
									<ul>
										<li><a href="articles.php">Documents pdf</a></li>
										<li><a href="videos.php">Les vidéos</a></li>
									</ul>
								</li>
                                <li><a href="contact.php">Contact</a></li>
							</ul>
						</li>
						
					</ul>
				</nav>
			</header>
            
             <script type="text/javascript">
	
  		  $(document).ready(function() {
	
	 	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Confirmation des parametres !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	   		$(".btn_connexion").on('click', function(){
				$(".fermer_pop_up").fadeIn(500);
				$("#conteneur_connexion").fadeIn(500);
				
			});
			
			 $(".fermer_pop_up").on('click', function(){
				$(".fermer_pop_up").fadeOut(500);
				$("#conteneur_connexion").fadeOut(500);
				
			});
			
			<?php
				//affichage auto de la fenêtre de connexion en cas d'erreur
				if($_SESSION["method"]=="login" && $_SESSION["errorMessage"]!=""){
			?>
			$("#loginError").show();
			$(".fermer_pop_up").fadeIn(500);
			$("#conteneur_connexion").fadeIn(500);
			<?php } ?>
			
			 $("#oubli_mdp").on('click', function(){
				$("#formulaire_connexion").hide(500);
				$("#conteneur_oubli_mdp").show(500);
				$("#titre_conteneur_connexion").html("MOT DE PASSE OUBLIE");
			});
			
			$("#annul_oubli_mdp").on('click', function(){
				$("#conteneur_oubli_mdp").hide(500);
				$("#formulaire_connexion").show(500);
				$("#titre_conteneur_connexion").html("CONNEXION");
			});
			
			<?php
				//affichage d'une alerte en cas d'erreur du serveur
				if($_SESSION["errorServer"]!=""){
			?>
			alert("<?php echo $_SESSION["errorServer"]; ?>");
			<?php } ?>
           
        });
		</script>
            </head>
			<body class="index loading">
            <div class="fermer_pop_up" style="position:fixed; cursor:pointer; z-index:13000; display:none; background-color: rgba(0, 0, 0, 0.70); width:100%; height:100%; "></div>
  			
             <div id="conteneur_connexion">
   
  <center> <h1 style="color:#ffffff; background-color:#83BBD3; padding:10px;"><span id="titre_conteneur_connexion">Connexion</span><span class="fermer_pop_up" style="float:right; cursor:pointer;">X</span></h1></center>
   <div id="formulaire_connexion" style="padding:10px;"><center>
   <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
   <form action="" method="post">
   <input type="hidden" name="method" value="login"/>
   <input type="text" name="login" value="<?php echo (array_key_exists("login",$_POST))?$_POST["login"]:""; ?>" style="width:80%;" placeholder="Pseudo"/><br/>
   <input type="password" name="password" style="width:80%;" value=""  placeholder="Mot de passe" /><br/>
   <input type="submit" name="submit" value="SE CONNECTER" style="background-color:#83BBD3; border:0px; color:#ffffff; cursor:pointer;" /><br/><br/>
   </form>
   </center>
    <div style="float:left; margin-bottom:8px;"><a href="#" style=" color:#4F394F;" id="oubli_mdp">Mot de passe oublié ?</a></div> <div style="float:right; margin-bottom:8px;"><a href="inscription.php" style=" color:#4F394F;">Inscription</a></div>

   </div>
   
   <div id="conteneur_oubli_mdp" style="padding:10px; display:none;"><center>
   <form action="" method="post">
   <input type="text" name="email" value="<?php echo (array_key_exists("email",$_POST))?$_POST["email"]:""; ?>" style="width:80%;" placeholder="Email"/><br/>
   
   <input type="submit" name="submit" value="ENVOYER" style="background-color:#83BBD3; border:0px; color:#ffffff; cursor:pointer;" /><br/>
    <a href="#" style=" color:#4F394F;" id="annul_oubli_mdp">Annuler</a>
   </form>
   </center>
   

   </div>
   
     </div>
	<!-- Main -->
			<article id="main">

				<div style="text-align:center;">
					<h2>La société</h2>
					
				</div>
					
				<!-- One -->
					<section class="wrapper style4 container">
					
						<!-- Content -->
							<div class="content">
								<section>
                              
                                <center>
                                  <a class="button special" href="#">Qui sommes nous ?</a><a class="button special" href="#equipe">L'équipe</a><a class="button special" href="#valeurs">Nos valeurs</a><a class="button special" href="#mot">Coordonnées</a><br/><br/>
                               
                                <h1 style="font-weight:500;" >Qui sommes nous ?</h1>
									

- L'acquisition durable de trafic qualifié<br/>
- Le développement de la visibilité online et de la notoriété de votre site et de votre marque<br/>
- Le développement de votre chiffre d'affaire, l'acquisition de contacts qualifiés<br/><br/>


<h1 style="font-weight:500; border-top: #999999 solid 1px; padding-top:20px;">L'équipe</h1>

- Utilisation du re-ciblage publicitaire (re-targeting)<br/>
- Utilisation d'annonces illustrées ou vidéos<br/>
- Utilisation des extensions d'annonces<br/>
- Déploiement des annonces sur le réseau mobile<br/>

- Optimisation et développement des campagnes<br/><br/>

<h1 style="font-weight:500; border-top: #999999 solid 1px; padding-top:20px;">Nos valeurs</h1>
								
- Développer sa réputation et son traffic<br/>
- Fidéliser ses clients<br/>
- Obtenir un retour sur investissement rapide et optimal<br/><br/>

<h1 style="font-weight:500; border-top: #999999 solid 1px; padding-top:20px;">Coordonnées</h1>
								
- Développer sa réputation et son traffic<br/>
- Fidéliser ses clients<br/>
- Obtenir un retour sur investissement rapide et optimal<br/><br/>


                                </center>
                                 
	</section>
</div>

</section>

			
					
			</article>

		<?php
			include('include/footer.php');
		?>

	</body>
</html>