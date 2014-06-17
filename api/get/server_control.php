<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
error_reporting(0);
$server_UID = $_GET['uid'];
$server_IP = Get_IP($server_UID);
$server_ROOTPASSWORD = Get_ROOTPASSWORD($server_UID);

if (isset($_GET['a']) && $_GET['a'] == '2') {
    $ftp = fsockopen($server_IP, 25565, $errCode, $errStr, 5);
    if (!$ftp) {
        echo 0;
    } else {
        echo 1;
    }
    exit;
}
$ssh = new Net_SSH2($server_IP);
if (!$ssh->login("root", $server_ROOTPASSWORD)) {
    echo "LOGIN FAIL";
} else {
    if ($_GET['control'] == 'status') {
        if (isset($_GET['a']) && $_GET['a'] == '1') {
            sleep(1);
        }
        echo $ssh->exec("service managemc status s");
        exit;
    }
    
    $time_start = microtime(true);
    if ($_GET['control'] == 'start') {
        $value = $ssh->exec("service managemc start s");
        if ($value == 1) {
            Add_log_entry("This server has been started", "System");
            echo retun_date() . "ManageMC successfully started the server.<br />";
            $time_end       = microtime(true);
            $execution_time = number_format(($time_end - $time_start), 2, '.', '');
            echo retun_date() . 'The server started up in ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's.<br />';
        } else {
            Add_log_entry("ERROR starting the server " . $server_IP . "", "System");
            echo retun_date() . "Is there already a server running? Try an O/S Reboot<br />";
            $time_end       = microtime(true);
            $execution_time = number_format(($time_end - $time_start), 2, '.', '');
            echo retun_date() . 'It failed after ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's<br />';
            echo retun_date() . "ManageMC has troble completing that request.<br />";
        }
    } else if ($_GET['control'] == 'stop') {
        $value = $ssh->exec("service managemc stop s");
        if ($value == 1) {
            Add_log_entry("This server has been stopped", "System");
            echo retun_date() . "ManageMC successfully stopped the server.<br />";
            $time_end       = microtime(true);
            $execution_time = number_format($time_end - $time_start, 2, '.', '');
            echo retun_date() . 'The server closed after ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's.<br />';
        } else {
            Add_log_entry("ERROR stopping the server " . $server_IP . "", "System");
            echo retun_date() . "Is there already a server running? Try an O/S Reboot<br />";
            $time_end       = microtime(true);
            $execution_time = number_format(($time_end - $time_start), 2, '.', '');
            echo retun_date() . 'It failed after ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's<br />';
            echo retun_date() . "ManageMC has troble completing that request.<br />";
        }
        
    } else if ($_GET['control'] == 'restart') {
        
        $ssh->exec("service managemc stop s");
        $now_1               = retun_date();
        $time_end            = microtime(true);
        $execution_time_stop = ($time_end - $time_start);
        sleep(1);
        $value                = $ssh->exec("service managemc start s");
        $now_2                = retun_date();
        $time_end             = microtime(true);
        $execution_time_start = ($time_end - ($time_start + $execution_time_stop + 1));
        if ($value == 1) {
            Add_log_entry("This server has been restarted", "System");
            echo $now_1 . ' [1/2   STOP]: It took ' . number_format($execution_time_stop, 2, '.', '') . 's to compete stop the server.<br />';
            echo $now_2 . ' [2/2  START]: - Then ' . number_format($execution_time_start, 2, '.', '') . 's for the server to come back online.<br />';
            echo $now_2 . ' [Total Time]: - Then ' . number_format(($execution_time_start + $execution_time_stop), 2, '.', '') . 's for the server to come back online.<br />';
            echo retun_date() . "ManageMC successfully restarted the server.<br />";
        } else {
            Add_log_entry("ERROR restarting the server " . $server_IP . "", "System");
            echo retun_date() . "Is there already a server running? Try an O/S Reboot<br />";
            $time_end       = microtime(true);
            $execution_time = number_format(($time_end - $time_start), 2, '.', '');
            echo retun_date() . 'It failed after ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's<br />';
            echo retun_date() . "ManageMC has troble completing that request.<br />";
        }
    } else if ($_GET['control'] == 'reboot') {
        Add_log_entry("This server has been rebooted", "System");
        $value = $ssh->exec("service managemc stop s f");
        $ssh->exec("reboot");
        if ($value == 1) {
            echo retun_date() . "ManageMC successfully rebooted the server.<br />";
            echo retun_date() . "Will wait till it comes back online before anything else<br />";
        } else {
            Add_log_entry("ERROR rebooting the server " . $server_IP . "", "System");
            echo retun_date() . "Is there already a server running? Try an O/S Reboot<br />";
            $time_end       = microtime(true);
            $execution_time = number_format(($time_end - $time_start), 2, '.', '');
            echo retun_date() . 'It failed after ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's<br />';
            echo retun_date() . "ManageMC has troble completing that request.<br />";
        }
        
    } else {
        Add_log_entry("ERROR controling the server " . $server_IP . "", "System");
        echo retun_date() . "ManageMC has troble completing that request.<br />";
        $time_end       = microtime(true);
        $execution_time = number_format(($time_end - $time_start), 2, '.', '');
        echo retun_date() . 'It failed after ' . str_pad($execution_time, 3, "0", STR_PAD_LEFT) . 's<br />';
        echo retun_date() . "Here is the current log file";
        echo $ssh->exec("cat /home/minecraft/minecraft/logs/latest.log");
        
    }
    
}

function retun_date()
{
    $date = date('Y-m-d g:i:s');
    return "<b style='color: #FFF;'><[S]</b> [" . $date . "] ";
}
?>