function addAppointment(start,end){
    //Reformater la date et l'heure de début et de fin
    var startTemp = start.toString().split(" ");
    var startDate = startTemp[2]+"/"+getMonthNumber(startTemp[1])+"/"+startTemp[3];
    var startHour = startTemp[4];
    var endTemp = end.toString().split(" ");
    var endDate = endTemp[2]+"/"+getMonthNumber(endTemp[1])+"/"+endTemp[3];
    var endHour = endTemp[4];
    
    $("#add-appointment").show();
    $("#edit-appointment").hide();
    $("#add-appointment input[name=appointment_start_date]").val(startDate);
    $("#add-appointment input[name=appointment_start_date2]").val(startHour);
    $("#add-appointment input[name=appointment_end_date]").val(endDate);
    $("#add-appointment input[name=appointment_end_date2]").val(endHour);
    
    //Clic rdv ouvre popup
    $(".fermer_pop_up").fadeIn(500);
    $(".popup_rdv").fadeIn(500);
}(jQuery);

function editAppointment(id){
    var appointment;
    $.each($("#calendar").fullCalendar('clientEvents'), function(key, val) { 
        if(val.id==id){
            appointment = val;
        }
    });

    //Reformater la date et l'heure de début et de fin
    var startTemp = appointment.start.toString().split(" ");
    var startDate = startTemp[2]+"/"+getMonthNumber(startTemp[1])+"/"+startTemp[3];
    var startHour = startTemp[4];
    var endTemp = appointment.end.toString().split(" ");
    var endDate = endTemp[2]+"/"+getMonthNumber(endTemp[1])+"/"+endTemp[3];
    var endHour = endTemp[4];
    
    $("#add-appointment").hide();
    $("#edit-appointment").show();
    $("#edit-appointment input[name=appointment_id]").val(id);
    $("#edit-appointment input[name=user_id]").val(appointment.user_id);
    $("#edit-appointment input[name=webmarketter_id]").val(appointment.webmarketter_id);
    $("#edit-appointment input[name=appointment_name]").val(appointment.title);
    $("#edit-appointment textarea[name=appointment_description]").val(appointment.description);
    $("#edit-appointment input[name=appointment_start_date]").val(startDate);
    $("#edit-appointment input[name=appointment_start_date2]").val(startHour);
    $("#edit-appointment input[name=appointment_end_date]").val(endDate);
    $("#edit-appointment input[name=appointment_end_date2]").val(endHour);
    $("#edit-appointment select[name=type_id]").val(appointment.mode_id);
    $("#edit-appointment select[name=status_id]").val(appointment.status_id);
    
    //Clic rdv ouvre popup
    $(".fermer_pop_up").fadeIn(500);
    $(".popup_rdv").fadeIn(500);
}(jQuery);

function getMonthNumber(month){
	var list = {
		"Jan" : "01",
		"Feb" : "02",
		"Mar" : "03",
		"Apr" : "04",
		"May" : "05",
		"Jun" : "06",
		"Jul" : "07",
		"Aug" : "08",
		"Sep" : "09",
		"Oct" : "10",
		"Nov" : "11",
		"Dec" : "12"
	};
	return list[month];
}

 $(document).ready(function() {	
    //FERMER POPUP CLIC RDV
    $(".fermer_pop_up").on('click', function(){
        location.reload();
    });
    
    //EDITER UN RDV
    $("#appointment_edit").on('click', function(){
        $("#edit-appointment input[name=method]").val("edit_appointment");
        $("#edit-appointment").submit();
    });
    
    //ANNULER UN RDV
    $("#appointment_cancel").on('click', function(){
        if (confirm("Voulez-vous vraiment annuler votre rendez-vous ?")) { // Clic sur OK
            $("#edit-appointment input[name=method]").val("cancel_appointment");
            $("#edit-appointment").submit();
        }
    });
    
    //RDV EFFECTUE
    $("#appointment_valid").on('click', function(){
        $("#edit-appointment input[name=method]").val("valid_appointment");
        $("#edit-appointment").submit();
    });
 });