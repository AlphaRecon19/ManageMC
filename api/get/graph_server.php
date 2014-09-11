<?php
$time_start = microtime(true);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
CORE_Compress();
header('Cache-control: max-age=1');
header("content-type: application/javascript");
$type = $_GET['type'];
$time = $_GET['time'];
$res = $_GET['res'];
if(!isset($_GET['timestamp']))
{
	$timestamp =time();	
}
else
{
	$timestamp = $_GET['timestamp'];
}
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/functions/core/core.php');
$con = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM server_data WHERE SERVER_UID='".$_GET['uid']."' AND TIMESTAMP < ". $timestamp ." ORDER BY ID DESC LIMIT ".$time ."");
if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
echo '$(function (){var dataSource = [';
$n = 0;
$t = 0;
if ($type == "load") {
    while ($row = mysqli_fetch_array($result)) {
        $n++;
        if ($n < $res) {} else {
            $t++;
            $LOAD = $row['LOAD1'];
            $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
            if ($n == 16)
			{    echo '{ time: "'.$TIMESTAMP.'", load1: '.$LOAD / 100 .', }';
            } else {
                echo '{ time: "'.$TIMESTAMP.'", load1: '.$LOAD / 100 .', },';
            }
            $n = 0;
        }
    }
}
elseif($type == "ms") {
    while ($row = mysqli_fetch_array($result)) {
        $n++;
        if ($n < $res) {} else {
            $t++;
            $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
            $MS = $row['MS'];
            $n++;
            if ($n == 16) {
                echo '{ time: "'.$TIMESTAMP.'", ms: '.$MS.', }';
            } else {
                echo '{ time: "'.$TIMESTAMP.'", ms: '.$MS.', },';
            }
            $n = 0;
        }
    }
}
elseif($type == "free") {
    while ($row = mysqli_fetch_array($result)) {
        $n++;
        if ($n < $res) {} else {
            $t++;
            $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
            $RAM_FREE = $row['RAM_FREE'];
            $n++;
            if ($n == 16) {
                echo '{ time: "'.$TIMESTAMP.'", free: '.$RAM_FREE.', }';
            } else {
                echo '{ time: "'.$TIMESTAMP.'", free: '.$RAM_FREE.', },';
            }
            $n = 0;
        }
    }
}
elseif($type == "players") {
    while ($row = mysqli_fetch_array($result)) {
        $n++;
        if ($n < $res) {} else {
            $t++;
            $TIMESTAMP = date('H:i', $row['TIMESTAMP']);
            $PLAYERS = $row['PLAYERS'];
            $n++;
            if ($n == 16) {
                echo '{ time: "'.$TIMESTAMP.'", players: '.$PLAYERS.', }';
            } else {
                echo '{ time: "'.$TIMESTAMP.'", players: '.$PLAYERS.', },';
            }
            $n = 0;
        }
    }
}
echo '];$("';
if ($type == "load")
{echo '#chartContainerload';}
elseif($type == "ms")
{echo '#chartContainerms';}
elseif($type == "free")
{echo '#chartContainerfree';}
elseif($type == "players")
{echo '#chartContainerplayers';}
echo '").dxChart({dataSource: dataSource,commonSeriesSettings: {argumentField: "time"},series: [';
if ($type == "load")
{echo '{ valueField: "load1", name: "Server Load" },';}
elseif($type == "ms")
{echo '{ valueField: "ms", name: "Server Ping" },';}
elseif($type == "free")
{echo '{ valueField: "free", name: "Free Ram" },';}
elseif($type == "players")
{echo '{ valueField: "players", name: "Players" },';}
echo '],legend: {horizontalAlignment: "center",verticalAlignment: "bottom",visible: false},argumentAxis:{grid:{visible: true}},tooltip:{enabled: true},commonPaneSettings: {border:{visible: false,right: false}}});});';

if (isset($_GET['stats']) && $_GET['stats'] == 'true') {
    $result = mysqli_query($con, "SELECT * FROM server_data WHERE SERVER_UID='".$_GET['uid']."' AND TIMESTAMP < ". $timestamp ." ORDER BY ID DESC LIMIT ".$time ."");
    $n = 0;
    while ($row = mysqli_fetch_array($result)) {
        $n++;
        if ($n > 1) {} else {
			$date = date('Y-m-d g:i:s', $row['TIMESTAMP']);
            echo '$("#firstrecord").html("'.$date.'");';
        }
    }
    $result = mysqli_query($con, "SELECT * FROM server_data WHERE SERVER_UID='".$_GET['uid']."' AND TIMESTAMP < ". $timestamp ." ORDER BY ID DESC LIMIT ".$time ."");
    $n = 0;
    while ($rowa = mysqli_fetch_array($result)) {
        $n++;
        if ($n == $t) {
			$date = time() - $rowa[3];
			$date2 = date('G:i:s');
            echo '$("#timesince").html("'.CORE_Time_Elapsed($date,0).', when this graph was genarated @ '.date('g:i:s').'");';
            
        } else {}
    }
    echo '$("#total_r").html("'.round($t, 0, PHP_ROUND_HALF_DOWN).'");';
   $time_end = microtime(true);
    $execution_time = ($time_end - $time_start);
    echo '$("#total_t").html("'.number_format($execution_time, 2, '.', '').' seconds");';
}