<?php  $page='documents';  ?>
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
      
      <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="#"><h3>Nom facture + n°</h3></a>
                    <p><i>23 juin 2014</i></p>
			      	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>	
			      	<a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin-top:8px;">Télécharger la facture</button></a>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
      	
        <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="#"><h3 style="margin-bottom:8px;">Nom facture + n°</h3></a>
                     <p><i>23 juin 2014</i></p>
			      	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>	
			      	<a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin-top:8px;">Télécharger la facture</button></a>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
         
         <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="#"><h3 style="margin-bottom:8px;">Nom facture + n°</h3></a>
                     <p><i>23 juin 2014</i></p>
			      	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>	
			      	<a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin-top:8px;">Télécharger la facture</button></a>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
      
      <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="#"><h3>Nom facture + n°</h3></a>
                    <p><i>23 juin 2014</i></p>
			      	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>	
			      	<a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin-top:8px;">Télécharger la facture</button></a>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
      	
        <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="#"><h3 style="margin-bottom:8px;">Nom facture + n°</h3></a>
                     <p><i>23 juin 2014</i></p>
			      	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>	
			      	<a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin-top:8px;">Télécharger la facture</button></a>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
         
         <div class="span4">
	      	<div id="target-3" class="widget">
	      		<div class="widget-content">
	      			<a href="#"><h3 style="margin-bottom:8px;">Nom facture + n°</h3></a>
                     <p><i>23 juin 2014</i></p>
			      	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>	
			      	<a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info" style="margin-top:8px;">Télécharger la facture</button></a>
        		</div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	     </div> <!-- /span4 -->
        
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
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
 
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
