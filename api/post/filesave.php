<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
$con    = mysql_mysqli_connect();

$Posted_File = str_replace("<br />","",strip_tags($_POST["content"]));
$Server_UID = $_GET["Server_UID"];
$Remote_File = $_GET["File_Path"];
Delete_File($Server_UID,$Remote_File);
$filestore = Write_File($Posted_File,$Remote_File,$Server_UID,1);
$File_Path = Get_Path($Server_UID,$Remote_File);

$result = mysqli_query($con, "SELECT * FROM servers WHERE UID='".$Server_UID."'");
$row = mysqli_fetch_array($result);
$ssh   = new Net_SSH2($row['IP']);
if (!$ssh->login("root", $row['ROOTPASSWORD'])) {
	$ssh->exec("service managemc download " . $Remote_File . " http://alpha.managemc.com/filestore/" . $filestore);
}
Upload_File_FTP($Remote_File, $File_Path, "149.3.143.103", "root", "***REMOVED***");
$return["servers"]       = $Posted_File;
echo json_encode($return);
?>