<?
include("funktionen.php");

if($_GET['prog']){
	$prog = $_GET['prog'];
	$programm = explode( ",",$prog);
	$count = 0;
	foreach($programm as $name){
		$sql = query( "SELECT programm FROM aktor WHERE name = '" . $name . "'");
		$row = fetch($sql);
		//var_dump($row);
		//echo $row[programm];
		if($count == 0){
			$out = $out . $row[programm];
		}else{
			$out = $out . "," . $row[programm];
		}
		$count++;
	}
	echo $out;
}

?>
