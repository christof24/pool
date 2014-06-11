<?php
include("funktionen.php");

logToFile("########### Start Steuerungsskript ###########");

$sql = query( "SELECT * FROM einstellungen");

$einstellungen = fetch($sql);
$startPumpe = $einstellungen[startPumpe];
$stopPumpe = $einstellungen[stopPumpe];
$sollWasser = $einstellungen[maxWasser];
$minSolar = $einstellungen[minSolar];

$sql = query( "SELECT name,programm,gpio FROM aktor where name = 'Pool'");
$pool = fetch($sql);

$sql = query( "SELECT name,programm,gpio FROM aktor where name = 'Solar'");
$solar = fetch($sql);


$time = date('H:i:s');
//echo $time. "<br>";

if(($time > $startPumpe) && ($time < $stopPumpe)){
	if($pool[programm] == 3){
		echo "Pumpe AN - Innerhalb der Uhrzeit" . "<br>";
		logToFile("Skript: Pumpe Automatik EIN - Innerhalb der Zeit");
		setGpio($pool[gpio],"1");
	}else{
		logToFile("Skript: Pumpe steht auf Manuell");
	}
	if($solar[programm] == 3){
		if(checkSolarTemp() && checkPoolTemp()){
			logToFile("Skript: Solar Automatik EIN");
			setGpio($solar[gpio],"1");
		}else{
			logToFile("Skript: Solar Automatik AUS");
			setGpio($solar[gpio],"0");
		}
	}else{
		logToFile("Skript: Solar steht auf Manuell");
	}
}else{
	//checkPoolTemp();	
	echo "Alles AUS - Uhrzeit liegt außerhalb des Bereiches";
	if($pool[programm] == 3){
		setGpio($pool[gpio],"0");
		logToFile("Skript: Pumpe Automatik AUS -  Außerhalb der Zeit");
	}
	if($solar[programm] == 3){
		setGpio($solar[gpio],"0");
		logToFile("Skript: Solar Automatik AUS - Außerhalb der Zeit");
	}
	
}

logToFile("########### Ende Steuerungsskript ###########");



function checkPoolTemp(){
	global $sollWasser;
	$sql = query( "SELECT sensorId FROM sensoren where name = 'Pool'");
	$row = fetch($sql);
	$temp = getSensorTemp($row[sensorId]);
	logToFile("Skript: Prüfe Pooltemperatur - Pool: IST: $temp Soll.: $sollWasser");
	if($sollWasser > $temp){
		//logToFile("Skript: Solar evtl. EIN muss noch Panel Temperatur prüfen - Pool: IST: $temp Soll.: $sollWasser");
		return 1;
	}else{
		//logToFile("Skript: Solar AUS - Pool IST: $temp Soll.: $sollWasser");
		return 0;
	}
	
}

function checkSolarTemp(){
	global $minSolar;
	$sql = query( "SELECT sensorId FROM sensoren where name = 'Solar'");
	$row = fetch($sql);
	$temp = getSensorTemp($row[sensorId]);
	logToFile("Skript: Prüfe Solartemperatur - Solarpanel IST: $temp Min.: $minSolar");
	if($minSolar > $temp){
		//logToFile("Skript: Solar EIN - Solarpanel IST: $temp Min.: $minSolar");
		return 1;
	}else{
		//logToFile("Skript: Solar AUS - Solarpanel IST: $temp Min.: $minSolar");
		return 0;
	}
	
}

?>