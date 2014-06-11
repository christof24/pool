
<?
include("funktionen.php");

if($_GET['pin'] && isset($_GET['value'])){
	//Schalten GPIO
	$desc = $_GET['pin'];
	$value = $_GET['value'];
	$sql = query( "select gpio from aktor WHERE name = '" . $desc . "'" );
	$row = fetch($sql);

	setGpio($row[gpio],$value);
	$sql = query( "UPDATE aktor SET programm = '" . $value . "' WHERE gpio = '" . $row[gpio] . "'" );
	echo "gpio: $row[gpio] value: $value";
	if($value == "3"){
	//sleep(1);
		logToFile("Automatik: Schalte Steuerung auf Automatik");
		include("steuerung.php");
		
	}

	
}
?>

