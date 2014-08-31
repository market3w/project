<?php require_once('include/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Connexion - Market 3W</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="<?php echo VITRINE_ROOT; ?>">
				<img src="img/logo_mini.png" width="130" />			
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="<?php echo VITRINE_ROOT.'inscription.php'; ?>" class="">
							Inscription
						</a>
						
					</li>
					
					<li class="">						
						<a href="<?php echo VITRINE_ROOT.'index.php'; ?>" class="">
							<i class="icon-chevron-left"></i>
							Revenir  au site
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container">
	
	<div class="content clearfix">
		<?php if(isset($_SESSION['method']) && $_SESSION['method']=='login'){header("Location: index.php");die;} ?>
					
		 <form action="login.php" method="post">
   <input type="hidden" name="method" value="login"/>
		
			<h1>Connexion</h1>		
			
			<div class="login-fields">
				<span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
		
				<p>Rentrer vos identifiants</p>
				<div class="field">
					<label for="username">Adresse email</label>
					<input type="text" name="login" value="<?php echo (array_key_exists("login",$_POST))?$_POST["login"]:""; ?>"  placeholder="Email" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Mot de passe</label>
					<input type="password" name="password" value="" placeholder="Mot de passe" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
									
				<input type="submit" name="submit" class="button btn btn-info btn-large" value="Se connecter" />
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="#">Mot de passe oublié ?</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
