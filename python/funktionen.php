<?php
error_reporting(E_ALL);
setlocale(LC_ALL,'de_DE@euro', 'de_DE',  'de', 'ge');
date_default_timezone_set('Europe/Berlin');
setlocale(LC_TIME, "de_DE");
include("config.php");


function query( $qry ){
  $sql = mysql_query( $qry )or die(mysql_error());
  return $sql;
}

function fetch( $query ){
  $fetch = mysql_fetch_array( $query );
  return $fetch;
}

function ping($host, $timeout = 1){
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	//echo 'This is a server using Windows!';
	$online=exec("ping -n 1 $host", $output, $error); 
	} else {
	//echo 'This is a server not using Windows!';
	$online=exec("ping -c 1 $host", $output, $error); 
	}
	//echo $online;
	if(stristr($online, 'Mittelwert') === FALSE) {   
		if(stristr($online, 'min/avg/max') === FALSE) {
			if(stristr($online, 'Average') === FALSE) { 
			  //echo $online;
				return 0;
			}else{
				return 1;
			} 
		}else{
			return 1;
		} 
	}else{
		return 1;
	}
        
}

function secToTime($sekunden) {
	
	$tTag = 'Tage';
	$tStunden = 'Std.';
	$tMinuten = 'Min.';
	$tSekunden = 'Sek.';
	
	if( defined('iphone') )
	{
		$tTag = 'd';
		$tStunden = 'h';
		$tMinuten = 'min';
		$tSekunden = 'sek';
	}
	
    if (!($sekunden >= 60)) 
    {
        //return $sekunden . ' ' . $tSekunden;
        return '0 Min.';
    }

    $minuten    = bcdiv($sekunden, '60', 0);
    $sekunden   = bcmod($sekunden, '60');

    if (!($minuten >= 60)) 
    {
//         return $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    	return $minuten . ' ' . $tMinuten . ' ';
    }

    $stunden    = bcdiv($minuten, '60', 0);
    $minuten    = bcmod($minuten, '60');

    if (!($stunden >= 24)) 
    {
    	if( $stunden == 1 )
    	{
//     		return $stunden . ' Stunde ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    		return $stunden . ' Std. ' . $minuten . ' ' . $tMinuten . ' ';
    	}
    	else
//           return $stunden . ' ' . $tStunden . ' ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    		return $stunden . ' ' . $tStunden . ' ' . $minuten . ' ' . $tMinuten . ' ';
    }

    $tage       = bcdiv($stunden, '24', 0);
    $stunden    = bcmod($stunden, '24');
    
    if( $stunden == 1 )
    {
//     		return $tage . ' Tage ' . $stunden . ' Stunde ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    	return $tage . ' T. ' . $stunden . ' Std. ' . $minuten . ' ' . $tMinuten . ' ';
    }
	else
//     	return $tage . ' Tage ' . $stunden . ' Stunden ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
		return $tage . ' T. ' . $stunden . ' Std. ' . $minuten . ' ' . $tMinuten . '';
}


function secToTimeMonat($sekunden) {
	
	$tTag = 'Tage';
	$tStunden = 'Std.';
	$tMinuten = 'Min.';
	$tSekunden = 'Sek.';
	
	if( defined('iphone') )
	{
		$tTag = 'd';
		$tStunden = 'h';
		$tMinuten = 'min';
		$tSekunden = 'sek';
	}
	
    if (!($sekunden >= 60)) 
    {
        //return $sekunden . ' ' . $tSekunden;
        return '0 Min.';
    }

    $minuten    = bcdiv($sekunden, '60', 0);
    $sekunden   = bcmod($sekunden, '60');

    if (!($minuten >= 60)) 
    {
//         return $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    	return $minuten . ' ' . $tMinuten . ' ';
    }

    $stunden    = bcdiv($minuten, '60', 0);
    $minuten    = bcmod($minuten, '60');

    if (!($stunden >= 24)) 
    {
    	if( $stunden == 1 )
    	{
//     		return $stunden . ' Stunde ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    		return $stunden . ' Std. ' . $minuten . ' ' . $tMinuten . ' ';
    	}
    	else
//           return $stunden . ' ' . $tStunden . ' ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    		return $stunden . ' ' . $tStunden . ' ' . $minuten . ' ' . $tMinuten . ' ';
    }

    $tage       = bcdiv($stunden, '24', 0);
    $stunden    = bcmod($stunden, '24');
    
    if( $stunden == 1 )
    {
//     		return $tage . ' Tage ' . $stunden . ' Stunde ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
    	return $tage . ' T. ' . $stunden . ' Std. ';
    }
	else
//     	return $tage . ' Tage ' . $stunden . ' Stunden ' . $minuten . ' ' . $tMinuten . ' ' . $sekunden . ' ' . $tSekunden . '';
		return $tage . ' T. ' . $stunden . ' Std. ';
}

