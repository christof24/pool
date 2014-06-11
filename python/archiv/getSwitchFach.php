<?php
include('../config.inc.php');

$key = $_GET['cat'];
//print_r($_GET['cat']);
$return = '';
//echo "<select name=\"switchfach\" />";

$sql = "SELECT fach FROM consolenserver WHERE switchtyp = '$key'";			
$result=mysql_query($sql)  or print mysql_error() ;
				
while ($row1=mysql_fetch_array($result)){
  //echo "<option>$row1[fach]</option>";
  $return .= '<option value="' . $row1[fach] . '">' . $row1[fach] . '</option>';
}
			
//echo "</select>";


echo "<select name=\"switchfach1_manuell\" id=\"switchfach1_manuell\"> $return </select>";
//echo "test";
?>