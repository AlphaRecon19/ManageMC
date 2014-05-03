<?php
$starttime = microtime(true);
//error_reporting(1);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
if (isset($_GET['uid']) && !empty($_GET['uid']) && Check_Login_Value() == 1)
{
    
    $con    = mysql_mysqli_connect();
    $result = mysqli_query($con, "SELECT * FROM servers WHERE UID='" . $_GET['uid'] . "'");
    while ($row = mysqli_fetch_array($result))
    {
        $UID          = $row['UID'];
        $IP           = $row['IP'];
        $ROOTPASSWORD = $row['ROOTPASSWORD'];
    }
    mysqli_close($con);
    
    $ssh = new Net_SSH2($IP);
    if (!$ssh->login("root", $ROOTPASSWORD))
    {
        $server['SERVERLOGIN'] = 'NO';
        $server['API_STATUS']  = 'YES';
    }
    else
    {
        $server['SERVERLOGIN'] = 'YES';
        $cmd                   = $_GET['cmd'];
        if ($cmd == "start")
        {
            $server['RESAULT'] = $ssh->exec("service managemc start");
        }
        elseif ($cmd == "stop")
        {
            $server['RESAULT'] = $ssh->exec("service managemc stop");
        }
        elseif ($cmd == "restart")
        {
            $server['RESAULT'] = $ssh->exec("service managemc restart");
        }
        $stoptime = microtime(true);
        $ms       = ($stoptime - $starttime);
        $ms1      = explode(".", $ms);
        $ms2      = substr($ms1[1], 0, 2);
        $time     = $server['ms'] = $ms1[0] . '.' . $ms2;
        Add_log_entry("Server Restarted");
    }
    
}
else
{
    Add_log_entry("UID not supplied", "");
    mysqli_close($con);
    $server['RESAULT']    = 'NULL';
    $return['STATUS']     = "NO";
    $server['API_STATUS'] = 'NO';
    $server['ms']         = 'NULL';
}
header('Content-Type: application/json');
echo json_encode($server);
exit;
?>