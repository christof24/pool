<?php
include 'YahooWeather.class.php';

// create an instance of the class with L.A.'s WOEID
$weather = new YahooWeather(682994, 'c');
$temperature = $weather->getTemperature();
$city = $weather->getLocationCity();
$country = $weather->getLocationCountry();
//$weather->getForecastHigh(4);
//echo "It is now $temperature in $city, $country. ";
$condition =  $weather->getForecastConditionCode(0);

//echo "<img src=\"../icons/wetter/" . $condition . ".png\" height=\"70\">";

$count = count($weather->weather_forecast);
//echo $count; 


$var = <<<HTML
<div class="wetterAppletHeute">
	<div class="wetterTag">
		Heute
		<hr/>
	</div>
	<div class="wetterIcon">
		<img src="../icons/wetter/{$weather->getForecastConditionCode(0)}.png" height="70">
	</div>
	<div class="wetterGradHeute">
		{$weather->getTemperature()}
	</div>
	<div class="wetterTextHeute">
		{$weather->getDescription()} 
	</div>
	<div style=""></div>
	<div class="wetterHighHeute">
		Max. Temperatur:  {$weather->getForecastHigh(0)}
	</div>
	<div class="wetterLowHeute">
		Min. Temperatur: {$weather->getForecastLow(0)}
	</div>
	<!-- <img class="blades" src="../icons/wetter/blades.png" width="70" />
    <img class="stand" src="../icons/wetter/stand.png" width="6" height="80"/> -->
</div>

HTML;




for($i=1;$i<count($weather->weather_forecast);$i++){

$var .= <<<HTML

<div class="wetterApplet">
	<div class="wetterTag">
		{$weather->getForecastDay($i)}
		<hr/>
	</div>
	<div class="wetterIcon">
		<img src="../icons/wetter/{$weather->getForecastConditionCode($i)}.png" height="70">
	</div>
	<div class="wetterText">
		{$weather->getForecastDescription($i)}
	</div>
	<div class="wetterHigh">
		Max. Temp: {$weather->getForecastHigh($i)}
	</div>
	<div class="wetterLow">
		Min. Temp: {$weather->getForecastLow($i)}
	</div>
</div>

HTML;

}

echo $var;
?>