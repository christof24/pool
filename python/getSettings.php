<?php

include("funktionen.php");


$sql = query( "SELECT * FROM einstellungen");
$row = fetch($sql);
//var_dump($row);

$return = $row[maxWasser] . "," . $row[diffTemp] . "," . $row[minSolar] . "," . $row[startPumpe] . "," . $row[stopPumpe] . "," . $row[startPumpe1] . "," . $row[stopPumpe1]. "," . $row[startTablet] . "," . $row[stopTablet] . "," . $row[tabletWochentag]; 

echo $return;

?>