function VerbrauchHeute($gpio){

	$sql = query( "SELECT * FROM aktor WHERE gpio = '" . $gpio . "' ");
	$row = fetch($sql);
	
	$zeitAus = time();
	if($row['zeitEin'] > 0){
		$zeitDelta = $zeitAus - $row['zeitEin'];
	}else{
		$zeitDelta = 0;
	}
	//echo $zeitDelta;
	$zeitHeute = $row['zeitHeute'] + $zeitDelta;
	$zeitHeute = intval($zeitHeute);
	
	$watt = $row['verbrauchWatt'];
	$verbrauch['kwh'] = round($watt * $zeitHeute / 60 / 60 / 1000, 2);
	
	$kwhPreis = 0.28;
	$verbrauch['euro'] = round($kwhPreis * $verbrauch['kwh'], 2);
	$verbrauch['zeit'] = $zeitHeute;
	return $verbrauch;
	
}

function verbrauchTimestamp($timestamp,$gpio){
	//global $verbrauch;

	$verbrauchTimestamp = 0.0;

	$sql = query( "SELECT kwh,zeitEin FROM logverbrauch WHERE date >= '" . $timestamp . "' AND gpio = '" . $gpio . "' " );
	while( $row = fetch( $sql ) )
	{
		$verbrauchTimestamp = $verbrauchTimestamp + $row['kwh'];
		$zeitTimestamp = $zeitTimestamp + $row['zeitEin'];
	}

	$euroTimestamp = $verbrauchTimestamp * 0.28;
	
	$verbrauch['kwh'] = round($verbrauchTimestamp,2);
	$verbrauch['euro'] = round($euroTimestamp,2);
	$verbrauch['zeit'] = $zeitTimestamp;
	return $verbrauch;
	
}

function verbrauchGestern($gpio){
	global $verbrauch;

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		$timestamp = mktime(23, 59, 59, $monat, $tag -1, $jahr);

	//echo "$timestamp ";				
	return verbrauchTimestamp($timestamp,$gpio);
	
}

function verbrauchWoche($gpio){

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		//$timestamp = mktime(0, 0, 0, $monat, $tag -7, $jahr);
		$timestamp = strtotime("last monday");
		//echo $tag -7;	
		$verbrauchWoche = verbrauchTimestamp($timestamp,$gpio);
		$verbrauchHeute = VerbrauchHeute($gpio);
		
		$verbrauch['kwh'] = $verbrauchWoche['kwh'] + $verbrauchHeute['kwh'];
		$verbrauch['euro'] = $verbrauchWoche['euro'] + $verbrauchHeute['euro'];
		$verbrauch['zeit'] = $verbrauchWoche['zeit'] + $verbrauchHeute['zeit'];
		
		return $verbrauch;					
		//return verbrauchTimestamp($timestamp,$gpio) + VerbrauchHeute($gpio);	
}

function verbrauchMonat($gpio){

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		$timestamp = mktime(0, 0, 0, $monat, 1, $jahr);	
		$verbrauchMonat = verbrauchTimestamp($timestamp,$gpio);
		$verbrauchHeute = VerbrauchHeute($gpio);
		
		$verbrauch['kwh'] = $verbrauchMonat['kwh'] + $verbrauchHeute['kwh'];
		$verbrauch['euro'] = $verbrauchMonat['euro'] + $verbrauchHeute['euro'];
		$verbrauch['zeit'] = $verbrauchMonat['zeit'] + $verbrauchHeute['zeit'];
		
		return $verbrauch;			
		//return verbrauchTimestamp($timestamp,$gpio) ;	
}

