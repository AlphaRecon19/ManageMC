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
$ip       = $_POST['ip'];
$password = $_POST['password'];
$result   = mysqli_query($con, "SELECT * FROM servers WHERE IP='$ip' AND ROOTPASSWORD='$password'");
$num_rows = mysqli_num_rows($result);
$row      = mysqli_fetch_array($result);
if ($num_rows !== 0) {
    echo "222";
    exit;
}
//Check if ip is valid
if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
	if ( ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) )
	{
 		echo 1;
    	$ipt = 1;
	}
else
{
    echo 0;
    $ipt = 0;
}
} else {
    echo 1;
    $ipt = 1;
}
//Check if password is not empty
if (empty($password)) {
    echo 0;
    $pwt1 = 0;
} else {
    echo 1;
    $pwt1 = 1;
}
//Check to see if any of the tests falied
if ($pwt1 == 0 || $ipt == 0) {
    echo 0;
    exit();
}
//Check to see if we can login
$ssh = new Net_SSH2($ip);
$ssh->setTimeout(10);
if (!$ssh->login("root", $password)) {
    exit('0');
}
$a = $ssh->exec("cat /etc/*release");
if (strpos($a, 'CentOS') !== false) {
    $UID = base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
    mysqli_query($con, "INSERT INTO servers (UID, IP, ROOTPASSWORD, STATUS) VALUES ('" . $UID . "', '" . $ip . "', '" . $password . "', 'INSTALLING')");
    echo '1';
} else {
    echo 'os';
}
exit();
?>