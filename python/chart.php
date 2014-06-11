<?php
include("funktionen.php");
function drawChart1($timestamp){

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
		
		list ($raspberry_value, $raspberry_time) = split(',', $raspberry[$i]);
		if($raspberry_value /100 * 100 == 0){
			$raspberry_value = 'null';
		}else{
			$raspberry_value = $raspberry_value /100 * 100;
		}
		$data[$i+1] = array(date('d-m H:i', $raspberry_time),  $pool_value, $solar_value, $raspberry_value);
		//echo $pool[$i] /100 * 100;
	}

	return json_encode($data);
}

    $tag = date("d");
	$monat = date("m");
	$jahr = date("Y");
					
	$timestamp = mktime(23, 59, 59, $monat, $tag-7, $jahr);

	$data = drawChart1($timestamp);
	//echo date('H:i', $timestamp);	
   echo $data;
   
?>
