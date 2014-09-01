<?php   
include('include/config.php');
$page='index';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Espace membre | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php'); ?>

<?php 
//Si admin
if($currentuser_role_id==1)
{
	include('include/index_admin.php');
}
//Sinon si webmarketteur
elseif($currentuser_role_id==2)
{
	include('include/index_webmarketeur.php');
}
//Sinon si communitymanager
elseif($currentuser_role_id==3)
{
	include('include/index_community_manager.php');
}
//Sinon si client
elseif($currentuser_role_id==4)
{
	include('include/index_client.php');
}
//Sinon si prospect
elseif($currentuser_role_id==5)
{
	include('include/index_prospect.php');
}
else
{
	//SI visiteur le rediriger vers le formulaire à compléteer avec ces infos preremplis !!!!!!!!!!!!!!!!!!!!!!!!!
}
?>

<?php include('include/footer.php'); ?>
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<?php include('include/end_javascript.php'); ?>

 <script type="text/javascript">
	$(document).ready(function() {

	$(".delete_article").on('click', function(){
		
		 var article_id = $(this).attr("article_id");
				$("#delete_articleForm"+article_id).submit();
				return false;
			});


	$(".delete_document").on('click', function(){
		
		 var document_id = $(this).attr("document_id");
				$("#delete_documentForm"+document_id).submit();
				return false;
			});

		
	//Afficher / Cacher bonne div en fonction du type d'article sélectionné
	
	
	$("[name=article_type]").each(function(i) { 
    $(this).change(function(){ 
     var value = $(this).attr("value");
      $(".bloc_type").hide(); 
      $("#bloc_type"+value).show('slow'); 
    }); 
  }); 
});
 </script>
 
 
</body>
</html>
