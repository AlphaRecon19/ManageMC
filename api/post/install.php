<?php
set_time_limit(0);
ini_set('max_execution_time', 999);
error_reporting(0);
ignore_user_abort(true);
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
$con   = mysql_mysqli_connect();
$stage = $_GET['s'];
$ssh   = new Net_SSH2($_GET['ip']);
if (!$ssh->login("root", $_GET['password'])) {
    $return["data"]   = "LOGIN FAIL";
    $return["status"] = 1;
} else {
    if ($stage == 1) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL1' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("yum update -y"));
    }
    if ($stage == 2) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL2' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("yum install screen nano wget java-1.7.0-openjdk -y"));
    }
    if ($stage == 3) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL3' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec('rm -rf /etc/init.d/managemc'));
    }
    if ($stage == "3a") {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL3a' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec('wget -O /etc/init.d/managemc http://api.alpha.managemc.com/scripts/managemc'));
    }
    if ($stage == 4) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL4' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("chmod a+x /etc/init.d/managemc"));
    }
    if ($stage == 5) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL5' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("useradd minecraft"));
    }
    if ($stage == 6) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL6' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("mkdir /home/minecraft/minecraft"));
    }
    if ($stage == 7) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL7' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("mkdir /home/minecraft/backup"));
    }
    if ($stage == 8) {
        $result         = mysqli_query($con, "UPDATE servers SET STATUS='INSTALL8' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $return["data"] = htmlentities($ssh->exec("service managemc install"));
    }
    if ($stage == 9) {
        $ssh->exec("service managemc stop");
        $ssh->exec("sed -i 's/motd=A Minecraft Server/motd=Newly Installed Server VIA ManageMC/g' /home/minecraft/minecraft/server.properties");
        $ssh->exec("sed -i 's/server-ip=/server-ip=" . $_GET['ip'] . "/g' /home/minecraft/minecraft/server.properties");
        $ssh->exec("service managemc start");
        $result               = mysqli_query($con, "SELECT * FROM servers WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $row                  = mysqli_fetch_array($result);
        $result               = mysqli_query($con, "UPDATE servers SET STATUS='NEW' WHERE IP='" . $_GET['ip'] . "' AND ROOTPASSWORD='" . $_GET['password'] . "'");
        $num_rows             = mysqli_num_rows($result);
        $return["Server_UID"] = $row['UID'];
    }
}
$return["status"] = 1;
header('Content-Type: application/json');
echo json_encode($return);
exit();
?>