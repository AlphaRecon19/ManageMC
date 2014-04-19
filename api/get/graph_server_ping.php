<?php
header('Content-Type: application/javascript');
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
while ($row = mysqli_fetch_array($result)) {
    $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
    $MS = $row['MS'];
    $n++;
    if ($n == 16) {
        echo '{ year: "' . $TIMESTAMP . '", ms: ' .  $MS . ', }';
    } else {
        echo '{ year: "' . $TIMESTAMP . '", ms: ' .  $MS . ', },';
    }
}
echo '];
	$("#chartContainerMS").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "year"
    },
    series: [
        { valueField: "ms", name: "RAM Free" },
    ],
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
