<?
include("funktionen.php");

$aktion = $_GET['aktion'];

//Sicheres Herunterfahren
function stopGpio(){
	setGpio("17","0");
	setGpio("22","0");
	setGpio("23","0");
	setGpio("25","0");
	setGpio("27","0");
}

if($aktion == "reboot"){
	logToFile("############ Start Reboot ###########");
	stopGpio();
	$reboot=exec("sudo /sbin/shutdown -r now", $output, $error); 
	echo "The system is going down for system reboot NOW!";
}

if($aktion == "shutdown"){
	logToFile("############ Start Shutdwon ###########");
	stopGpio();
	$shutdown=exec("sudo /sbin/shutdown -h now", $output, $error); 
	echo "The system is going down for system halt NOW!";
}

?>