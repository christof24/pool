<?php
include("funktionen.php");
    
    $tag = date("d");
	$monat = date("m");
	$jahr = date("Y");
	$stunde = date("H");
	
					
	$timestamp_heute = mktime($stunde, 0, 0, $monat, $tag-1, $jahr);
	$timestamp_woche = mktime(23, 59, 59, $monat, $tag-7, $jahr);
	

if($_GET['func'] == "heute"){
	$data = drawChart_day($timestamp_heute);
	echo $data;
}
if($_GET['func'] == "woche"){
	$data = drawChart_week($timestamp_woche);
	echo $data;
}
?>
