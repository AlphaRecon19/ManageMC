<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
$con    = mysql_mysqli_connect();
$Posted_File = $_POST["savefiledata"];
$Server_UID = $_GET["Server_UID"];
$server_ip = Get_IP($Server_UID);
$password = Get_ROOTPASSWORD($Server_UID);
$Remote_File = $_GET["File_Path"];
FILE_Delete_File($Server_UID,$Remote_File);
$filestore = FILE_Write_File($Posted_File,$Remote_File,$Server_UID,1);
$File_Path = FILE_Get_Path($Server_UID,$Remote_File);
$ssh   = new Net_SSH2($server_ip);
if ($ssh->login("root", $password)) {
	$ssh->exec("rm -rf " .$Remote_File . "");
}
$return["message"]       = FILE_Upload_File_FTP($Remote_File, $File_Path, $server_ip, "root", $password);
header('Content-Type: application/json');
echo json_encode($return);
?>