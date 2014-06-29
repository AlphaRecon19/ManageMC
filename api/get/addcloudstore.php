<?php
set_time_limit(0);
ini_set('max_execution_time', 999);
error_reporting(0);
require($_SERVER['DOCUMENT_ROOT'] . '/lib/jakajancar/dropboxuploader/dropboxuploader.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/api.php');
$data['API_Secure()'] =  API_Secure();
$con = mysql_mysqli_connect();

if (isset($_GET['uid']) && !empty($_GET['uid'])) {
	$server_uid = $_GET['uid'];
}else{die('no uid');}
if (isset($_GET['filepath']) && !empty($_GET['filepath'])) {
	$filepath = $_GET['filepath'];
	$filepathfull = $_GET['filepath'];
}else{die('no filepath');}
if (isset($_GET['type']) && !empty($_GET['type'])) {
	$type = $_GET['type'];
}else{die('no type');}
$file = FILE_Check_File($server_uid,$filepath);
$server_ip = Get_IP($server_uid);
$password = Get_ROOTPASSWORD($server_uid);

if ($file == 0)
{
FILE_Download_File_FTP($server_ip,"root",$password,$filepath,$server_uid,0);
$filepath = FILE_Get_Path($server_uid,$filepath);
}
else
{
$filepath = FILE_Get_Path($server_uid,$filepath);
}
$filename = FILE_Get_Filename($filepathfull);

if($type == "dropbox")
	{
		$result   = mysqli_query($con, "SELECT * FROM cloud_store WHERE SUID='" . $server_uid . "' AND FILENAME='" . $filename . "'");
		$num_rows = mysqli_num_rows($result);
			if($num_rows >= 1)
				{
					$data['upload'] = 1;
					$data['msg'] = 'File is already in your Dropbox!';
				}
else
{

$dir =str_replace(array('/home/minecraft/',$filename), "", $filepathfull);

 try {
        $uploader = new DropboxUploader('***REMOVED***', '***REMOVED***');
		$uploader->upload($filepath,'managemc/'.$server_ip.'/'.$dir.'/','CS'.date('YmdHis_').$filename);
		$data['upload'] = 1;
        $data['msg'] = 'File is now in your Dropbox!';
		$rand1 = base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
mysqli_query($con, "INSERT INTO cloud_store (UID, SUID, FILENAME, UPLOADTIME, TYPE) VALUES ('" . $rand1 . "', '" . $server_uid . "', '" . $filename . "', '" . time() . "', 'DROPBOX')");
    } catch (Exception $e) {
        $label = ($e->getCode() & $uploader::FLAG_DROPBOX_GENERIC) ? 'DropboxUploader' : 'Exception';
        $error = sprintf("[%s] #%d %s", $label, $e->getCode(), $e->getMessage());
		$data['upload'] = 0;
        $data['msg'] = htmlspecialchars($error);
}
}
}
FILE_Delete_File($server_uid,$filepath);
header('Content-Type:text/json');
echo json_encode($data);
exit;
?>