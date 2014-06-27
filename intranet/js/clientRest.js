function query(httpMethod, request){
	
	var url = window.location.toString();
	var temp = url.substr(7,url.lenght);
	var temp = temp.substr(0,temp.indexOf("/"));
	if(temp == "intranet.market3w.local" || temp == "intranet.market3w.com"){
		var server = "http://"+temp.replace("intranet", "api")+"/";
	} else {
		var server = "http://127.0.0.1/market3w/api/";
	}
	
    $.ajax({
        url        : server,
        type       : httpMethod,
        datatype   : "json",
        data       : request,
        success    : function(response,status){
            console.log(response);
        }
    });
}