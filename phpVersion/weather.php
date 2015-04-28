<?php
	$p = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=' . $_GET['location']), true);
	$compass = array("N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
	$compdir = $compass[round($p["wind"]["deg"] / 22.5)];
?>
<div class="h2wrapper"><h2><?php echo $p["name"] . ', ' . substr($p["sys"]["country"], 0, strpos($p["sys"]["country"], "of America")); ?></h2></div>
<img src="http://openweathermap.org/img/w/<?php echo $p["weather"][0]["icon"]; ?>.png" style="padding: 10px; padding-top: 0px; position: relative; float: left;" />
<h2 style="font-size: 60px;"><?php echo '' . round(32 + 1.8*($p["main"]["temp"] - 273),1); ?>&deg;F</h2>
<p><?php echo $p["weather"][0]["main"] . ' - ' . $p["weather"][0]["description"]; ?></p><br />
<h2><span style="color: #b00; font-size: 40px;"><?php echo '' . round(32 + 1.8*($p["main"]["temp_max"] - 273),1); ?>&deg;F</span> / 
<span style="color: #00b; font-size: 40px;"><?php echo '' . round(32 + 1.8*($p["main"]["temp_min"] - 273),1); ?>&deg;F</span></h2><br />
<p><?php echo round(2.23694*$p["wind"]["speed"],2) . ' mph ' . $compdir; ?></p>
<p><?php echo $p["main"]["humidity"] . '% Humidity'; ?></p>
<br /><br />
<div id="curTime" style="font-size: 40px; font-weight: bold; text-align: center;">
</div>
