<?php
include("funktionen.php");
setlocale(LC_ALL,'de_DE@euro', 'de_DE',  'de', 'ge');
setlocale(LC_ALL, "de_DE.utf8");
date_default_timezone_set('Europe/Berlin');
setlocale(LC_TIME, "de_DE");
$gpios = array(Pool, Solar, Licht); 
$tag = date("d");
		$monat = date("m");
		$jahr = date("Y");
		
		
		foreach ($gpios as $gpio) {
		//echo $gpio;
		$sql = query("select gpio from aktor WHERE name = '" . $gpio . "'" );
		$row = fetch($sql);
		$verbrauchHeute[$row[gpio]] = VerbrauchHeute($row[gpio]);
		$verbrauchGestern[$row[gpio]] = VerbrauchGestern($row[gpio]);
		$verbrauchWoche[$row[gpio]] = VerbrauchWoche($row[gpio]);
		$verbrauchVorMonat[$row[gpio]] = VerbrauchVorMonat($row[gpio]);
		$verbrauchMonat[$row[gpio]] = VerbrauchMonat($row[gpio]);
		$verbrauchJahr[$row[gpio]] = VerbrauchJahr($row[gpio]);
		$verbrauchVorJahr[$row[gpio]] = VerbrauchVorJahr($row[gpio]);
		//echo $row[gpio];
//var_dump($verbrauchHeute[23]);
	}
?>

	
        <style>
        
#stats  tr th{
    color: #666;
    //border: 1px solid #666;
    border-right: 1px solid #b4b4b4;
     padding: 3px 5px 3px 5px;
    //background-image: -webkit-linear-gradient(top, #fdfdfd, #eee);
}
#stats  tr td{
    color: #666;
    //border: 1px solid #666;
    border-right: 1px solid #b4b4b4;
	 padding: 3px 5px 3px 5px;
    //background-image: -webkit-linear-gradient(top, #fdfdfd, #eee);
}

#stats tr td:last-child {
    border-right: none;
}
#stats tr th:last-child {
    border-right: none;
}
table tr:last-child td {
    border-bottom: none;
}

/* 
test tbody tr td {
    color: #666;
    border-bottom: 1px solid #b4b4b4;
    border-right: 1px solid #b4b4b4;
    padding: 10px 10px 10px 10px;
    background-image: -webkit-linear-gradient(top, #fdfdfd, #eee);
}
#stats tbody th {
    color: #666;
    border 1px solid #b4b4b4;
    border-right: 1px solid #b4b4b4;
    border-left: 1px solid #b4b4b4;
    //padding: 10px 10px 10px 10px;
    //background-image: -webkit-linear-gradient(top, #fdfdfd, #eee);
}
 */
        </style>
 
<table data-role="table" id="stats"  class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="c" >
    <thead>
      <tr class="ui-bar-c">
        <th></th>
        <th colspan="3"><center>Pumpe</center></th>
        <th>Solar</th>
        <th colspan="3"><center>Licht</center></th>
      </tr>
      <tr class="ui-bar-c">
        <th>Zeitraum</th>
        <th>Laufzeit</th>
        <th>Strom</th>
        <th>Kosten</th>
        <th>Laufzeit</th>
        <th>Laufzeit</th>
        <th>Strom</th>
        <th>Kosten</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>Heute</th>
        <td><?php echo secToTime($verbrauchHeute[17]['zeit']); ?></td>
        <td><?php echo $verbrauchHeute[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchHeute[17]['euro'] . " €"; ?></td>
        <td><?php echo secToTime($verbrauchHeute[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchHeute[22]['zeit']); ?></td>
        <td><?php echo $verbrauchHeute[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchHeute[22]['euro'] . " €"; ?></td>
    
      </tr>
      <tr>
        <th>Gestern</th>
        <td><?php echo secToTime($verbrauchGestern[17]['zeit']); ?></td>
        <td><?php echo $verbrauchGestern[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchGestern[17]['euro'] . " €"; ?></td>
         <td><?php echo secToTime($verbrauchGestern[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchGestern[22]['zeit']); ?></td>
        <td><?php echo $verbrauchGestern[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchGestern[22]['euro'] . " €"; ?></td>
       
      </tr>
      <tr>
        <th>Woche</th>
        <td><?php echo secToTime($verbrauchWoche[17]['zeit']); ?></td>
        <td><?php echo $verbrauchWoche[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchWoche[17]['euro'] . " €"; ?></td>
        <td><?php echo secToTime($verbrauchWoche[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchWoche[22]['zeit']); ?></td>
        <td><?php echo $verbrauchWoche[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchWoche[22]['euro'] . " €"; ?></td>
      
      </tr>
      <tr>
        <th>Aktueller Monat</th>
        <td><?php echo secToTime($verbrauchMonat[17]['zeit']); ?></td>
        <td><?php echo $verbrauchMonat[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchMonat[17]['euro'] . " €"; ?></td>
        <td><?php echo secToTime($verbrauchMonat[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchMonat[22]['zeit']); ?></td>
        <td><?php echo $verbrauchMonat[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchMonat[22]['euro'] . " €"; ?></td>
        
      </tr>
      <tr>
        <th>Aktuelles Jahr</th>
        <td><?php echo secToTime($verbrauchJahr[17]['zeit']); ?></td>
        <td><?php echo $verbrauchJahr[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchJahr[17]['euro'] . " €"; ?></td>
         <td><?php echo secToTime($verbrauchJahr[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchJahr[22]['zeit']); ?></td>
        <td><?php echo $verbrauchJahr[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchJahr[22]['euro'] . " €"; ?></td>
        
      </tr>
    <tr>
    	<th>Monat <?  echo strftime('%B', mktime(0, 0, 0, date("m")-1 , 1,   date("Y"))); ?></th>
        <td><?php echo secToTime($verbrauchVorMonat[17]['zeit']); ?></td>
        <td><?php echo $verbrauchVorMonat[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchVorMonat[17]['euro'] . " €"; ?></td>
        <td><?php echo secToTime($verbrauchVorMonat[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchVorMonat[22]['zeit']); ?></td>
        <td><?php echo $verbrauchVorMonat[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchVorMonat[22]['euro'] . " €"; ?></td>
        
      </tr>
      <tr>
        <th>Jahr 2012</th>
        <td><?php echo secToTime($verbrauchVorJahr[17]['zeit']); ?></td>
        <td><?php echo $verbrauchVorJahr[17]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchVorJahr[17]['euro'] . " €"; ?></td>
         <td><?php echo secToTime($verbrauchVorJahr[24]['zeit']); ?></td>
        <td><?php echo secToTime($verbrauchVorJahr[22]['zeit']); ?></td>
        <td><?php echo $verbrauchVorJahr[22]['kwh'] . " KW/h"; ?></td>
        <td><?php echo $verbrauchVorJahr[22]['euro'] . " €"; ?></td>
     
      </tr>

    </tbody>
  </table>


