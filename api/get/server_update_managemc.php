<?php
error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
$server_uid = $_GET['uid'];
$server_ip = Get_IP($server_uid);
$password = Get_ROOTPASSWORD($server_uid);
$filepath = "/etc/init.d/managemc";
$file = FILE_Check_File($server_uid,$filepath);
if ($file == 1)
{
FILE_Delete_File($server_uid,$filepath);
}
$content = file_get_contents("http://api.alpha.managemc.com/managemc");
FILE_Write_File($content, $filepath, $server_uid, 0);
$File_Path = FILE_Get_Path($server_uid,$filepath);
$File_Upload =FILE_Upload_File_FTP($filepath, $File_Path, $server_ip, "root", $password);
$file = FILE_Check_File($server_uid,$filepath);
FILE_Delete_File($server_uid,$filepath);
if($File_Upload == "Successfully uploaded")
{
$ManageMC_v = Get_MANAGEMC_VERSION_SSH($server_uid);
Update_MANAGEMC_VERSION($server_uid, $ManageMC_v);
$data['msg'] = 1;
$data['version'] = $ManageMC_v;
}
else
{
$data['msg'] = $File_Upload;	
}
header('Content-Type: application/json');
echo json_encode($data);
exit;
?>
