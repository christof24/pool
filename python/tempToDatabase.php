
<?php
include("funktionen.php");


$sql = query( "SELECT * FROM sensoren");
//var_dump($sql);
while( $sensor = fetch( $sql ) ){

	$sensors[$sensor[name]] = getSensorTemp($sensor[sensorId]);
	$temp = getSensorTemp($sensor[sensorId]);
	$sql1 = query("SELECT value FROM logtemp WHERE name= '" . $sensor[name] . "' ORDER BY id DESC LIMIT 1") ;
	$temp_1h = fetch( $sql1 );
	//var_dump($temp_1h);
	$diff = $temp - $temp_1h[0];
	$diff = sprintf("%1\$.2f",$diff);
	//echo $sensor[name] . " - 1h: " . $temp_1h[0] . " - aktuell: " . $temp . " diff:" . $diff . "<br>" ;
	$update = query("UPDATE temptrend SET $sensor[name] =  '" . $diff . "' ");


	logSensortemp($sensor[name],$sensor[sensorId],$temp);
	
}

//$cpu_temperature = round(exec("cat /sys/class/thermal/thermal_zone0/temp ") / 1000, 2);
//logSensortemp("Raspberry","1",$cpu_temperature);


?>