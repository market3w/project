<?php  
include('include/config.php');
$page='campagnes';
if(isset($_GET['id']) && is_numeric($_GET['id']))
{
	$campagne = $client->get_campain(array("campain_id"=>$_GET['id']));
} else {
	header("location:".WEB_ROOT."campagnes.php");
	die();
}
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Titre campagne | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php'); ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
      
     	<div class="span12">
	      	<div id="target-1" class="widget">
	      		<div class="widget-content">
	      			<h1 style="margin-bottom:10px;color:#80B3CA;"><?php echo $campagne->campain_name; ?></h1>
			      		 <div style="border:1px solid #80B3CA; padding:10px; margin-bottom:10px;"> Campagne dirigée par <?php echo $campagne->campain_webmarketter->webmarketter_name; ?><br/>
                         <i>Date création : <?php echo $campagne->campain_date; ?></i><br/>
                         <i>Dernière modification : <?php echo $campagne->campain_date_modif; ?></i></div>
			      	

						<?php echo $campagne->campain_description; ?>
                   
			    </div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	    </div> <!-- /span12 -->
        
        
       
        
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
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });
    </script><!-- /Calendar -->
</body>
</html>
