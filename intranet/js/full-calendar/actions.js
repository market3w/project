function addAppointment(start,end){
	//Reformater la date et l'heure de début et de fin
	var startTemp = appointment.start.toString().split(" ");
	var startDate = startTemp[2]+"/"+getMonthNumber(startTemp[1])+"/"+startTemp[3];
	var startHour = startTemp[4];
	var endTemp = appointment.end.toString().split(" ");
	var endDate = endTemp[2]+"/"+getMonthNumber(endTemp[1])+"/"+endTemp[3];
	var endHour = endTemp[4];
	
	alert("debut : " + startDate + " " + startHour + "\n" + "fin : " + endDate + " " + endHour);
	location.reload();
}(jQuery)

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
	
	alert("titre : " + appointment.title + "\n" + "debut : " + startDate + " " + startHour + "\n" + "fin : " + endDate + " " + endHour);
	location.reload();
}(jQuery)

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