function verbrauchJahr($gpio){
	global $verbrauch;

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
		
		$timestamp = mktime(0, 0, 0, 1, 1, $jahr);
		$verbrauchJahr = verbrauchTimestamp($timestamp,$gpio);
		$verbrauchHeute = VerbrauchHeute($gpio);
		
		$verbrauch['kwh'] = $verbrauchJahr['kwh'] + $verbrauchHeute['kwh'];
		$verbrauch['euro'] = $verbrauchJahr['euro'] + $verbrauchHeute['euro'];
		$verbrauch['zeit'] = $verbrauchJahr['zeit'] + $verbrauchHeute['zeit'];
		
		return $verbrauch;			
		
						
	//return verbrauchTimestamp($timestamp,$gpio) + VerbrauchHeute($gpio);
	
}

function verbrauchTimeDiff($start,$end,$gpio){
	
	$verbrauchTimestamp = 0.0;

	$sql = query( "SELECT kwh,zeitEin,date FROM logverbrauch WHERE date >= '" . $start . "' AND date <= '" . $end . "' AND gpio = '" . $gpio . "' " );
	while( $row = fetch( $sql ) )
	{
		//echo date('m/d/Y', $row['date']) . "<br>";
		$verbrauchTimestamp = $verbrauchTimestamp + $row['kwh'];
		$zeitTimestamp = $zeitTimestamp + $row['zeitEin'];
	}

	$euroTimestamp = $verbrauchTimestamp * 0.28;
	
	$verbrauch['kwh'] = round($verbrauchTimestamp,2);
	$verbrauch['euro'] = round($euroTimestamp,2);
	$verbrauch['zeit'] = $zeitTimestamp;
	return $verbrauch;	

}

function verbrauchVorJahr($gpio){
	global $verbrauch;

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		//$endDate = mktime(0, 0, 0, 1, 1, $jahr);
		$endDate = mktime(0, 0, 0, 12, 31, $jahr - 1);	
		$startDate = mktime(0, 0, 0, 1, 1, $jahr - 1);
		
		return verbrauchTimeDiff($startDate,$endDate,$gpio);	
	
}

function verbrauchVorMonat($gpio){
	global $verbrauch;

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		$endDate = mktime(0, 0, 0, date("m") , 1,   date("Y"));
		$startDate = mktime(0, 0, 0, date("m")-1 , 1,   date("Y"));
		
		return verbrauchTimeDiff($startDate,$endDate,$gpio);	
	
}

function getSensorTemp($id){
	$count = 0;
	$error = true;
	if($id != "123456789"){
		$tempfile = "/sys/devices/w1_bus_master1/" . $id . "/w1_slave";
		while($error && $count < 3){
			exec("sudo cat $tempfile", $output);
			//var_dump($output);
			if($output){ 
				$pos = strpos($output[0], "YES");
				if ($pos > 1) {
					$temp = explode("t=", $output[1]);
					$temperatur = $temp[1] / 1000;  
					$error = false;	
				}else{   
					$error = true;
					$count++;
					sleep(1);
				}
			}else{ 
					$error = true;
					$count++;
					sleep(1);
			}	
		}
	}else{
		$error = false;
		$temperatur = round(exec("cat /sys/class/thermal/thermal_zone0/temp ") / 1000, 2);
	}
	if(!$error){
		$temperatur = sprintf("%1\$.2f",$temperatur);
		if($temperatur == "85"){
			echo "85";
			return "err";	
		}else{
			return $temperatur;
		}
	}else{
		return "err";
	}
}

function logSensortemp($name,$id,$temperatur){

	if($temperatur > 0){
		$sql = query("INSERT INTO logtemp VALUES( '', '" . $name . "', '" . $id . "', '" . $temperatur . "', '" . time() . "')");
	}

}

