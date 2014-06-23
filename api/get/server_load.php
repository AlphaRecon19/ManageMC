<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
CORE_Check_Force_SSL();
CORE_Compress();
if (isset($_GET['uid']) && !empty($_GET['uid']) && Check_Login_Value() == 1)
{
    
    $con    = mysql_mysqli_connect();
    $result = mysqli_query($con, "SELECT * FROM servers WHERE UID='" . $_GET['uid'] . "'");
    while ($row = mysqli_fetch_array($result))
    {
        $server_uid          = $row['UID'];
        $server_ip           = $row['IP'];
        $ROOTPASSWORD = $row['ROOTPASSWORD'];
    }
    mysqli_close($con);
    
    $ssh = new Net_SSH2($server_ip);
    if (!$ssh->login("root", $ROOTPASSWORD))
    {
        $server['SERVERLOGIN'] = 'NO';
        $server['API_STATUS']  = 'YES';
    }
    else
    {
	 $a = $ssh->exec("cat /proc/loadavg");
	 $b = explode(" ",$a);
    }
	
}
$load0_100= $b[0] * 100;
$load1_100= $b[1] * 100;
$load2_100= $b[2] * 100;
$load0= $b[0] * 1;
$load1= $b[1] * 1;
$load2= $b[2] * 1;
$time = date("M j G:i:s");
$items[] = array('load0_100' => $load0_100, 'load1_100' => $load1_100, 'load2_100' => $load2_100, 'load0' => $load0, 'load1' => $load1, 'load2' => $load2, 'time' => $time);
header('Content-Type:text/json');
echo json_encode($items);

?>