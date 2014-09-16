<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/api.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
CORE_Compress();
$data['API_Secure()'] =  API_Secure();

$data['responce'] = Get_IP($_GET['uid']);
	$ssh = new Net_SSH2(Get_IP($_GET['uid']));
	if (!$ssh->login("root", Get_ROOTPASSWORD($_GET['uid']))) {}
	else{
	    $data['responce'] = nl2br ($ssh->exec($_GET['cmd']));
	}
    header('Content-Type: application/json');
   	echo json_encode($data);
    exit;



?>