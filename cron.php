<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
date_default_timezone_set('Europe/London');
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM servers");
while ($row = mysqli_fetch_array($result)) {
    echo '|' . $UID = $row['UID'];
    $starttime = microtime(true);
    if ($fp = fsockopen($row['IP'], 25565, $errCode, $errStr, 2)) {
        $stoptime = microtime(true);
        $ms       = ($stoptime - $starttime) * 1000;
        $ms1      = explode(".", $ms);
        echo '|' . $TABLE_MS = $ms1[0];
    } else {
        $TABLE_MS = '-1';
    }
    fclose($fp);
    $ssh = new Net_SSH2($row['IP']);
    if (!$ssh->login("root", $row['ROOTPASSWORD'])) {
        echo $TABLE_RAMFREE = '-1';
    }
	
	echo "|" .$players = $ssh->exec("service managemc command list") . "|";
	
	
	$a = $ssh->exec("cat /proc/loadavg");
	$b = explode(" ",$a);
	echo '|'. $load = $b[0] * 100;
    $ip  = $ssh->exec('grep -i "MemFree" /proc/meminfo');
    $ip2 = explode("MemFree:", $ip);
    $ip3 = substr($ip2[1], 0, -3);
    $ip4 = $ip3 / 1024;
    $ms1 = explode(".", $ip4);
    echo '|' . time() . '|' . $TABLE_RAMFREE = $ms1[0];
    mysqli_query($con, "INSERT INTO server_data (SERVER_UID, RAM_FREE, TIMESTAMP, LOAD1, MS) VALUES ('" . $UID . "', '" . $TABLE_RAMFREE . "', '" . time() . "', '" . $load . "', '" . $TABLE_MS . "')");



//if(Check_File($UID,"/home/minecraft/minecraft/server.properties") == 1)
//{
//	Delete_File($UID,"/home/minecraft/minecraft/server.properties");
//	Download_File_FTP($row['IP'],"root",$row['ROOTPASSWORD'],'/home/minecraft/minecraft/server.properties',$UID,0);
//}
//else{
//Download_File_FTP($row['IP'],"root",$row['ROOTPASSWORD'],'/home/minecraft/minecraft/server.properties',$UID,0);
//echo 1;
//}

}
?>