function setGpio($gpio,$value){
	
	//logToFile("GPIO: setze gpio: $gpio value: $value");
	//$value = intval($value);
	//Schalten GPIO
	$sql = query( "select toggle_gpio from aktor WHERE gpio = '" . $gpio . "'" );
	$row = fetch($sql);
	//var_dump($row);
	if($row[toggle_gpio] > 0){
		//echo "toggle!";
		if($value == 0){
			$out = file_put_contents('/sys/class/gpio/gpio' . $gpio . '/value', "0");
			logToFile("GPIO Manuell(Toogle): setze gpio: $gpio value: 0");	
			sleep(1);
			if(!getGpio($gpio)) {
				$out = file_put_contents('/sys/class/gpio/gpio' . $row[toggle_gpio] . '/value', "1");
				logToFile("GPIO Manuell(Toogle): setze gpio: $row[toggle_gpio] value: 1");
				//shell_exec("./setGpio_intervall.sh " . $row[toggle_gpio] . " 0 60 > /dev/null 2>/dev/null &" );	
				//logToFile("GPIO Manuell(Toogle): setze gpio nach 60s: $row[toggle_gpio] value: 0 ");
			}
		}
		elseif($value == "1"){
			$out = file_put_contents('/sys/class/gpio/gpio' . $row[toggle_gpio] . '/value', 0);
			logToFile("GPIO Manuell(Toogle): setze gpio: $row[toggle_gpio] value: 0");	
			sleep(1);
			if(!getGpio($row[toggle_gpio])) {
				$out = file_put_contents('/sys/class/gpio/gpio' . $gpio . '/value', "1");
				logToFile("GPIO Manuell(Toogle): setze gpio: $gpio value: 1");	
			}		
		}
		
		
	}elseif($row[toggle_gpio] == 0){
		$out = file_put_contents('/sys/class/gpio/gpio' . $gpio . '/value', $value);
		logToFile("GPIO Manuell: setze gpio: $gpio value: $value");	
	
	}
	
	//Datenbank Aktuallisieren
	$sql = query( "SELECT * FROM aktor WHERE gpio = '" . $gpio . "'" );
	$row = fetch($sql);	
	
	$zeitEin = $row['zeitEin'];
	//echo $value;
	if( $value == 'on' || $value > 0)
	{
		// Doppeltes Einschalten verhindern
		if( $zeitEin == 0 )
			$sql = query( "UPDATE aktor SET zeitEin = '" . time() . "' WHERE gpio = '" . $gpio . "'" );
	}
	
	elseif( $value == 'off' || $value == 0 )
	{	
		//var_dump($row['zeitEin']);
		// Doppeltes ausschalten verhindern
		if( $zeitEin > 0 )
		{
		
			$zeitAus = time();
			
	
			$zeitDelta = $zeitAus - $zeitEin;
	
			$zeitDelta = intval($zeitDelta);
			//rechneVerbrauch($pin,$zeitDelta);
			$zeitHeute = $row['zeitHeute'] + $zeitDelta;
			
			$sql = query( "UPDATE aktor SET zeitEin = '0', zeitHeute = '" . $zeitHeute . "' WHERE gpio = '" . $gpio . "'" );
		}
	}

}

function getGpio($gpio){
	exec("sudo cat /sys/class/gpio/gpio" . $gpio . "/value", $output);
	return $output[0];
}

function writeCrontab($start,$stop,$start1,$stop1,$startTablet,$stopTablet,$ladezeit) {

    $file = <<<END
# Dieser Crontab wurde automatisch mit der Pool Steuerung erstellt.
# Hier Keine Einträge machen, da diese automatisch mit einem Skript überschrieben werden.
# CD 2013

END;

	//$file .= "@reboot wget -q -O /dev/null localhost/python/initial.php\n";
    $file .= "*/5 $start-$stop * * * wget -q -O /dev/null localhost/python/steuerung.php\n";
    $file .= "*/5 $start1-$stop1 * * * wget -q -O /dev/null localhost/python/steuerung.php\n";
    $file .= "*/5 $startTablet-$stopTablet * * $ladezeit wget -q -O /dev/null localhost/python/steuerungTablet.php\n";
	logToFile("cronjob: $file");
    $tmp       = tempnam( '/tmp', 'pooltimer' );
    $tmpHandle = fopen( $tmp, "w" );
    fwrite( $tmpHandle, $file );
    fclose( $tmpHandle );

    exec( "/usr/bin/crontab $tmp" );

    unlink( $tmp );
}
   
