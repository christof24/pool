<?php
include("funktionen.php");

logToFile("########### Start Tabletskript ###########");

$sql = query( "SELECT * FROM einstellungen");

$einstellungen = fetch($sql);
$startTablet = $einstellungen[startTablet];
$stopTablet = $einstellungen[stopTablet];
$laufzeit = $einstellungen[tabletWochentag];


$time = date('H:i:s');
$day = date('N');

$sql1 = query( "SELECT name,programm,gpio FROM aktor where name = 'Tablet'");
$aktor = fetch($sql1);

if(($time > $startTablet) && ($time < $stopTablet) && strpos($laufzeit, $day) !== false ){
	logToFile("########### Tablet AN ###########");
	logToFile("########### $day ###########");
  setGpio($aktor[gpio],"1");
}else{
	logToFile("########### Tablet AUS ###########");
	logToFile("########### $day ###########");
  setGpio($aktor[gpio],"0");
}