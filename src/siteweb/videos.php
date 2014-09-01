<?php
	include('include/config.php');
	$videos = $client->get_all_articles();
?>
<!DOCTYPE HTML>
<!--
	Twenty 1.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Vidéos sur le reférencement | MARKET 3W Agence webmarketing spécialisé en référencement</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Accèdez gratuitement à de nombreux cours en Vidéo pour comprendre le référencement Web " />
		<meta name="keywords" content="Agence Webmarketing vidéo ; Agence de référencement vidéo;vidéo SMO ;vidéo SEO ;vidéo SEA ;vidéo SEM ;vidéo Référencement seo ;vidéo Référencement sea ;vidéo Référencement sem ;vidéo Référencement réseaux sociaux ;vidéo Référencement naturel ;vidéo Référencement payant ;vidéo Expert en référencement ;vidéo Spécialiste en référencement ;vidéo ; vidéo tutoriels gratuits ;" />
		<?php 
			include('include/head.php');
		?>
	</head>
	<body class="index loading">
	
		<?php 
			include('include/header.php');
		?>
	<!-- Main -->
			<article id="main">

				<div style="text-align:center;">
					<h2>Les vidéos de référencement</h2>
						</div><br/><br/>
					
				
				<!-- Two -->
					<section class="wrapper style1 container special">
						<div class="row" style="margin-top:-50px;">
							<?php if(count($videos["videos"])>0){ ?>
                                 <?php foreach($videos["videos"] as $key=>$value){ ?>
                                 <div class="4u" style="margin-top:30px;">
							
								<section>
									<header>
										<h3><?php echo $value->article_name; ?></h3>
									</header>
									<p><?php echo substr($value->article_courte_description, 0, 100); ?>...</p>
									<footer>
										<ul class="buttons">
											<li><a href="video.php?id=<?php echo $value->article_id; ?>" class="button small">Voir</a></li>
										</ul>
									</footer>
								</section>
							
							</div>
                             <?php  } ?>
                            <?php }else{echo'Pas de vidéos';} ?>
							
							
						</div>
					</section>
					
			</article>

		<?php
			include('include/footer.php');
		?>

	</body>
</html>