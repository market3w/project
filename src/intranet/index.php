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
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/actions.js"></script>
 
<script src="js/base.js"></script> 
<script> 
$(document).ready(function() {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month',
		},
		minTime: '09:00:00',
		maxTime: '19:00:00',
		allDaySlot: false,
		weekends: false,
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			if ($('#calendar').fullCalendar('getView').name=="month") {
				// Clicked on the entire day
				$('#calendar')
				.fullCalendar('changeView', 'agendaDay')
				.fullCalendar('gotoDate',start);
				$("#calendar .fc-content").css("padding-top","20px");
			} else {
				addAppointment(start,end);
			}
		},
		editable: false,
		// A modifier pour récupérer les infos dynamiquement
		events: [
			{
				id: 5,
				title: 'Lunch',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false
			},
			{
				id: 9,
				type: 'unavailable',
				title: 'Indisponnible',
				start: new Date(y, m, d, 16, 0),
				end: new Date(y, m, d, 17, 0),
				allDay: false
			},
			{
				id: 10,
				title: 'Vidéoconférence',
				start: new Date(y, m, 25, 12, 0),
				end: new Date(y, m, 25, 14, 0),
				allDay: false
			}
		]
	});
	
});
</script><!-- /Calendar -->

 <script type="text/javascript">
	$(document).ready(function() {

	$(".delete_article").on('click', function(){
		
		 var article_id = $(this).attr("article_id");
				$("#delete_articleForm"+article_id).submit();
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