function logToFile($msg){ 
	// open file
	$filename = "../logs/pool.log";
	$fd = fopen($filename, "a");
	$str = "[" . date("Y/m/d H:i:s", mktime()) . "] " . $msg; 
	// write string
	fwrite($fd, $str . "\n");
	// close file
	fclose($fd);
}

function rotateLog(){
	$oldname = "../logs/pool.log";
	
		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		//$timestamp = mktime(23, 59, 59, $monat, $tag -1, $jahr);
		
	$newname = "../logs/" . date("Y-m-d", mktime(23, 59, 59, $monat, $tag -1, $jahr)) . ".pool.log"; 
	//echo $newname
	$rename = rename($oldname,$newname);
	if($rename){
		echo "OK!";
	}else{
		echo "Fehler";
	}
}

function calculate_strom(){

		$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
					
		$timestamp_gestern = mktime(23, 59, 59, $monat, $tag -1, $jahr);
    
		$sql = query( "SELECT gpio, zeitEin, zeitHeute FROM aktor" );
		while( $row = fetch( $sql ) )
		{
			$deltaZeit = 0;
			$zeitHeute = 0;
			$verbrauch = VerbrauchHeute($row['gpio']);
			// Wenn der Aktor ein ist 
			// zeitEin auf jetzt (Mitternacht) setzen damit die Stromverbrauchberechnug (für den nächsten Tag) stimmt			
			if( $row['zeitEin'] > 0 )
			{
				// $deltaZeit = Zeit die der Aktor bis jetz (Mitternacht) ein war
				$deltaZeit = time() - $row['zeitEin'];
				
				$sql2 = query("UPDATE aktor SET zeitEIN = '" . time() . "' WHERE gpio = '" . $row['gpio'] . "'");
			}

			// zeitHeute brechnen
			//$zeitHeute = $deltaZeit + $row['zeitHeute'];
				
			
			//$verbrauchAktoren = $verbrauchAktoren + $verbrauch['kwh'];
		
			$sql3 = query("INSERT INTO logverbrauch VALUES( '', '" . $row['gpio'] . "', '" . $verbrauch['kwh'] . "', '" . $verbrauch['zeit'] . "', '" . $timestamp_gestern . "')");
		}
		
		

		
		// Bei allen Aktoren die heutige Zeit auf 0 setzen
		$sql = query("UPDATE aktor SET zeitHeute = '0'");
		



}

function drawChart2($timestamp){

	$data[0] = array('test','Pool','Solar','Raspberry');	
	//var_dump($row);

	$i=1;
	$pool=array();
	$solar=array();
	$raspberry=array();
	$sql = "SELECT * FROM logtemp WHERE name = 'Pool' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$pool[] = $row['value'];
	}
	$sql = "SELECT * FROM logtemp WHERE name = 'Solar' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$solar[] = $row['value'];
	}	
	$sql = "SELECT * FROM logtemp WHERE name = 'Raspberry' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$raspberry[] = $row['value'];
	}
	//print_r($pool);
	
	
	for($i=0;$i<24;$i++){
		if($pool[$i] /100 * 100 == 0){
			$pool_value = 'null';
		}else{
			$pool_value = $pool[$i] /100 * 100;
		} 
		if($solar[$i] /100 * 100 == 0){
			$solar_value = 'null';
		}else{
			$solar_value = $solar[$i] /100 * 100;
		}
		if($raspberry[$i] /100 * 100 == 0){
			$raspberry_value = 'null';
		}else{
			$raspberry_value = $raspberry[$i] /100 * 100;
		}
		if($i < 10){
			$zeit = "0" . $i. ":00";
		}else{
			$zeit = $i . ":00";
		}
		$data[$i+1] = array($zeit,  $pool_value, $solar_value, $raspberry_value);
		//echo $pool[$i] /100 * 100;
	}

	return json_encode($data);
}


