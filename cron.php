<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/funnyitselmo/PHP-Minecraft-Server-Status-Query/MinecraftServerStatus.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
date_default_timezone_set('Europe/London');
error_reporting(0);
$con    = mysql_mysqli_connect();
if(isset($_GET['uid']))
{
$result = mysqli_query($con, "SELECT * FROM servers WHERE UID='".$_GET['uid']."'");
}
else
{
$result = mysqli_query($con, "SELECT * FROM servers");
}
$n = 0;
while ($row = mysqli_fetch_array($result)) {
	$time_start = microtime(true);
	$n++;
    $server_uid = $row['UID'];
	$server_ip = $row['IP'];
	$LAST_SNAP      = $row['LAST_SNAP'];
	$NEXT_SNAP     = str_pad($LAST_SNAP + ($row['SNAP_EVERY'] * 60 * 60), 2, "0", STR_PAD_LEFT);
    $ssh = new Net_SSH2($row['IP']);
    if (!@$ssh->login("root", $row['ROOTPASSWORD'])) {$N_Ramfree = '0'; $N_Load = "0"; $N_Ping = "0";$N_Status = 'OFFLINE';$N_Players = '0';}
	else
	{
	if (isset($_GET['type']) && $_GET['type'] == "snapshots")
	{
		
		
	$timestamp = $NEXT_SNAP;


$day = date( 'Y-m-d', $timestamp ); // $day is now "2012-03-09"
$hour = (int)date( 'H', $timestamp ); // $hour is now (int)16
$minute = (int)date( 'i', $timestamp ); // $minute is now (int)23


  $windowStart = strtotime( "$day $hour:30:00" ) . '';
  if( ++$hour > 23 ){
    // if we crossed midnight, fix the date and set the hour to 00
    $day = date( 'Y-m-d', $timestamp + (24*60*60) );
    $hour = '00';
  }
  $NEXT_SNAP   = strtotime( "$day $hour:00:00" ) . '';
		
	if($LAST_SNAP == 0){
	$backup = 'YES';
	}
	elseif($windowEnd < $NEXT_SNAP)
	{
		$backup = 'YES';
	}
	else
	{
		$backup = 'NO';
	}
	if (isset($_GET['readonly']) && $_GET['readonly'] == "true")
	{
	 	// Assume $timestamp has the original timestamp, i.e. 2012-03-09 16:23:41



// Now $windowStart and $windowEnd are the unix timestamps of your endpoints
	echo "-----------------------------------[snapshots stats]-----------------------------------<br />";
	echo "LAST_SNAP=" . $LAST_SNAP . '<br />';
	echo "LAST_SNAP_date=" . date("F j, Y, g:i a", $LAST_SNAP) . '<br />';
	echo "NEXT_SNAP=" . $NEXT_SNAP . '<br />';
	echo "NEXT_SNAP_date=" . date("F j, Y, g:i a", $NEXT_SNAP) . '<br />';
	echo "Backup=" . $backup . '<br />';
	echo "---------------------------------------------------------------------------------------<br />";
	}
	else
	{
	if($backup == 'YES'){
    //Control_Snapshot($server_uid);
	}
	}
	}
	else
	{
	$status = new MinecraftServerStatus();
	$players = $status->getStatus($server_ip);
	if (empty($players['players']) && $players['players']!= 0){$N_Players = '0';}else{$N_Players = $players['players'];}
	if (empty($N_Players)){$N_Players = '0';}
	if (empty($players['ping'])){$N_Ping = '0';$N_Status = 'OFFLINE';}else{$N_Ping = $players['ping'];$N_Status = 'ONLINE';}
		
	if($serverSTATUS !== $N_Status)
	{
	$ssh->exec("service managemc start s");	
	$N_Status = 'ONLINE';
	}
	
	$a = $ssh->exec("cat /proc/loadavg");
	$b = explode(" ",$a);
	$N_Load = $b[0] * 100;
    $server  = $ssh->exec('grep -i "MemFree" /proc/meminfo');
	$ManageMC_v  = $ssh->exec('service managemc version s');
    $server2 = explode("MemFree:", $server);
    $server3 = substr($server2[1], 0, -3);
    $server4 = $server3 / 1024;
    $ms1 = explode(".", $server4);
    $N_Ramfree = $ms1[0];
	}
	if (isset($_GET['readonly']) && $_GET['readonly'] == "true")
	{
		$totaltime = microtime(true) - $time_start;
		if ($totaltime < 1)
		{
			$totaltime = '< 1 Second';
		}
		else
		{
			$totaltime = CORE_Time_Elapsed(($totaltime),0);
		}
	echo "--------------------------------------[ Server  $n]--------------------------------------<br />";
	echo "-----------------------------------[ $server_ip ]----------------------------------<br />";
	echo "---------------------------------------------------------------------------------------<br />";
	echo "\$server_uid=" . $server_uid . "<br />";
	echo "\$N_Status=" . $N_Status. "<br />";
	echo "\$ManageMC_v=" . $ManageMC_v. "<br />";
	echo "\$N_Ramfree=" . $N_Ramfree . "<br />";
	echo "\$time()=" . time() . "|".date('Y-m-d g:i:s')."<br />";
	echo "\$N_Load=" . $N_Load . "<br />";
	echo "\$N_Ping=" . $N_Ping . "<br />";
	echo "\$N_Players=" . $N_Players . "<br />";
    echo "Total time taken on this server=" .$totaltime."<br />";
	echo "---------------------------------------------------------------------------------------<br />";
	}
	else
	{
		if (empty($N_Ramfree))
		{
			$N_Ramfree = '0';
		}
				if (empty($N_Load))
		{
			$N_Load = '0';
		}
				if (empty($N_Ping))
		{
			$N_Ping = '0';
		}
				if (empty($N_Players))
		{
			$N_Players = '0';
		}
		
		
    mysqli_query($con, "INSERT INTO server_data (SERVER_UID, RAM_FREE, TIMESTAMP, LOAD1, MS, PLAYERS) VALUES ('" . $server_uid . "', '" . $N_Ramfree . "', '" . time() . "', '" . $N_Load . "', '" . $N_Ping . "', '" . $N_Players . "')");
	mysqli_query($con, "UPDATE servers SET STATUS='". $N_Status ."' WHERE UID='" . $server_uid  . "'");
	mysqli_query($con, "UPDATE servers SET MANAGEMC_VERSION='". $ManageMC_v ."' WHERE UID='" . $server_uid  . "'");
	}
}
}
?>
