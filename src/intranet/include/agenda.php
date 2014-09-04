<?php
$appointments = $client->get_allappointmentcurrent();
?>
<!-- /widget -->
<div class="widget widget-nopad">
    <div class="widget-header"> <i class="icon-list-alt"></i>
        <h3><?php echo $agenda_titre; ?></h3>
        <?php if($_SESSION["validMessage"]!=""){ ?>
        <span style="color: #218c0c;"><b><?php echo $_SESSION["validMessage"]; ?></b></span>
        <?php } ?>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div id='calendar'>
        </div>
    </div>
    <!-- /widget-content --> 
</div>
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
            right: 'month'
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
            <?php
            $firstAppointment = true;
            foreach ($appointments as $appointment){
                if($firstAppointment===false){
                    echo ",";
                } else {
                    $firstAppointment = false;
                }
                preg_match("/([0-9]{4}), ([0-9]{2}),(.*)/", substr(str_replace(":",", ", str_replace("-",", ", str_replace(" ", ", ", $appointment->appointment_start_date))), 0, -4), $temp);
                $startDate = $temp[1].",".((($temp[2]-1)<10)?"0".($temp[2]-1):($temp[2]-1)).",".$temp[3];
                preg_match("/([0-9]{4}), ([0-9]{2}),(.*)/", substr(str_replace(":",", ", str_replace("-",", ", str_replace(" ", ", ", $appointment->appointment_end_date))), 0, -4), $temp);
                $endDate = $temp[1].",".((($temp[2]-1)<10)?"0".($temp[2]-1):($temp[2]-1)).",".$temp[3];
            ?>
            {
                id: <?php echo $appointment->appointment_id; ?>,
                title: "<?php echo $appointment->appointment_name; ?>",
                description: "<?php echo $appointment->appointment_description; ?>",
                start: new Date(<?php echo $startDate; ?>),
                end: new Date(<?php echo $endDate; ?>),
                user_id: "<?php echo $appointment->appointment_user->user_id; ?>",
                webmarketter_id: "<?php echo $appointment->appointment_webmarketter->webmarketter_id; ?>",
                mode_id: "<?php echo $appointment->type_id; ?>",
                status_id: "<?php echo $appointment->status_id; ?>",
                <?php if(isset($appointment->type)){ ?>type: "<?php echo $appointment->type; ?>",<?php } ?>
                allDay: false
            }
            <?php } ?>
        ]
    });
	
});
</script><!-- /Calendar -->
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/actions.js"></script>
<?php if($_SESSION["errorMessage"]!=""){ ?>
<script>
    $(document).ready(function(){
        <?php if($_SESSION["method"]=="add_appointment") { ?>
        $("#add-appointment").show();
        $("#edit-appointment").hide();
        <?php } else { ?>
        $("#edit-appointment").show();
        $("#add-appointment").hide();
        <?php } ?>
        $(".fermer_pop_up").fadeIn(500);
        $(".popup_rdv").fadeIn(500);
    });
</script>
<?php } ?>