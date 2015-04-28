<?php
	$loc = 'home';
	if(isset($_GET['l'])) $loc = $_GET['l'];
	$file = fopen("settings-" . $loc . ".ini","r") or die();
	$settings = array();
	$i = 0;
	while(!feof($file)) {
		$settings[$i] = trim(fgets($file));
		$i++;
	}
	fclose($file);
	$i--;

	/* $p = array();
	
	$p[0] = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=' . $settings[0]), true);
	
	for($j = 1; $j < $i; $j++) {
		$p[$j] = json_decode(file_get_contents('http://www.cumtd.com/maps-and-schedules/bus-stops/RealTimeJson?id=' . substr($settings[$j],0,strpos($settings[$j],":")) . '&pt=30'), true);
	} */
	
	$compass = array("N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
?>

<!DOCTYPE html>
<html>
<head>
<?php echo "<!-- " . $i . " -->"; ?>
<meta charset="UTF-8">
<title>Transit Time Tracker!</title>
<script src="jquery-2.0.3.min.js"></script>
<script>
$(function() {

	$.ajaxSetup({timeout:10000});

	function DisplayTime(){
		if (!document.all && !document.getElementById)
			return;
		var CurrentDate=new Date();
		var hours=CurrentDate.getHours();
		var minutes=CurrentDate.getMinutes();
		var seconds=CurrentDate.getSeconds();
		var DayNight="PM";
		if (hours<12) DayNight="AM";
		if (hours>12) hours=hours-12;
		if (hours==0) hours=12;
		if (minutes<=9) minutes="0"+minutes;
		if (seconds<=9) seconds="0"+seconds;
		var currentTime=hours+":"+minutes+":"+seconds+" "+DayNight;
		$('#curTime').html("" + currentTime);
		setTimeout(DisplayTime,1000);
	}

	function UpdateStops() {
		var stops = new Array(<?php
		
		for($z = 1; $z < $i; $z++) {
			echo "'" . substr($settings[$z],0,strpos($settings[$z],":"));
			if($z == $i - 1) echo "'";
			else echo "',";
		}
		?>);
		var stopName = new Array(<?php
		
		for($z = 1; $z < $i; $z++) {
			echo "'" . substr($settings[$z],strpos($settings[$z],":")+1);
			if($z == $i - 1) echo "'";
			else echo "',";
		}
		?>);
		for(var i = 0; i < stops.length; i++) {
			$.get('stop.php', {'stop' : stops[i], 'stopName' : stopName[i], 'i' : i}, function(data) {
				//console.log('#t' + (parseInt(data.substring(0,1)) + 2));
				$('#t' + (parseInt(data.substring(0,1)) + 2)).html(data.substring(1));
			});
		}
	}

	function UpdateWeather() {
		$.get('weather.php', {'location' : '<?php echo $settings[0]; ?>'}, function(data) {
			$('#t1').html(data);
		});
	}
	
	setInterval(UpdateStops, 30000);
	setInterval(UpdateWeather, 10*60000);

	UpdateStops();
	UpdateWeather();
	DisplayTime();
});
</script>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
<table style="height: 100%; width: 100%; position: absolute; top: 0; bottom: 0; left: 0; right: 0;">
<tr>
<td class="b" id="t1" style="width: <?php echo round(100/$i,3); ?>%;">
</td>
<?php
	for($k = 1; $k < $i; $k++) {
?>	
<td class="<?php echo ($k % 2) == 1 ? 'a': 'b'; ?>" id="t<?php echo ($k + 1) . ''; ?>" style="width: <?php echo round(100/$i,3); ?>%;">
</td>
<?php
	}
?>
</tr>
</table>
</body>
</html>
