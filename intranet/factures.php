<?php  
include('include/config.php');
$page='factures'; 
$paiements = $client->get_allpaiement(array("user_id"=>$currentuser_id)); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Mes factures | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php');
 ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <?php if(count($paiements)>0){ ?>
			 <?php for($i=0; $i < count($paiements); $i++){ ?>
             
              <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="<?php echo $paiements[$i]->paiement_link; ?>"><h3><?php echo $paiements[$i]->paiement_name; ?></h3></a>
                    <p><i><?php echo $paiements[$i]->paiement_date; ?></i></p>
			      	<p><?php echo $paiements[$i]->paiement_description; ?></p>	
			      	<form action="<?php echo $paiements[$i]->paiement_link; ?>"><input type="submit" class="btn btn-info" style="margin-top:8px;" value="Télécharger la facture" /></form>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
                 
			 <?php  } ?>
            <?php }else{echo'Pas de factures';} ?>
     
      	
         
        
        
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