function drawChart_week($timestamp){

	$data[0] = array('test','Pool','Solar', 'Rücklauf','Raspberry');	
	//var_dump($row);

	$i=1;
	$pool=array();
	$solar=array();
	$ruecklauf=array();
	$raspberry=array();
	$sql = "SELECT * FROM logtemp WHERE name = 'Pool' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$pool[] = $row['value'];
	}
	$sql = "SELECT * FROM logtemp WHERE name = 'Solar' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$solar[] = $row['value'];
	}	
	$sql = "SELECT * FROM logtemp WHERE name = 'Ruecklauf' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$ruecklauf[] = $row['value'];
	}	
	$sql = "SELECT * FROM logtemp WHERE name = 'Raspberry' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$raspberry[] = "$row[value],$row[time]";
		//$raspberry[] = $row['time'];
	}
	//print_r($raspberry);
	
	
	for($i=0;$i<count($raspberry);$i++){
		if($pool[$i] /100 * 100 == 0){
			$pool_value = 'null';
		}else{
			$pool_value = $pool[$i] /100 * 100;
		} 
		if($solar[$i] /100 * 100 == 0){
			$solar_value = 'null';
		}else{
			$solar_value = $solar[$i] /100 * 100;
		}
		if($ruecklauf[$i] /100 * 100 == 0){
			$ruecklauf_value = 'null';
		}else{
			$ruecklauf_value = $ruecklauf[$i] /100 * 100;
		}
		
		list ($raspberry_value, $raspberry_time) = split(',', $raspberry[$i]);
		if($raspberry_value /100 * 100 == 0){
			$raspberry_value = 'null';
		}else{
			$raspberry_value = $raspberry_value /100 * 100;
		}
		if(($i == 12) || (($i + 12) % 24 === 0)){
			$raspberry_time = date('L chr(13) d.m', $raspberry_time);
		}else{
			$raspberry_time = "";
		}
		
		$data[$i+1] = array($raspberry_time,  $pool_value, $solar_value, $ruecklauf_value, $raspberry_value);
		//echo $pool[$i] /100 * 100;
	}

	return json_encode($data);
}

function drawChart_day($timestamp){

	$data[0] = array('test','Pool','Solar','Ruecklauf','Raspberry');	
	//var_dump($row);

	$i=1;
	$pool=array();
	$solar=array();
	$ruecklauf=array();
	$raspberry=array();
	$sql = "SELECT * FROM logtemp WHERE name = 'Pool' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$pool[] = $row['value'];
	}
	$sql = "SELECT * FROM logtemp WHERE name = 'Solar' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$solar[] = $row['value'];
	}
	
	$sql = "SELECT * FROM logtemp WHERE name = 'Raspberry' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$raspberry[] = "$row[value],$row[time]";
		//$raspberry[] = $row['time'];
	}
	
	$sql = "SELECT * FROM logtemp WHERE name = 'Ruecklauf' AND time >= '" . $timestamp . "'  " ;
	$result = query($sql);
	//$row = fetch($result);
	while ($row = fetch($result)) {
		$ruecklauf[] = $row['value'];
	}	
	

	//print_r($raspberry);
	
	
	for($i=0;$i<count($raspberry);$i++){
		if($pool[$i] /100 * 100 == 0){
			$pool_value = 'null';
		}else{
			$pool_value = $pool[$i] /100 * 100;
		} 
		if($solar[$i] /100 * 100 == 0){
			$solar_value = 'null';
		}else{
			$solar_value = $solar[$i] /100 * 100;
		}
		if($ruecklauf[$i] /100 * 100 == 0){
			$ruecklauf_value = 'null';
		}else{
			$ruecklauf_value = $ruecklauf[$i] /100 * 100;
		}
		
		list ($raspberry_value, $raspberry_time) = split(',', $raspberry[$i]);
		if($raspberry_value /100 * 100 == 0){
			$raspberry_value = 'null';
		}else{
			$raspberry_value = $raspberry_value /100 * 100;
		}
		$data[$i+1] = array(date('H:i', $raspberry_time),  $pool_value, $solar_value, $ruecklauf_value, $raspberry_value);
		//echo $pool[$i] /100 * 100;
	}

	return json_encode($data);
}
?>
