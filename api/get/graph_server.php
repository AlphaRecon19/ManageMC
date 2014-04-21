<?php
header('Content-Type: application/javascript');
header('Cache-control: max-age=1');

$type = $_GET['type'];

include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM server_data WHERE SERVER_UID='" . $_GET['uid'] . "' ORDER BY ID DESC LIMIT 15");
if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
echo '$(function ()  
				{
   var dataSource = [';
$n = 1;

if($type == "load")

{
while ($row = mysqli_fetch_array($result)) {
    $LOAD      = $row['LOAD1'];
    $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
    $n++;
    if ($n == 16) {
        echo '{ year: "' . $TIMESTAMP . '", load1: ' . $LOAD / 100 . ', }';
    } else {
        echo '{ year: "' . $TIMESTAMP . '", load1: ' . $LOAD / 100 . ', },';
    }
}}

elseif($type == "ms")

{
while ($row = mysqli_fetch_array($result)) {
    $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
    $MS = $row['MS'];
    $n++;
    if ($n == 16) {
        echo '{ year: "' . $TIMESTAMP . '", ms: ' .  $MS . ', }';
    } else {
        echo '{ year: "' . $TIMESTAMP . '", ms: ' .  $MS . ', },';
    }
}}

elseif($type == "free")

{
while ($row = mysqli_fetch_array($result)) {
    $RAM_FREE  = $row['RAM_FREE'];
    $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
    $n++;
    if ($n == 16) {
        echo '{ year: "' . $TIMESTAMP . '", free: ' . $RAM_FREE . ', }';
    } else {
        echo '{ year: "' . $TIMESTAMP . '", free: ' . $RAM_FREE . ', },';
    }
}
}



echo '];
	$("';
	
	
	if($type == "load")

{
	echo '#chartContainerLOAD';
}

elseif($type == "ms")

{
	echo '#chartContainerMS';
}

elseif($type == "free")

{
	echo '#chartContainer';
}
	echo '").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "year"
    },
    series: [';
	
	
	
		if($type == "load")

{
	echo '{ valueField: "load1", name: "Server Load" },';
}

elseif($type == "ms")

{
	echo '{ valueField: "ms", name: "Server Ping" },';
}

elseif($type == "free")

{
	echo '{ valueField: "free", name: "Free Ram" },';
}
        
    echo'],
    argumentAxis:{
        grid:{
            visible: true
        }
    },
    tooltip:{
        enabled: true
    },
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    commonPaneSettings: {
        border:{
            visible: true,
            right: false
        }       
    }
});
}

			);';
?>
