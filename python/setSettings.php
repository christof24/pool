<?php 

include("./funktionen.php");


$sql = query("UPDATE einstellungen SET maxWasser =  '" . $_GET['maxWasser'] . "' , diffTemp =  '" . $_GET['diffTemp'] . "' , minSolar =  '" . $_GET['minSolar'] . "' , startPumpe =  '" . getTime($_GET['minZeit']) . "' , stopPumpe =  '" . getTime($_GET['maxZeit']) .  "' , startPumpe1 =  '" . getTime($_GET['minZeit1']) . "' , stopPumpe1 =  '" . getTime($_GET['maxZeit1']) .  "', startTablet =  '" . getTime($_GET['minZeitTablet']) . "' , stopTablet =  '" . getTime($_GET['maxZeitTablet']) .  "' , tabletWochentag =  '" . $_GET['tabletLadezeit'] .  "' ");

$status = '';

$sql = query( "SELECT * FROM einstellungen");
$row = fetch($sql);

if(($row[maxWasser] == $_GET['maxWasser']) && ($row[diffTemp] == $_GET['diffTemp']) && ($row[minSolar] == $_GET['minSolar']) && ($row[startPumpe] == getTime($_GET['minZeit'])) && ($row[stopPumpe] ==  getTime($_GET['maxZeit'])) && ($row[startTablet] == getTime($_GET['minZeitTablet'])) && ($row[stopTablet] == getTime($_GET['maxZeitTablet']))  && ($row[tabletWochentag] == $_GET['tabletLadezeit']) ){
	$status = 1;
}else{
	$status = 0;
}

writeCrontab(getHour($_GET['minZeit']),getHour($_GET['maxZeit']),getHour($_GET['minZeit1']),getHour($_GET['maxZeit1']), getHour($_GET['minZeitTablet']) ,getHour($_GET['maxZeitTablet'])  , str_replace(";",",",$_GET['tabletLadezeit']) );

echo $status;

function getHour($min){
	$hour = floor($min / 60);
return $hour;
}




function getTime($min){

	$hours = floor($min / 60);
    $minutes = $min - ($hours * 60);
 
    if(strlen($hours) == 1){
    	$hours = "0" . $hours;
    }
    if(strlen($minutes) == 1) {
    	$minutes = "0" . $minutes;
	}
	$time = $hours . ":" . $minutes . ":00";
	
return $time;
}
?>