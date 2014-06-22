<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
$con = mysql_mysqli_connect();

/* Function Download_File_FTP
This will download a remote file from the server provided and then
save it /filestore. It will retun the loacation of the saved file
*/
function FILE_Download_File_FTP($ftp_server, $ftp_user_name, $ftp_user_pass, $server_file, $server_uid, $mode)
{
global $con;
$rand1 = base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
$rand = substr($rand1, 0, -1);
$info = explode(".", $server_file);
$filename = str_replace($info[0], "", $server_file);
$local_file   = $_SERVER['DOCUMENT_ROOT'] . '/filestore/' . $rand . $filename;
$conn_id      = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
ftp_pasv($conn_id, true);
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
mysqli_query($con, "INSERT INTO filestore (UID, Original, Path, ServerUID) VALUES ('" . $rand1 . "', '" . $server_file . "', '" . $local_file . "', '" . $server_uid . "')");
if ($mode !== 0) {Add_log_entry("File Downloaded " .$server_file, "System");return "1";}
} else {Add_log_entry("Error Downloading File" .$server_file, "System"); return "0";}
ftp_close($conn_id);
}

/* Function Check_File
This will check if a file already exists. 0 = no and 1 = yes
*/
function FILE_Check_File($Server_UID, $Filename)
{
global $con;
$result   = mysqli_query($con, "SELECT * FROM filestore WHERE ServerUID='" . $Server_UID . "' AND Original='" . $Filename . "'");
$num_rows = mysqli_num_rows($result);
if ($num_rows == 1 || $num_rows > 1) {return 1;}
else {return 0;}
}

/* Function Get_Path
This will return the filepath for a remote file in /filestore
*/
function FILE_Get_Path($Server_UID, $Filename)
{
global $con;
$result   = mysqli_query($con, "SELECT * FROM filestore WHERE ServerUID='" . $Server_UID . "' AND Original='" . $Filename . "'");
$num_rows = mysqli_num_rows($result);
$row      = mysqli_fetch_array($result);
return $row['Path'];
}

/* Function Delete_File
This will delete a local file for a remote file in /filestore
*/
function FILE_Delete_File($Server_UID, $Filename)
{
global $con;
$result = mysqli_query($con, "SELECT * FROM filestore WHERE ServerUID='" . $Server_UID . "' AND Original='" . $Filename . "'");
while ($row = mysqli_fetch_array($result)) {
unlink($row['Path']);
mysqli_query($con, "DELETE FROM filestore WHERE UID='" . $row['UID'] . "'");
return 1;
}
}

/* Function Write_File
This will create a local file for a remote file in /filestore
*/
function FILE_Write_File($content, $server_file, $server_uid, $mode)
{
global $con;
$rand1      = base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
$rand       = substr($rand1, 0, -1);
if ($server_file == "/etc/init.d/managemc")
{$filename   = "managemc";}
else
{
$info       = explode(".", $server_file);
$filename   = str_replace($info[0], "", $server_file);
}
$local_file = $_SERVER['DOCUMENT_ROOT'] . '/filestore/' . $rand . $filename;
$file = fopen($local_file, "w");
fwrite($file, str_replace("<br />","//r",strip_tags($content)));
fclose($file);
mysqli_query($con, "INSERT INTO filestore (UID, Original, Path, ServerUID) VALUES ('" . $rand1 . "', '" . $server_file . "', '" . $local_file . "', '" . $server_uid . "')");
return 1;
}

/* Function Write_File
Now its time to upload it back to the server. This is what this does
*/
function FILE_Upload_File_FTP($remote_file, $filepath, $ftp_server, $ftp_user_name, $ftp_user_pass)
{
global $con;
$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if (ftp_put($conn_id, $remote_file, $filepath, FTP_BINARY)) {return "Successfully uploaded";}
else {$error_get_last = error_get_last(); return "There was a problem while uploading
" . $error_get_last['message'];}
ftp_close($conn_id);
}

/* Function Write_File
Saves a list of a directory to file. Useful for the file manager.
*/
function FILE_SSH_Save_Directory($remote_dir, $server_ip, $password, $server_uid)
{
	$ssh = new Net_SSH2($server_ip);
	if (!$ssh->login("root", $password)){Add_log_entry("ERROR controling the server " . $server_IP . " - Login Fail", "System");return "login fail";}
	else
	{
		$list = $ssh->exec("ls -l -h --si --no-group -p ". $remote_dir);
		FILE_Write_File($list, $remote_dir, $server_uid, 0);
	}
}
/* Function Write_File
Saves a list of a directory to file. Useful for the file manager.
*/
function FILE_SSH_Delete_FIle($remote_file, $server_ip, $password, $server_uid)
{
	$ssh = new Net_SSH2($server_ip);
	if (!$ssh->login("root", $password)){Add_log_entry("ERROR controling the server " . $server_IP . " - Login Fail", "System");return "login fail";}
	else
	{
		$list = $ssh->exec("rm -rf ". $remote_file);
	}
}
?>
