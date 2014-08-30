<?php 
if($_SESSION["market3w_user"]=="")
{
	header("Location: login.php"); die;
}

?>

<form action="<?php echo WEB_ROOT.'login.php'; ?>" name="deconnexionForm" id="deconnexionForm" method="POST" style="display:none;"><input type="hidden" name="method" value="logout"/></form>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" style="margin-top:-5px;" href="<?php echo VITRINE_ROOT; ?>index.php"><img src="img/logo_mini.png" width="130" /> </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
        
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $currentuser->user_name; ?>  <?php echo $currentuser->user_firstname; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
            <li><a href="v">Revenir au site</a></li>
              <li><a href="<?php echo WEB_ROOT.'profil.php'; ?>">Mon profil</a></li>
              <li><a href="#" class="deconnexion">Déconnexion</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Rechercher">
        </form>
        
     
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>

<!-- /navbar -->