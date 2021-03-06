<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
$con = mysql_mysqli_connect();



function get_server_infomation($server_uid) {
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `servers` WHERE UID='$server_uid'");
    $row = mysqli_fetch_array($result);
    $array = array('IP' => $row['IP'],
		   'MS' => Get_MS($server_uid),
		   'STATUS' => $row['STATUS'],
		   'MANAGEMC_VERSION' => $row["MANAGEMC_VERSION"]
		   );
    return $array;
}




function Get_IP($server_uid)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `servers` WHERE UID='$server_uid'");
	$row = mysqli_fetch_array($result);
	return $row['IP'];
}
function Get_ROOTPASSWORD($server_uid)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `servers` WHERE UID='$server_uid'");
	$row = mysqli_fetch_array($result);
	return $row['ROOTPASSWORD'];
}
function Get_CLIENT_ID($server_uid)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `servers` WHERE UID='$server_uid'");
	$row = mysqli_fetch_array($result);
	return $row['CLIENT_ID'];
}
function Get_ONLINE_PLAYER_NUMBER($server_uid)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `server_data` WHERE `SERVER_UID`='$server_uid' ORDER BY `ID` DESC LIMIT 1");
	$row = mysqli_fetch_array($result);
	return $row['PLAYERS'];
}
function Get_MS($server_uid)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `server_data` WHERE `SERVER_UID`='$server_uid' ORDER BY `ID` DESC LIMIT 1");
	$row = mysqli_fetch_array($result);
	return $row['MS'];
}
function Get_STATUS_COLOUR($status)
{
	if ($status == "ONLINE"){	return "<b style='color:#0F0;'>ONLINE</b>";}
	elseif ($status == "OFFLINE"){	return "<b style='color:#F00;'>OFFLINE</b>";}
	elseif ($status == "RESTARTING"){	return "<b style='color:#FF0'></b>";}
	elseif ($status == "REBOOTING"){	return "<b style='color:#63F;'>REBOOTING</b>";}
	elseif ($status == "UNKNOWN"){	return "<b style='color:#999;'>UNKNOWN</b>";}
	
}
function Get_MANAGEMC_VERSION_SSH($server_uid)
{
	$server_ip = Get_IP($server_uid);
	$password = Get_ROOTPASSWORD($server_uid);
	$ssh = new Net_SSH2($server_ip);
	if (!$ssh->login("root", $password)){Add_log_entry("ERROR contriving the server " . $server_IP . " - Login Fail", "System");return "login fail";}
	global $con;
	return $ssh->exec("service managemc version s");	
}
function Get_MANAGEMC_VERSION_DB($server_uid)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM `server` WHERE `SERVER_UID`='$server_uid' ORDER BY `ID` DESC LIMIT 1");
	$row = mysqli_fetch_array($result);
	return $row['MANAGEMC_VERSION'];
}
function Update_MANAGEMC_VERSION($server_uid, $ManageMC_v)
{
	global $con;
	$result = mysqli_query($con, "UPDATE servers SET MANAGEMC_VERSION='". $ManageMC_v ."' WHERE `UID`='$server_uid'");	
}
function Control_Snapshot($server_uid)
{
	global $con;
	$ssh = new Net_SSH2(Get_IP($server_uid));
	if (!$ssh->login("root", Get_ROOTPASSWORD($server_uid))){Add_log_entry("ERROR controlling the server " . $server_IP . " - Login Fail", "System");return "login fail";}
	mysqli_query($con, "UPDATE servers SET LAST_SNAP='". time() ."' WHERE UID='" . $server_uid  . "'");
	return $ssh->exec("service managemc backup");
}
?>