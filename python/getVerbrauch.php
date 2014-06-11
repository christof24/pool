<?php
include("funktionen.php");

if($_GET['pin']){

	$pin = $_GET['pin'];
	$gpios = explode( ",",$pin);
	if($_GET['aktion'] == "dashboard"){
	foreach ($gpios as $gpio) {
		$sql = query("select gpio from aktor WHERE name = '" . $gpio . "'" );
		$row = fetch($sql);
		$verbrauchHeute[$row[gpio]] = VerbrauchHeute($row[gpio]);
		$verbrauchGestern[$row[gpio]] = VerbrauchGestern($row[gpio]);
		$verbrauchMonat[$row[gpio]] = VerbrauchMonat($row[gpio]);
		echo $row[gpio] . "||" . 
		secToTime($verbrauchHeute[$row[gpio]]['zeit']) . ";" . 
		$verbrauchHeute[$row[gpio]]['kwh']. ";" . 
		$verbrauchHeute[$row[gpio]]['euro'] . "||" .
		secToTime($verbrauchGestern[$row[gpio]]['zeit']) . ";" . 
		$verbrauchGestern[$row[gpio]]['kwh']. ";" . 
		$verbrauchGestern[$row[gpio]]['euro'] . "||" .
		secToTimeMonat($verbrauchMonat[$row[gpio]]['zeit']) . ";" . 
		$verbrauchMonat[$row[gpio]]['kwh']. ";" . 
		$verbrauchMonat[$row[gpio]]['euro'] . "</br>" ;
	}
	}
	
	
	
	if($_GET['aktion'] == "statistik"){
		foreach ($gpios as $gpio) {
		$sql = query("select gpio from aktor WHERE name = '" . $gpio . "'" );
		$row = fetch($sql);
		$verbrauchHeute[$row[gpio]] = VerbrauchHeute($row[gpio]);
		$verbrauchGestern[$row[gpio]] = VerbrauchGestern($row[gpio]);
		$verbrauchWoche[$row[gpio]] = VerbrauchWoche($row[gpio]);
		$verbrauchMonat[$row[gpio]] = VerbrauchMonat($row[gpio]);
		$verbrauchJahr[$row[gpio]] = VerbrauchJahr($row[gpio]);
		echo $row[gpio] . "||" . 
		secToTime($verbrauchHeute[$row[gpio]]['zeit']) . ";" . 
		$verbrauchHeute[$row[gpio]]['kwh']. ";" . 
		$verbrauchHeute[$row[gpio]]['euro'] . "||" .
		secToTime($verbrauchGestern[$row[gpio]]['zeit']) . ";" . 
		$verbrauchGestern[$row[gpio]]['kwh']. ";" . 
		$verbrauchGestern[$row[gpio]]['euro'] . "||" .
		secToTime($verbrauchWoche[$row[gpio]]['zeit']) . ";" . 
		$verbrauchWoche[$row[gpio]]['kwh']. ";" . 
		$verbrauchWoche[$row[gpio]]['euro'] . "||" .
		secToTime($verbrauchMonat[$row[gpio]]['zeit']) . ";" . 
		$verbrauchMonat[$row[gpio]]['kwh']. ";" . 
		$verbrauchMonat[$row[gpio]]['euro'] . "||" .
		secToTime($verbrauchJahr[$row[gpio]]['zeit']) . ";" . 
		$verbrauchJahr[$row[gpio]]['kwh']. ";" . 
		$verbrauchJahr[$row[gpio]]['euro'] . "</br>" ;
	}
	}
	//echo "23;" . secToTime($verbrauchHeute['23']['zeit']) . ";" . $verbrauchHeute['23']['kwh']. ";" . $verbrauchHeute['23']['euro'] . "</br>";
	//echo "24;" . secToTime($verbrauchHeute['24']['zeit']) . ";" . $verbrauchHeute['24']['kwh']. ";" . $verbrauchHeute['24']['euro'] . "</br>";
	//echo "25;" . secToTime($verbrauchHeute['25']['zeit']) . ";" . $verbrauchHeute['25']['kwh']. ";" . $verbrauchHeute['25']['euro'] . "</br>";
}

?>

