<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/lib/phpseclib/Net/SSH2.php');

function SSH_ls ($Host,$Username,$Password,$cmd) {

$ssh = new Net_SSH2($Host);
if (!$ssh->login($Username, $Password)) {
    exit('Login Failed');
}

return $ssh->exec($cmd);
	
}


?>