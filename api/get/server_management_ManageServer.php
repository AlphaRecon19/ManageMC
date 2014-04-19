<?php
error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
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
    mysqli_close($con);
    $ssh = new Net_SSH2($ip);
    if (!$ssh->login("root", $ROOTPASSWORD)) {
        $server['SERVERLOGIN'] = 'NO';
    } else {
        $server['SERVERLOGIN'] = 'YES';
        $server['API_STATUS']  = 'YES';
        $raw                   = $ssh->exec("cat /home/minecraft/minecraft/server.properties");
        $MOTD                  = $ssh->exec("tail -1 /home/minecraft/minecraft/server.properties");
        $a                     = explode("2014", $raw);
        $b                     = substr($a[1], 1);
        $c                     = explode(" ", $b);
        $b                     = preg_split('/\s+/', $c[0]);
        foreach ($b as $value) {
            $e             = explode("=", $value);
            $server[$e[0]] = $e[1];
            if (empty($server[$e[0]])) {
                $server[$e[0]] = 'EMPTY VALUE';
            }
        }
        $f              = substr($MOTD, 0, -2);
        $g              = explode("=", $f);
        $server['motd'] = $g[1];
    }
    $starttime = microtime(true);
    if ($fp = fsockopen($ip, $server['server-port'], $errCode, $errStr, 1)) {
        $stoptime     = microtime(true);
        $ms           = ($stoptime - $starttime) * 1000;
        $ms1          = explode(".", $ms);
        $server['ms'] = $ms1[0];
    } else {
        $server['ms'] = "-";
    }
    fclose($fp);
} else {
    Add_log_entry("UID not supplied", "");
    mysqli_close($con);
    $return["UID"]          = "NULL";
    $return["IP"]           = "NULL";
    $return["ROOTPASSWORD"] = "NULL";
    $return["STATUS"]       = "NULL";
    $server['API_STATUS']   = 'NO';
}
header('Content-Type: application/json');
echo json_encode($server);
exit;
?>