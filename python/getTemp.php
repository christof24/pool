<?php
include("funktionen.php");

$sensor = $_GET["sensor"];
$action = $_GET[action];
//echo "tets";
$sensors = explode( ",",$sensor);
$count = 0;
$count1 = 0;

if($action == "file"){
 	foreach ($sensors as $value) {
 		if($count == 0){
 			$output = $output . getSensorTemp($value);
     	}else{
     		$output = $output . "," . getSensorTemp($value);
     	}
     	$count++;
 	}
	echo $output;
}

if($action == "database"){
// 	echo "database";
 	
 	$output= "";
	foreach ($sensors as $sensor) {
		$sql = query( "SELECT value FROM logtemp WHERE iid = '" . $sensor . "' ORDER BY id DESC LIMIT 1");
		$row = fetch($sql);
		//var_dump($row);
		//echo $row["value"] . "<br>";
//  		$output = $output . "," . $row['value'];
	
	if($count == 0){
		$output = $output . sprintf("%1\$.2f",$row['value']);
    }else{
    	$output = $output . "," . sprintf("%1\$.2f",$row['value']);
    }
    $count++;
    }
 	echo $output;
}
//echo "nichts";
?>

