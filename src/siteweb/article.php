<?php
	include('include/config.php');
	if(isset($_GET['id']) && is_numeric($_GET['id']))
	{
		$articles = $client->get_article(array("id"=>$_GET['id']));
		$other_articles = $client->get_other_articles(array("article_id"=>$_GET['id'],"article_limit"=>3,"type"=>1));
		$next_article = $client->get_next_article(array("article_id"=>$_GET['id'],"type"=>1 ));
		$prev_article = $client->get_prev_article(array("article_id"=>$_GET['id'],"type"=>1 ));
	} else {
		header("location:".WEB_ROOT."articles.php");
		die();
	}
		
?>
<!DOCTYPE HTML>
<!--
	Twenty 1.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php echo $articles->article_name; ?> | MARKET 3W Agence webmarketing spécialisé en référencement </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
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
					<h2><?php echo $articles->article_name; ?></h2>
				</div>
					
				<!-- One -->
					<section class="wrapper style4 container">
					
						<!-- Content -->
							<div class="content">
                              <center>
                               
                                 <?php if(isset($prev_article->article_id) && is_numeric($prev_article->article_id)){ ?><a class="button" href="article.php?id=<?php if(isset($prev_article->article_id) && is_numeric($prev_article->article_id)){echo $prev_article->article_id;} ?>">< article précédent</a><?php } ?>
                                 <a class="button special_violet" href="articles.php">Tous les articles</a>
								 <?php if(isset($next_article->article_id) && is_numeric($next_article->article_id)){ ?><a class="button" href="article.php?id=<?php if(isset($next_article->article_id) && is_numeric($next_article->article_id)){echo $next_article->article_id;} ?>">Article suivant ></a><?php } ?><br/><br/></center>
                                  
								<section>
                                
									
                                  <?php echo $articles->article_description; ?>
<br/><br/><center><a class="button special_violet" href="<?php echo $articles->article_link; ?>">Télécharger en PDF</a></center>
	</section>
							</div>

					</section>

				<!-- Two -->
					<section class="wrapper style1 container special">
						<div class="row">
                        
                        <?php if(count($other_articles)>0){ ?>
                                 <?php foreach($other_articles as $key=>$value){ ?>
                                 <div class="4u" style="margin-top:-30px;">
							
								<section>
									<header>
										<h3><?php echo $value->article_name; ?></h3>
									</header>
									<p><?php echo substr($value->article_courte_description, 0, 100); ?></p>
									<footer>
										<ul class="buttons">
											<li><a href="article.php?id=<?php echo $value->article_id; ?>" class="button small">Voir</a></li>
										</ul>
									</footer>
								</section>
							
							</div>
                              <?php } ?>
                                
                              
                                    
                             <?php }else{echo'Pas d\'autres pdf';} ?>
                             
							
						</div>
					</section>
					
			</article>

		<?php
			include('include/footer.php');
		?>

	</body>
</html>