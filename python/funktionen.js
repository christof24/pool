var spinner = -1;
	var UserAgent = navigator.userAgent.toLowerCase();
	var iphone;
	if(!UserAgent.match(/iphone/i)) {
		iphone = false;	
	}else{
		iphone = true;
	}
/*
$.ajaxSetup({
    beforeSend: function() {
        // TODO: show your spinner
        //$('#ajaxSpinner').show();
        console.log(spinner);
        if(spinner == 0){
        	console.log('progressOn');
			//$("#progress").html('<img src="./icons/loading.gif" height="20">');
			progressOn();	
			spinner++;
		}else{
			spinner++;
		}
    },
    complete: function() {
    console.log(spinner);
        // TODO: hide your spinner
        if(spinner == 1){
        	console.log('progressOff');
			//$("#progress").html('');
			progressOff();
			spinner --;
		}else{
			spinner--;
		}	
    }
   
});
*/

function init() {

	//alert(iphone);
	getTemp('database');
	getTemp('file');
	
	getDate();
	getRaspTime();
	getSettings();
	getRelayStatus();
	
	console.log('init was called');
	
	getStatistik();
	getlogs();
	manuelles_schalten();
	refresh_gpios_manuell();

	if(!iphone) {
		//alert("kein Iphone");
		getRunning();
		getTempTrend();
		LoadWetter();
		drawVisualization_week();
		setInterval("drawVisualization();",600000);
		setInterval("getTempTrend();", 600000);
		setInterval("drawVisualization_week();",600000);
		setInterval("getRunning();", 60000);
		
	}
	setInterval("getTemp('file');", 11000);
	

	

	
}




function refresh_dashboard(){
//progressOn();
	//alert("Dash");
	if(!iphone) {
		getTempTrend();
		getRunning();
	}
	getDate();
	getRelayStatus();
	
//progressOff();
}

function refresh_statistik(){
	if(!iphone) {
		var refreshIntervalId_day = setTimeout("drawVisualization();",2000);
		var refreshIntervalId_week = setTimeout("drawVisualization_week();",2000);
	}
	var refreshIntervalId_stat = setTimeout("getStatistik();",2000);	
}

function refresh_settings(){
	//alert("sett");
	getSettings();
	getRaspTime();
}

function refresh_gpios_manuell(){
setTimeout("get_gpios_manuell();",0);
}

function get_gpios_manuell(){
	//alert(iphone);
	$.get('python/getGpios.php?update=true' , function(data) {
	
		var res = data.split(";"); 
		var arrayLength = res.length;
		
		for (var i = 0; i < arrayLength; i++) {
			var gpio = res[i].split(","); 
			var schalter = "#gpio-" + gpio[0] ;
				//alert (schalter + " " + gpio[1] );
				
					//alert(result);
					if(gpio[1] == 0){
						$(schalter).val(0).slider("refresh");
					}else{
						$(schalter).val(1).slider("refresh");
					}
				
				
			
		}
	});
	
	
}

function refresh_weather(){
	//alert("waether");
	LoadWetter();
}

function progressOn(){
//console.log('progressOn');
	$("#progress").html('<img src="./icons/loading.gif" height="20">');	
	$("#progress_log").html('<img src="./icons/loading.gif" height="20">');	
	$("#progress_stats").html('<img src="./icons/loading.gif" height="20">');
	$("#progress_settings").html('<img src="./icons/loading.gif" height="20">');		
}

function progressOff(){
	$("#progress").html('');	
	$("#progress_log").html('');	
	$("#progress_stats").html('');
	$("#progress_settings").html('');
//	console.log('progressOff');	
}

function getRaspTime(){

	$.get('python/getTime.php', function(data) {
	
		$("#raspTime").html(data);	
	
	});

}


