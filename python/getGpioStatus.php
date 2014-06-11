<?php //getGpioStatus.php?pin=Pool 
include("funktionen.php");
	if($_GET['pin']){
		$pin = $_GET['pin'];
		$pins = explode( ",",$pin);
		$count = 0;
		
		foreach ($pins as $value) {
			//var_dump($value);
			$sql = query("select gpio from aktor WHERE name = '" . $value . "'" );
			$row = fetch($sql);
    		exec("sudo cat /sys/class/gpio/gpio" . $row[gpio] . "/value", $output);
    		if($count == 0){
    			$out = $out . $output[0];
    		}else{
    			$out = $out . "," . $output[0];
    		}
    		$output = false;
    		$count++;
		}

		
		
		echo $out;
	}
?>

