<div class="datum">
	<li class="hours">00</li>
	<li class="point">:</li>
	<li class="min">00</li>
	<li class="point">:</li>
	<li class="sec">00</li>
</div>
<?php
$Wochentage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
$Monate     = array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
 
echo$Wochentage[date("w")],
date(", j. "),
$Monate[date("n")-1],
date(" Y");
?>