function getTempTrend(){
	$.get('python/getTempTrend.php', function(data) {
		var trend = data.split(",");
		if(trend[0] > 0){
			$("#poolTrendImage").html('<img src="./icons/up.png" height="30">');	
			$("#poolTrend").html("+ " + trend[0] + " °C");
			
		
		}else{
			$("#poolTrendImage").html('<img src="./icons/down.png" height="30">');
			$("#poolTrend").html(trend[0] + " °C");
		}
		if(trend[1] > 0){
			$("#solarTrendImage").html('<img src="./icons/up.png" height="30">');	
			$("#solarTrend").html("+ " + trend[1] + " °C");
			
		
		}else{
			$("#solarTrendImage").html('<img src="./icons/down.png" height="30">');
			$("#solarTrend").html(trend[1] + " °C");
		}
		if(trend[2] > 0){
			$("#ruecklaufTrendImage").html('<img src="./icons/up.png" height="30">');	
			$("#ruecklaufTrend").html("+ " + trend[2] + " °C");
			
		
		}else{
			$("#ruecklaufTrendImage").html('<img src="./icons/down.png" height="30">');
			$("#ruecklaufTrend").html(trend[2] + " °C");
		}
		if(trend[3] > 0){
			$("#raspTrendImage").html('<img src="./icons/up.png" height="30">');	
			$("#raspTrend").html("+ " + trend[3] + " °C");
			
		
		}else{
			$("#raspTrendImage").html('<img src="./icons/down.png" height="30">');
			$("#raspTrend").html(trend[3] + " °C");
		}		
		
	});
}

function drawVisualization() {
	var jsonData = $.ajax({
		url: "python/getTempChart.php?func=heute",
		//url: "python/chart.php",
		dataType: "json",
		async: false
	}).responseText;

	var obj = jQuery.parseJSON(jsonData);
	var data = google.visualization.arrayToDataTable(obj);

	var options = {
		title: 'Temperaturen Heute',
		height: 500,
  		width: 900,
		vAxis: {title: "Grad °C", viewWindowMode:'explicit',viewWindow:{max:60, min:10,},gridlines: {count: 10}},
		hAxis: {title: "Uhrzeit",slantedText: true, slantedTextAngle:60,}
	};

	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	chart.draw(data, options);

}

function drawVisualization_week() {
	var jsonData = $.ajax({
		url: "python/getTempChart.php?func=woche",
		//url: "python/chart.php",
		dataType: "json",
		async: false
	}).responseText;

	var obj = jQuery.parseJSON(jsonData);
	var data = google.visualization.arrayToDataTable(obj);

	var options = {
		title: 'Temperaturen Woche',
		smoothLine: true,
		height: 500,
  		width: 900,
		vAxis: {title: "Grad °C", viewWindow:{max:60, min:10,},gridlines: {count: 10}},
		hAxis: {title: "Datum", gridlines: { count: 7, color: '#CCC' }, slantedText: false, slantedTextAngle:60,}

	};

	var chart = new google.visualization.LineChart(document.getElementById('chart_div_woche'));
	chart.draw(data, options);

}

function getlogs(){
	$.get('python/getLog.php', function(data) {
		
		$("#logcontent").html(data);
		
	});

}

