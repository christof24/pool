<?php //Wird nach jedem Start ausgeführt!!!
include("funktionen.php");
logToFile("############ Start Initial Skript ###########");

$sql = query("select programm,gpio from aktor");
while($row = fetch($sql)){
//setGpio($gpio,$value)
//var_dump($row[programm]);
	if($row[programm] == "0"){
		setGpio($row[gpio],"0");
		echo "Setze gpio Initial: $row[gpio] auf 0<br>" ;
	}elseif($row[programm] == "1"){
		setGpio($row[gpio],"1");
		echo "Setze gpio Initial: $row[gpio] auf 1<br>" ;
	}
	//echo $row[programm];
}
logToFile("############ Stop Initial Skript  ###########");

?>