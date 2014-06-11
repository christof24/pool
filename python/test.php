
<?php
include("funktionen.php");
//writeCrontab(15,20);
//readCrontab();

	//echo getSensorTemp_neu("28-00000472367d") . "<br>";
//$test = verbrauchWoche("17");
echo date('H-i - d-m-Y',strtotime("midnight first day of last month")) . "<br>";
echo date('H-i - d-m-Y',strtotime("last monday")) . "<br>";

$letztermonat = mktime(0, 0, 0, date("m") , date("d"),   date("Y"));
echo date('H-i - d-m-Y', mktime(0, 0, 0, date("m")-1 , 1,   date("Y"))) . "<br>";
echo date("d");


//rotateLog();
function readCrontab() {
    //global $devices;

    exec( "/usr/bin/crontab -l", $out, $status );
    # ignore status; it returns 1 if no crontab has been set yet
	$i = 0;
    $ret = array();
    foreach( $out as $line ) {
    $ret[$i] = $line . "<br>";
    $i++;
//         if( preg_match( '!^(\d+) (\d+) .*/cron-run\.php (\d+) ([01])$!', $line, $matches )) {
//             foreach( $devices as $deviceName => $devicePin ) {
//                 if( $devicePin != $matches[3] ) {
//                     continue;
//                 }
//                 if( $matches[4] == 1 ) {
//                     $ret[$deviceName]['timeOn']['hour'] = $matches[2];
//                     $ret[$deviceName]['timeOn']['min']  = $matches[1];
//                 } else {
//                     # we write the on's before the off's, so it's here
//                     $ret[$deviceName]['duration']['hour'] = $matches[2] - $ret[$deviceName]['timeOn']['hour'];
//                     $ret[$deviceName]['duration']['min']  = $matches[1] - $ret[$deviceName]['timeOn']['min'];
//                     while( $ret[$deviceName]['duration']['min'] < 0 ) {
//                         $ret[$deviceName]['duration']['min'] += 60;
//                         $ret[$deviceName]['duration']['hour']--;
//                     }
//                 }
//             }
//         }
    }
    var_dump($ret);
    return $ret;
}

function writeCrontab($start,$stop) {

    $file = <<<END
# Dieser Crontab wurde automatisch mit der Pool Steuerung erstellt.
# Hier Keine Einträge machen, da diese automatisch mit einem Skript überschrieben werden.
# CD 2013

END;


            $file .= "*/5 $start-$stop * * * wget -q -O /dev/null localhost/python/steuerung.php\n";
            
       
    $tmp       = tempnam( '/tmp', 'pooltimer' );
    $tmpHandle = fopen( $tmp, "w" );
    fwrite( $tmpHandle, $file );
    fclose( $tmpHandle );

    exec( "/usr/bin/crontab $tmp" );

    unlink( $tmp );
}

?>