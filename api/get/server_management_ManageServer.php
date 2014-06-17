<?php
error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
if (isset($_GET['uid']) && !empty($_GET['uid']) && Check_Login_Value() == 1) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
    $con    = mysql_mysqli_connect();
    $result = mysqli_query($con, "SELECT * FROM servers WHERE UID='" . $_GET['uid'] . "'");
    while ($row = mysqli_fetch_array($result)) {
        $server["UID"]          = $row['UID'];
        $server["IP"]           = $row['IP'];
        $ip                     = $row['IP'];
        $server["ROOTPASSWORD"] = $row['ROOTPASSWORD'];
        $ROOTPASSWORD           = $row['ROOTPASSWORD'];
        $server["STATUS"]       = $row['STATUS'];
    }
    
    $ssh = new Net_SSH2($ip);
    if (!$ssh->login("root", $ROOTPASSWORD)) {
        $server['SERVERLOGIN'] = 'NO';
    } else {
        $server['SERVERLOGIN'] = 'YES';
        $server['API_STATUS']  = 'YES';
		$scr                  =  $ssh->exec("df -H | grep G");
		$mcsize                  = $ssh->exec("du -h -sh /home/minecraft/minecraft/");
		$new = preg_replace('/\s+/', '=', $scr);
		$aaaa = explode("=", $new);
		$server['disktotal'] = $aaaa[1];
		$server['diskused'] = $aaaa[2];
		$server['diskfreep'] = $aaaa[4];
        $a                     = explode("2014", $raw);
        $b                     = substr($a[1], 1);
        $c                     = explode(" ", $b);
        $b                     = preg_split('/\s+/', $c[0]);
		$file = Get_Path($server["UID"],"/home/minecraft/minecraft/server.properties");
		$lines = file($file);
        foreach ($lines as $value) {
            $e             = explode("=", $value);
            $server[$e[0]] = $e[1];
            if (empty($server[$e[0]]) || $server[$e[0]] == "\n") {
                $server[$e[0]] = 'EMPTY VALUE';
            }
        }
        //$f              = $MOTD;
        //$g              = explode("=", $f);
        //$server['motd'] = $g[1];
		$mcsizea            = explode("/", $mcsize);
		$server['mcsize'] = str_replace("\t", "", $mcsizea[0]);
		
		
		$result = mysqli_query($con, "SELECT * FROM server_data WHERE SERVER_UID='" . $_GET['uid'] . "' ORDER BY ID DESC LIMIT 1");
while ($row = mysqli_fetch_array($result)) {

$server['ms'] = $row['MS'];
}
mysqli_close($con);
    }

} else {
    Add_log_entry("UID not supplied");
    mysqli_close($con);
    $return["UID"]          = "NULL";
    $return["IP"]           = "NULL";
    $return["ROOTPASSWORD"] = "NULL";
    $return["STATUS"]       = "NULL";
	$server['$mcsize']      = "NULL";
    $server['API_STATUS']   = 'NO';
}
header('Content-Type: application/json');
echo json_encode($server);
exit;
?>