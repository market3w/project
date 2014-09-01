<?php  
include('include/config.php');
$page='contact';  ?>
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
      
     	<div class="span12">
	      	<div id="target-1" class="widget">
	      		<div class="widget-content">
	      			<h1 style="margin-bottom:10px;color:#80B3CA;">Contacter-nous</h1>
			      		
			      	<p>N'hésiter pas à nous contacter par le formulaire pour toute question ou demande, un de nos webmarketeurs vous répondra dans les plus brefs délais.</p>	<br/><br/>
                   <form id="contact" action="contact.php" class="form-horizontal" method="post">
                   <input type="hidden" name="method" value="contact"/>
                   <span class="responseError" id="loginError"><?php echo $_SESSION["errorMessage"]; ?></span>
                   <?php if(isset($_SESSION["method"]) && $_SESSION["method"]=='contact' && $_SESSION["errorMessage"]==''){echo'Message envoyé avec succés';} ?>
                              
                    <fieldset>
                        
                        <div class="control-group">											
                            <label class="control-label" for="user_name">Nom</label>
                            <div class="controls">
                                <input type="text" class="span4" name="user_name" value="<?php echo $currentuser->user_name; ?>" >
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                        <div class="control-group">											
                            <label class="control-label" for="user_firstname">Prénom</label>
                            <div class="controls">
                                <input type="text" class="span4" name="user_firstname" value="<?php echo $currentuser->user_firstname; ?>">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                        <div class="control-group">											
                            <label class="control-label" for="email">Adresse email</label>
                            <div class="controls">
                                <input type="text" class="span4" name="user_email" value="<?php echo $currentuser->user_email; ?>">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        <div class="control-group">											
                            <label class="control-label" for="objet">Objet</label>
                            <div class="controls">
                                <input type="text" class="span4" name="objet" value="<?php echo (array_key_exists("objet",$_POST))?$_POST["objet"]:""; ?>" placeholder="Indiquer l'objet du contact">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                      <div class="control-group">											
                            <label class="control-label" for="message">Message</label>
                            <div class="controls">
                                <textarea class="span4" name="message" placeholder="Indiquer votre message"><?php echo (array_key_exists("message",$_POST))?$_POST["message"]:""; ?></textarea>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                            
                        <div class="control-group">
                           <button type="submit" class="btn btn-primary" style="margin-left:20%;">Envoyer</button>
                            <!--<button class="btn">Cancel</button>-->
                        </div> <!-- /form-actions -->
                    </fieldset>
                </form>
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
