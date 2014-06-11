<?php
include("funktionen.php");

$sql = query( "SELECT * FROM temptrend");
$row = fetch($sql);

echo $row['Pool'] . "," . $row['Solar'] . "," . $row['Ruecklauf'] . "," . $row['Raspberry'];
?>