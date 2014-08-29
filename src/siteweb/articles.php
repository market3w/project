<?php
	include('include/config.php');
	$articles = $client->get_all_articles();

?>
<!DOCTYPE HTML>
<!--
	Twenty 1.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Les articles  référencement | MARKET 3W Agence webmarketing spécialisé en référencement</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Accèdez gratuitement à de nombreux articles pdf (à télécharger gratuitement) pour bien comprendre le référencement Web" />
		<meta name="keywords" content="Agence Webmarketing ; Agence de référencement ; SMO ; SEO ; SEA ; SEM ; Référencement seo ; Référencement sea ; Référencement sem ; Référencement réseaux sociaux ; Référencement naturel ; Référencement payant ; Expert en référencement ; Spécialiste en référencement ; Audit référencement ; tutoriels référencement gratuits ; " />
		
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
					<h2>Les articles (pdf) sur le référencement</h2>
						</div><br/><br/>
					
				
				<!-- Two -->
					<section class="wrapper style1 container special">
						<div class="row" style="margin-top:-50px;">
							<?php if(count($articles["pdf"])>0){ ?>
                                 <?php foreach($articles["pdf"] as $key=>$value){ 
                                 echo '<div class="4u" style="margin-top:30px;">
							
								<section>
									<header>
										<h3>'.$value->article_name.'</h3>
									</header>
									<p>'.substr($value->article_courte_description, 0, 100).'...</p>
									<footer>
										<ul class="buttons">
											<li><a href="article.php?id='.$value->article_id.'" class="button small">Voir</a></li>
										</ul>
									</footer>
								</section>
							
							</div>';
                               } ?>
                                
                              
                                    
                             <?php }else{echo'Pas d\'articles pdf';} ?>
							
						</div>
					</section>
					
			</article>

		<?php
			include('include/footer.php');
		?>

	</body>
</html>