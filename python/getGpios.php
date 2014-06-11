<?php
include("funktionen.php");
$update = $_GET[update];
$iphone = $_GET[iphone];

//var_dump($iphone);

$sql = query( "SELECT * FROM aktor");

while( $gpio = fetch( $sql ) ){
if(!isset($update)){
?>

<script type="text/javascript">
$("#gpio-<? echo $gpio[gpio]; ?>").on("slidestop", function( event, ui ) { 
	var value = $(this).val();
	$.get('python/setGpioStatus.php?pin=<? echo $gpio[name]; ?>&value=' + value, function() {
	}); 
});

</script>
<?php
	if($iphone == "false"){
		//echo "in if";
		echo "<div style=\"float: left; border-radius:10px;  width:32%; margin-left:10px; margin-bottom:12px\">";
	}
?>
	<ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
    	<li data-role="list-divider">GPIO <? echo $gpio[gpio] . " " . $gpio[name]; ?></li>
    	<!--<li>Status
    	</li> -->    	
    	<li>An / Aus
			<div style="position: absolute ;right:10px;top:0">
			<select name="gpio-<? echo $gpio[gpio]; ?>" id="gpio-<? echo $gpio[gpio]; ?>" data-role="slider" data-mini="true">
				<option value="0">Aus</option>
				<option value="1">An</option>
			</select>
			</div>
    	</li>
	</ul>
<?php
	if($iphone == "false"){
		echo "</div>";
	}	




}else{
	$gpios = $gpios . $gpio[gpio] . "," . getGpio($gpio[gpio]) . ";";
	
	/*for($z=0; $z < count($gpios); $z++){
		list($name, $pin) = explode(",", $gpios[$z]);
   		echo $pin . "," getGpio($pin);
	}
*/
}


}

if(isset($update)){
	$gpios = substr($gpios, 0, -1); 
	echo $gpios;
}

?>

