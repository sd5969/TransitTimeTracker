<?php
	$p = json_decode(file_get_contents('http://www.cumtd.com/maps-and-schedules/bus-stops/RealTimeJson?id=' . $_GET['stop']	. '&pt=30'), true);
	echo $_GET['i'];
?>

<div class="h2wrapper"><h2><?php echo $_GET['stopName']; ?></h2></div>
	<table style="width: 100%; margin: 5px; padding: 5px; margin-left: 0px;">
	<?php
	$count = count($p["Departures"]);
	for($n = 0; $n < $count; $n++) {
	$bordercolor = '';
	if($p["Departures"][$n]["Headsign"] === 'ILLINI') $bordercolor = 'PURPLE';
	elseif(strpos($p["Departures"][$n]["Headsign"],"AIR BUS") !== false) $bordercolor = 'CYAN';
	elseif(strpos($p["Departures"][$n]["Headsign"]," ")) $bordercolor = str_replace("YELLOW","#ebff8a",str_replace(substr($p["Departures"][$n]["Headsign"],strpos($p["Departures"][$n]["Headsign"]," ")),"",str_replace("HOPPER","",$p["Departures"][$n]["Headsign"])));
	else $bordercolor = str_replace("YELLOW","#ebff8a",str_replace("HOPPER","",$p["Departures"][$n]["Headsign"]));
	?>
	<tr><?php echo '<td style="vertical-align: center; border: 5px solid ' . $bordercolor . ';">'; ?>
		<img src="bus.png" style="float: left; padding: 5px;" />
		<h2 style="margin-bottom: -16px; padding: 5px; font-size: 30px;"><?php echo $p["Departures"][$n]["Route"]; ?>
		<span style="float: right; font-size: 35px;"><?php echo $p["Departures"][$n]["RealTime"]; ?></span></h2>
		<span style="font-size: 12px;"><?php echo $p["Departures"][$n]["Headsign"]; ?></span>
	</td></tr>
	<?php } ?>
	</table>
