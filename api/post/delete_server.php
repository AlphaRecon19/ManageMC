<?php
error_reporting(0);
/*

API - add_server_check.php

Type : POST
URL : /api/post/add_server_check.php ip={$ip}&password={$Password}
Succsess Value : 'Succsess'


*/
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
$con      = mysql_mysqli_connect();
$UID      = $_GET['uid'];
$result   = mysqli_query($con, "SELECT * FROM servers WHERE UID='$UID'");
$num_rows = mysqli_num_rows($result);
$row      = mysqli_fetch_array($result);
$ip = $row['IP'];
$password = $row['ROOTPASSWORD'];

//Check to see if we can login
$ssh = new Net_SSH2($ip);
$ssh->setTimeout(10);
if (!$ssh->login("root", $password)) {
mysqli_query($con, "DELETE FROM servers WHERE UID='".$UID."'");
mysqli_query($con, "DELETE FROM server_data WHERE SERVER_UID='".$UID."'");
	exit('1');
}
$ssh->exec("service managemc stop");
$ssh->exec("userdel -r minecraft");
$ssh->exec("rm -rf /etc/init.d/managemc");
$ssh->exec("reboot");
mysqli_query($con, "DELETE FROM servers WHERE UID='".$UID."'");
mysqli_query($con, "DELETE FROM server_data WHERE SERVER_UID='".$UID."'");
exit('1');
?>