<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');

$server_uid = $_GET['uid'];

if (isset($_GET['uid']) && !empty($_GET['uid']) && Check_Login_Value() == 1) {
    $ssh = new Net_SSH2(Get_IP($server_uid));
	if (!$ssh->login("root", Get_ROOTPASSWORD($server_uid))) {}
	else{
	    $scr = $ssh->exec("df --block-size=G | grep G");
	    $mcsize = $ssh->exec("du -s /home/minecraft/minecraft/world");
	}    
    $new = preg_replace('/\s+/', '=', $scr);
    $aaaa = explode("=", $new);
	if(substr( $aaaa[7], 0, 1 ) === "/"){
	    $number=0;
	}else{
	    $number=1;
	}
    $server['DISKTOTAL'] = str_replace("G", "GB", $aaaa[8-$number]);
    $server['DISKUSED'] = str_replace("G", "", $aaaa[8-$number]) / 100 * $aaaa[11-$number] .'GB';
    $server['DISKFREEP'] = $aaaa[11-$number];
    $mcsizea = explode("/", $mcsize);
    $server['MCSIZE'] = CORE_bytes(str_replace("\t", "", $mcsizea[0]) * 1000);
    $server["CLIENT_ID"] = Get_CLIENT_ID($server_uid);
    
    header('Content-Type: application/json');
    echo json_encode($server);
    exit;
}

?>