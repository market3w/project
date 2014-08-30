<?php
	include('include/config.php');
?>
<!DOCTYPE HTML>
<!--
	Twenty 1.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Inscription | MARKET 3W Agence webmarketing spécialisé en référencement</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Inscrivez-vous et bénéficier de nombreux avantages. Contacter nous à travers la vidéo conférence. Télécharger nos pdf explicatifs" />
		<meta name="keywords" content="Agence Web ; Agence Marketing ; Agence Webmarketing ; Agence de référencement ; Référencement ; Webmarketing ; SMO ; SEO ; SEA ; SEM;"; "devis référencement" />
		<?php 
			include('include/head.php');
		?>
	</head>
	<body class="index loading">
	
		<?php 
			include('include/header.php');
		?>

			<article id="main">

				<div style="text-align:center; padding-left:20px; padding-right:20px;">
					<h2>Inscription</h2>
					<p>Vous désirez devenir client et ainsi booster votre référencement, inscrivez-vous, cela prend deux minutes.</p>
				</div>
					
				<!-- One -->
					<section class="wrapper style4 special container small">
					
						<!-- Content -->
							<div class="content">
                           <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
                   
								<form action="inscription.php" id="post_userForm" method="post">
                                
                                <input type="hidden" name="methode" value="post_user" />
									<div class="row half no-collapse-1">
										<div class="6u">
											<input type="text" name="user_name" placeholder="Nom" />
										</div>
										<div class="6u">
											<input type="text" name="user_firstname" placeholder="Prenom" />
										</div>
									</div>
                                    <div class="row half">
										<div class="12u">
											<input type="text" name="user_email" placeholder="Email" />
										</div>
									</div>
									<div class="row half">
										<div class="6u">
											<input type="text" name="user_password" placeholder="Mot de passe" />
										</div>
                                        <div class="6u">
											<input type="password" name="user_password2" placeholder="Confirmer ot de passe" />
										</div>
									</div>
                                    <br/>
                                    <div class="row half">
										<div class="12u">
											<input type="text" name="user_adress" placeholder="Adresse" />
										</div>
									</div>
									<div class="row half">
										<div class="12u">
											<input type="text" name="user_adress2" placeholder="Adresse complémentaire" />
										</div>
									</div>
                                    <div class="row half no-collapse-1">
										<div class="6u">
											<input type="text" name="user_zipcode" placeholder="Code postal" />
										</div>
										<div class="6u">
											<input type="text" name="user_town" placeholder="Ville" />
										</div>
									</div>
									
                                    <div class="row half">
										<div class="6u">
											<input type="text" name="user_phone" placeholder="Téléphone" />
										</div>
                                        <div class="6u">
											<input type="text" name="user_mobile" placeholder="Portable" />
										</div>
									</div>
                                    <div class="row half">
										<div class="6u">
											<input type="text" name="user_function" placeholder="Fonction" />
										</div>
                                    </div>
                                    <div class="row">
										<div class="12u">
											<ul class="buttons">
												<a href="#" class="button inscriptionbtn">Inscription</a>
											</ul>
										</div>
									</div>
                                    
								</form>
							</div>
							
					</section>
					
			</article>
		<script type="text/javascript">
	$(document).ready(function() {

	$(".inscriptionbtn").on('click', function(){
				$("#post_userForm").submit();
				return false;
			});
		});
		</script>
		<?php
			include('include/footer.php');
		?>

	</body>
</html>