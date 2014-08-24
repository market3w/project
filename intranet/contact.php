<?php  $page='contact';  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Contact | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php'); ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
      
     	<div class="span6">
	      	<div id="target-1" class="widget">
	      		<div class="widget-content">
	      			<h1 style="margin-bottom:10px;color:#80B3CA;">Contacter-nous</h1>
			      		
			      	<p>N'hésiter pas à nous contacter par le formulaire si l'objet de votre demande ne nécessite pas la vidéo-conférence.</p>	
                   <form id="contact" class="form-horizontal">
                    <fieldset>
                        
                        <div class="control-group">											
                            <label class="control-label" for="user_name">Nom</label>
                            <div class="controls">
                                <input type="text" class="span4 disabled" id="user_name" value="John" disabled>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                        <div class="control-group">											
                            <label class="control-label" for="user_firstname">Prénom</label>
                            <div class="controls">
                                <input type="text" class="span4 disabled" id="user_firstname" value="Donga" disabled>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                        <div class="control-group">											
                            <label class="control-label" for="email">Adresse email</label>
                            <div class="controls">
                                <input type="text" class="span4 disabled" id="email" value="john.donga@egrappler.com" disabled>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        <div class="control-group">											
                            <label class="control-label" for="objet">Objet</label>
                            <div class="controls">
                                <input type="text" class="span4" id="objet" value="" placeholder="Indiquer l'objet du contact">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                      <div class="control-group">											
                            <label class="control-label" for="message">Message</label>
                            <div class="controls">
                                <textarea class="span4" id="message" placeholder="Indiquer votre message"></textarea>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                            
                        <div class="form-actions">
                            <center><button type="submit" class="btn btn-primary">Enregistrer</button> </center>
                            <!--<button class="btn">Cancel</button>-->
                        </div> <!-- /form-actions -->
                    </fieldset>
                </form>
			    </div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	    </div> <!-- /span12 -->
        <div class="span6">
	      	<div id="target-1" class="widget">
	      		<div class="widget-content">
	      			<h1 style="margin-bottom:10px;color:#80B3CA;">Vidéo conférence</h1>
			      		
			      	<p>Market3w a mis en place un système de vidéo-conférence sophisitiqué afin de vous éviter certains déplacements. Vous pouvez prendre rendez-vous avec l'un de nos webmarketeurs spécialisés dans le référencement afin d'établir un devis, de poser vos quesions ou pour toute autre demande.
                    <br/><br/> C'est bien évidemment gratuit. Veuillez prendre rendez-vous seulement si l'objet de votre demande nécessite au moins 30 minutes (durée minimum d'un rendez-vous).
                    <br/><br/><center><a href="#rdv"> <button class="btn btn-primary">Fixer un rendez-vous</button></a></center>
                    </p>	
			    </div> <!-- /widget-content -->
		     </div> <!-- /widget -->
	    </div> <!-- /span12 -->
        
        
        
        
        <div class="widget widget-nopad" id="rdv" style="margin-left:2%;">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Prendre un rendez-vous</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div id='calendar'>
              </div>
            </div>
            <!-- /widget-content --> 
          </div>
        
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
