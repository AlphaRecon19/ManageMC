<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
$con    = mysql_mysqli_connect();
function Download_FIle_FTP($ftp_server,$ftp_user_name,$ftp_user_pass,$server_file,$ServerUID,$mode)
{
global $con;
$rand1 = base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
$rand = substr($rand1, 0, -1);
$info = explode(".", $server_file);
$filename = str_replace($info[0],"",$server_file);
$local_file = $_SERVER['DOCUMENT_ROOT'] . '/filestore/'. $rand . $filename;
$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
ftp_pasv($conn_id, true);
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
mysqli_query($con, "INSERT INTO filestore (UID, Original, Path, ServerUID) VALUES ('" . $rand1 . "', '" . $server_file . "', '" . $local_file . "', '" . $ServerUID . "')");
if($mode !== 0)
{Add_log_entry("File Downloaded " . $rand, "");}
}
else{
Add_log_entry("Error Downloading " . $rand, "");
}
ftp_close($conn_id);
}



function Check_File($Server_UID,$Filename)
{
global $con;
$result   = mysqli_query($con, "SELECT * FROM filestore WHERE ServerUID='" . $Server_UID . "' AND Original='" . $Filename . "'");
$num_rows = mysqli_num_rows($result);
if ($num_rows == 1 || $num_rows > 1) {
return 1;
}
else{
return 0;
}
}
function Get_Path($Server_UID,$Filename)
{
global $con;
$result   = mysqli_query($con, "SELECT * FROM filestore WHERE ServerUID='" . $Server_UID . "' AND Original='" . $Filename . "'");
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
return $row['Path'];
}
function Delete_File($Server_UID,$Filename)
{
global $con;
$result   = mysqli_query($con, "SELECT * FROM filestore WHERE ServerUID='" . $Server_UID . "' AND Original='" . $Filename . "'");
while ($row = mysqli_fetch_array($result)) {
unlink($row['Path']);
mysqli_query($con,"DELETE FROM filestore WHERE UID='". $row['UID'] ."'");
}
}
?>
