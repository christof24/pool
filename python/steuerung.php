<?php
include("funktionen.php");

logToFile("########### Start Steuerungsskript ###########");

$sql = query( "SELECT * FROM einstellungen");

$einstellungen = fetch($sql);
$startPumpe = $einstellungen[startPumpe];
$stopPumpe = $einstellungen[stopPumpe];
$startPumpe1 = $einstellungen[startPumpe1];
$stopPumpe1 = $einstellungen[stopPumpe1];
$sollWasser = $einstellungen[maxWasser];
$minSolar = $einstellungen[minSolar];
$diffTemp = $einstellungen[diffTemp];

$sql = query( "SELECT name,programm,gpio FROM aktor where name = 'Pool'");
$pool = fetch($sql);

$sql = query( "SELECT name,programm,gpio FROM aktor where name = 'Solar'");
$solar = fetch($sql);
//$programm = fetch($sql);
//echo $maxWasser;
//echo $startPumpe . "<br>";
//echo $stopPumpe. "<br><br>";
//var_dump($row);
//echo $solar[gpio];


//Check Temperaturen

$SolarTemp = getSolarTemp();
$PoolTemp = getPoolTemp();
$RuecklaufTemp = getRuecklaufTemp();


$time = date('H:i:s');
//echo $time. "<br>";

if($pool[programm] == 3){
	if(($time > $startPumpe) && ($time < $stopPumpe) || ($time > $startPumpe1) && ($time < $stopPumpe1)){
		echo "Pumpe AN - Innerhalb der Uhrzeit" . "<br>";
		logToFile("Skript: Pumpe EIN - Innerhalb der Zeit");
		setGpio($pool[gpio],"1");
		if($solar[programm] == 3){
			if(checkPoolTemp()){
				if(checkSolarTemp()){
					echo "Solar Heizen - Solarpanel Heiss" . "<br>";
					setGpio($solar[gpio],"1");		
				}else{
					echo "Solar Aus - Solarpanel nicht Warm genug!" . "<br>";
					setGpio($solar[gpio],"0");
				}
			}else{
				echo "Solar Aus - Pool Temperatur zu hoch!" . "<br>";
				setGpio($solar[gpio],"0");
				logToFile("Skript: Solar AUS - Pool Temperatur zu hoch");
			}
		}else{
			setGpio($solar[gpio], $solar[programm]);
			logToFile("Skript: Solar $solar[programm], da Programm Manuell");	
		}
	}else{
		//checkPoolTemp();	
		echo "Alles AUS - Uhrzeit liegt außerhalb des Bereiches";
		
		setGpio($pool[gpio],"0");
		setGpio($solar[gpio],"0");
		logToFile("Skript: Pumpe und Solar AUS - Außerhalb der Zeit");
	}
	
}elseif($pool[programm] == 0){
	logToFile("Skript: Solar AUS - da Pumpe manuell AUS");
	setGpio($solar[gpio],"0");
	//echo "nichts machen";
}else{
	logToFile("########### Nichts zu tun, da Pumpe Manuell ###########");

}
logToFile("########### Ende Steuerungsskript ###########");

function checkPoolTemp(){
	global $sollWasser,$PoolTemp;
	//$sql = query( "SELECT sensorId FROM sensoren where name = 'Pool'");
	//$row = fetch($sql);
	//$temp = getSensorTemp($row[sensorId]);
	
	if($sollWasser > $PoolTemp){
		logToFile("Skript: Solar evtl. EIN muss noch Panel Temperatur prüfen - Pool: IST: $PoolTemp Soll.: $sollWasser");
		return 1;
	}else{
		logToFile("Skript: Solar AUS - Pool IST: $PoolTemp Soll.: $sollWasser");
		return 0;
	}
	
}


function checkTempDiff(){
	global $PoolTemp,$RuecklaufTemp,$diffTemp;

	$diff = $RuecklaufTemp - $PoolTemp;
	
	if($diff >= $diffTemp){
		logToFile("Skript: Solar EIN - Solarpanel Diff: $diff SollDiff.: $diffTemp");
		return 1;
	}else{
		logToFile("Skript: Solar AUS - Solarpanel Diff: $diff SollDiff.: $diffTemp");
		return 0;
	}
	
}

function checkSolarTemp(){
	global $minSolar,$SolarTemp;

	
	if($minSolar < $SolarTemp){
		logToFile("Skript: Solar EIN - Solarpanel IST: $SolarTemp Min.: $minSolar");
		return 1;
	}else{
		logToFile("Skript: Solar AUS - Solarpanel IST: $SolarTemp Min.: $minSolar");
		return 0;
	}
	
}

function getRuecklaufTemp(){
	$sql = query( "SELECT sensorId FROM sensoren where name = 'Ruecklauf'");
	$row = fetch($sql);
	$temp = getSensorTemp($row[sensorId]);

  return $temp;

}

function getSolarTemp(){
	$sql = query( "SELECT sensorId FROM sensoren where name = 'Solar'");
	$row = fetch($sql);
	$temp = getSensorTemp($row[sensorId]);

  return $temp;


}

function getPoolTemp(){
	$sql = query( "SELECT sensorId FROM sensoren where name = 'Pool'");
	$row = fetch($sql);
	$temp = getSensorTemp($row[sensorId]);

  return $temp;


}

?>