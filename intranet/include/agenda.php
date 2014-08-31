<?php
$appointments = $client->get_allappointment();
?>
<!-- /widget -->
<div class="widget widget-nopad">
    <div class="widget-header"> <i class="icon-list-alt"></i>
        <h3><?php echo $agenda_titre; ?></h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div id='calendar'>
        </div>
    </div>
    <!-- /widget-content --> 
</div>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/actions.js"></script>
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
                title: '<?php echo $appointment->appointment_name; ?>',
                start: new Date(<?php echo $startDate; ?>),
                end: new Date(<?php echo $endDate; ?>),
                allDay: false
            }
            <?php } ?>
        ]
    });
	
});
</script><!-- /Calendar -->