function getDate(){
	var jetzt = new Date();	
	var Wochentag = new Array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
	var Monate    = new Array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
	var TagInWoche = jetzt.getDay();
	var Jahr = jetzt.getFullYear();
	var Jahresmonat = jetzt.getMonth();
	var Tag = jetzt.getDate();	
	$(".date").html(Wochentag[TagInWoche] + ", " + Tag + ". " + Monate[Jahresmonat] + " " + Jahr);
	
	
	var seconds = jetzt.getSeconds();
	var minutes = jetzt.getMinutes();
	var hours = jetzt.getHours();
	
	$(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	$(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
	$(".hours").html(( hours < 10 ? "0" : "" ) + hours);
	
}

function getStatistik(){
	
	$.get('python/getStatTable.php', function(data) {
		$("#tableVerbrauch").html(data);
	});
	
}

function setLaufzeit(){

	var diff1 = $("#sliderPumpe-b").val() - $("#sliderPumpe-a").val();
	var diff2 = $("#sliderPumpe-b1").val() - $("#sliderPumpe-a1").val();
	var gesamt = diff1 + diff2;
	
	var hours = Math.floor(gesamt / 60);
	var minutes = gesamt - (hours * 60);

	if(hours.length ==1) hours = '0' + hours;
	if(minutes.length == 1 || minutes == 0) minutes = '0' + minutes;
	
	
	$("#laufzeitGesamt").val('Dauer: ' + hours + ':' + minutes);


}


function getRunning(){
	
	$.get('python/getVerbrauch.php?pin=Pool,Solar,Licht&aktion=dashboard', function(data) {
	
		var string = data.split("</br>");
		
		//Pumpe
		var gpio = string[0].split("||");
		var heute_23 = gpio[1].split(";");
		var gestern_23 = gpio[2].split(";");
		var monat_23 = gpio[3].split(";");
		
		$("#pumpe_heute").html("Heute<span style=\"float:right\">" + heute_23[0] + " / " + heute_23[1] + " KW/h </span>");
		$("#pumpe_gestern").html("Gestern<span style=\"float:right\">" + gestern_23[0] + " / " + gestern_23[1] + " KW/h </span>");
		$("#pumpe_monat").html("Monat<span style=\"float:right\">" + monat_23[0] + " / " + monat_23[1] + " KW/h </span>");
		
		
		//Licht
		var gpio = string[2].split("||");
		var heute_25 = gpio[1].split(";");
		var gestern_25 = gpio[2].split(";");
		var monat_25 = gpio[3].split(";");
		
		$("#licht_heute").html("Heute<span style=\"float:right\">" + heute_25[0] + " / " + heute_25[1] + " KW/h </span>");
		$("#licht_gestern").html("Gestern<span style=\"float:right\">" + gestern_25[0] + " / " + gestern_25[1] + " KW/h  </span>");
		$("#licht_monat").html("Monat<span style=\"float:right\">" + monat_25[0] + " / " + monat_25[1] + " KW/h  </span>");
		
		//Solar
		var gpio = string[1].split("||");
		var heute_24 = gpio[1].split(";");
		var gestern_24 = gpio[2].split(";");
		var monat_24 = gpio[3].split(";");
		//console.log(gpio);
		$("#solar_heute").html("Heute<span style=\"float:right\">" + heute_24[0] + "</span>");
		$("#solar_gestern").html("Gestern<span style=\"float:right\">" + gestern_24[0] + "</span>");
		$("#solar_monat").html("Monat<span style=\"float:right\">" + monat_24[0] + "</span>");
		
		
	});
}

function getSettings(){
	$.get('python/getSettings.php', function(data) {
		var settings = data.split(",");
		//array of Settings
		//0 = maxWasser Temp
		//1 = Diff temp
		//2 = minSolar Temp
		//3 = startPumpe Uhrzeit
		//4 = stopPumpe Uhrzeit
		//5 = startPumpe1 Uhrzeit
		//6 = stopPumpe1 Uhrzeit
		//7 = startTablet Uhrzeit
		//8 = stopTablet Uhrzeit
		//9 = tabletWochentag (Mo,Di,Mi)
		
		//alert("2");
		$("#maxWasserTemp").val(settings[0]);
		$("#diffTempSolar").val(settings[1]);
		$("#minSolarTemp").val(settings[2]);
		//$("#sliderPumpe-a").val(1000);
		
		var start = settings[3].split(":");
		var startMinuten = parseInt(start[0]) * 60; 
		startMinuten = startMinuten + parseInt(start[1]);
		$("#hiddenstart").val(startMinuten);
		
		
		var start = settings[4].split(":");
		var startMinuten = parseInt(start[0]) * 60; 
		startMinuten = startMinuten + parseInt(start[1]);
		$("#hiddenstop").val(startMinuten);
		
		var start = settings[5].split(":");
		var startMinuten = parseInt(start[0]) * 60; 
		startMinuten = startMinuten + parseInt(start[1]);
		$("#hiddenstart1").val(startMinuten);
		
		
		var start = settings[6].split(":");
		var startMinuten = parseInt(start[0]) * 60; 
		startMinuten = startMinuten + parseInt(start[1]);
		$("#hiddenstop1").val(startMinuten);
		
		var start = settings[7].split(":");
		var startMinuten = parseInt(start[0]) * 60; 
		startMinuten = startMinuten + parseInt(start[1]);
		$("#hiddenstartTablet").val(startMinuten);
		
		var start = settings[8].split(":");
		var startMinuten = parseInt(start[0]) * 60; 
		startMinuten = startMinuten + parseInt(start[1]);
		$("#hiddenstopTablet").val(startMinuten);
		
		//Wochentage reseten
		$("#tablet-1").prop("checked",false).checkboxradio("refresh");
		$("#tablet-2").prop("checked",false).checkboxradio("refresh");
		$("#tablet-3").prop("checked",false).checkboxradio("refresh");
		$("#tablet-4").prop("checked",false).checkboxradio("refresh");
		$("#tablet-5").prop("checked",false).checkboxradio("refresh");
		$("#tablet-6").prop("checked",false).checkboxradio("refresh");
		$("#tablet-7").prop("checked",false).checkboxradio("refresh");
		
		//alert(settings[8]);
		var wochentag = settings[9].split(";");
		var arrayLength = wochentag.length;
		for (var i = 0; i < arrayLength; i++) {
			//alert(wochentag[i]);
			//Do something
			$("#tablet-" + wochentag[i]).prop("checked",true).checkboxradio("refresh");
			//$( "#pumpe_ein" ).prop( "checked", true ).checkboxradio( "refresh" );
		}

		
		$("#sliderPumpe-a").val($("#hiddenstart").val()).slider("refresh");
		$("#sliderPumpe-b").val($("#hiddenstop").val()).slider("refresh");		
		$("#sliderPumpe-a1").val($("#hiddenstart1").val()).slider("refresh");
		$("#sliderPumpe-b1").val($("#hiddenstop1").val()).slider("refresh");
		$("#sliderTablet-a").val($("#hiddenstartTablet").val()).slider("refresh");
		$("#sliderTablet-b").val($("#hiddenstopTablet").val()).slider("refresh");			

	});


}

function LoadWetter(){
	$.get('python/wetter.php', function(data) {
		$("#wettercontent").html(data);
		//alert(data);
	});

}

function manuelles_schalten(){
	$.get('python/getGpios.php?iphone=' + iphone, function(data) {
		$("#gpios_schalten").html(data);
		//alert(data);
	});

}
	
function getRelayStatus(){
	
	$.get('python/getGpioStatus.php?pin=Pool,Solar,Licht,Tablet', function(data) {

	var res = data.split(","); 
	//alert(res[0]);
		if (res[0] == 1) {
			$("#statusPumpe").html('<img src="./icons/status-on.png" width="30" height="30">');		
/*     		$( "#pumpe_ein" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#pumpe_aus" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#pumpe_auto" ).prop( "checked", false ).checkboxradio( "refresh" ); */
		}
		if (res[0] == 0) {
			$("#statusPumpe").html('<img src="./icons/status-off.png" width="30" height="30">');
/*    		$( "#pumpe_aus" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#pumpe_ein" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#pumpe_auto" ).prop( "checked", false ).checkboxradio( "refresh" );	 */
		}				
		if (res[1] == 1) {
			$("#statusSolar").html('<img src="./icons/status-on.png" width="30" height="30">');
/* 			$( "#solar_ein" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#solar_aus" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#solar_auto" ).prop( "checked", false ).checkboxradio( "refresh" ); */
		}
		if (res[1] == 0) {
			$("#statusSolar").html('<img src="./icons/status-off.png" width="30" height="30">');
/* 			$( "#solar_aus" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#solar_ein" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#solar_auto" ).prop( "checked", false ).checkboxradio( "refresh" ); */
		}				
		if (res[2] == 1) {
			$("#statusLicht").html('<img src="./icons/status-on.png" width="30" height="30">');
			$('#flip-licht').val('1').slider("refresh");
		}
		if (res[2] == 0) {
			$("#statusLicht").html('<img src="./icons/status-off.png" width="30" height="30">');
			$('#flip-licht').val('0').slider("refresh");
		}	
		
	});

	$.get('python/getProgramm.php?prog=Pool,Solar', function(data) {

	var res = data.split(","); 
	//alert(res[0]);
		if (res[0] == 1) {
			// $("#statusPumpe").html('<img src="./icons/status-on.png" width="30" height="30">');		
    		$( "#pumpe_ein" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#pumpe_aus" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#pumpe_auto" ).prop( "checked", false ).checkboxradio( "refresh" );
		}
		if (res[0] == 0) {
			// $("#statusPumpe").html('<img src="./icons/status-off.png" width="30" height="30">');
   			$( "#pumpe_aus" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#pumpe_ein" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#pumpe_auto" ).prop( "checked", false ).checkboxradio( "refresh" );	
		}
		if (res[0] == 3) {
			// $("#statusPumpe").html('<img src="./icons/status-off.png" width="30" height="30">');
   			$( "#pumpe_auto" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#pumpe_ein" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#pumpe_aus" ).prop( "checked", false ).checkboxradio( "refresh" );	
		}		
		if (res[1] == 1) {
			// $("#statusSolar").html('<img src="./icons/status-on.png" width="30" height="30">');
			$( "#solar_ein" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#solar_aus" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#solar_auto" ).prop( "checked", false ).checkboxradio( "refresh" );
		}
		if (res[1] == 0) {
			// $("#statusSolar").html('<img src="./icons/status-off.png" width="30" height="30">');
			$( "#solar_aus" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#solar_ein" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#solar_auto" ).prop( "checked", false ).checkboxradio( "refresh" );
		}
		if (res[1] == 3) {
			// $("#statusSolar").html('<img src="./icons/status-off.png" width="30" height="30">');
			$( "#solar_auto" ).prop( "checked", true ).checkboxradio( "refresh" );
			$( "#solar_ein" ).prop( "checked", false ).checkboxradio( "refresh" );
			$( "#solar_aus" ).prop( "checked", false ).checkboxradio( "refresh" );
		}
			
	});

}

function getTemp(action){

//28-0000045d2690,28-00000472367d
	$.get('python/getTemp.php?sensor=28-0000045c707e,28-0000045d2690,28-00000472367d,123456789&action=' + action, function(data) {
	//progressOn();
		//alert(data);
	sensoren = data.split(",");

	//Temperatur Pool
	if(sensoren[0].indexOf(".") >= 0){
		temp_pool = sensoren[0].split(".");
    	temp_pool[1] = temp_pool[1].substring(0,2);
    	$("#pool_temp").html(temp_pool[0] + "<span style=\"font-size:15px\">," + temp_pool[1] + "</span>°");
    }else{
    	$("#pool_temp").html(sensoren[0] + "<span style=\"font-size:15px\">,00</span>°");
    }
    sensoren[1].replace(/\r\n|\n/g,"<br>");
	//console.log(sensoren[1]);
	//Temperatur Solar
	if(sensoren[1].indexOf(".") >= 0){
		temp_solar = sensoren[1].split(".");
    	temp_solar[1] = temp_solar[1].substring(0,2);
    	$("#pool_solar").html(temp_solar[0] + "<span style=\"font-size:15px\">," + temp_solar[1] + "</span>°");  
	}else{
		$("#pool_solar").html(sensoren[1] + "<span style=\"font-size:15px\">,00</span>°"); 
	}
	
	
    sensoren[2].replace(/\r\n|\n/g,"<br>");
	//console.log(sensoren[1]);
	//Temperatur Solar
	if(sensoren[2].indexOf(".") >= 0){
		temp_solar = sensoren[2].split(".");
    	temp_solar[1] = temp_solar[1].substring(0,2);
    	$("#pool_ruecklauf").html(temp_solar[0] + "<span style=\"font-size:15px\">," + temp_solar[1] + "</span>°");  
	}else{
		$("#pool_ruecklauf").html(sensoren[2] + "<span style=\"font-size:15px\">,00</span>°"); 
	}
	//Raspberry Solar
	sensoren[3].replace(/\r\n|\n/g,"<br>");
	//alert(sensoren[2]);
	if(sensoren[3].indexOf(".") >= 0){
		temp_rasp = sensoren[3].split(".");
    	temp_rasp[1] = temp_rasp[1].substring(0,2);
    	$("#rasp_temp").html(temp_rasp[0] + "<span style=\"font-size:15px\">," + temp_rasp[1] + "</span>°");  
	}else{
		$("#rasp_temp").html(sensoren[3] + "<span style=\"font-size:15px\">,00</span>°"); 
	}
	//progressOff();
	});

}

