<?php error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/cloudstore.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/api.php');
CORE_Compress();
$data['API_Secure()'] =  API_Secure();
if (isset($_GET['remote_dir']) && empty($_GET['remote_dir'])) {$remote_dir1 = '/home/minecraft/minecraft';}else{$remote_dir1 = $_GET['remote_dir'];}
$server_uid = $_GET['uid'];
$password = Get_ROOTPASSWORD($server_uid);
$server_ip = Get_IP($server_uid);
$dir_chk = explode("/", $remote_dir1);
if($dir_chk[1] == "home" && $dir_chk[2] == "minecraft" && $dir_chk[3] == "minecraft" && $remote_dir1 != '/home/minecraft/minecraft/')
{$remote_dir = $remote_dir1;
$displaydir = 1;
}
else
{$remote_dir = '/home/minecraft/minecraft/';
$displaydir = 0;
}
$file = FILE_Check_File($server_uid,$remote_dir.'.dir');
if ($file == 1)
{FILE_Delete_File($server_uid,$remote_dir.'.dir');}
$dir_file = FILE_SSH_Save_Directory($remote_dir, $server_ip, $password, $server_uid);
$lines = file($dir_file);
$file = FILE_Check_File($server_uid,$remote_dir.'.dir');
if ($file == 1)
{
FILE_Delete_File($server_uid,$remote_dir.'.dir');
}
$a=0;
$table = "";
$table .='<table class="table tableright table-striped"  style="width:100%;"><thead style="width:100%;"><tr><th><center>Filename</center></th><th><center>Size</center></th><th><center>Last Modified</center></th></tr></thead><tbody id="listservers" style="width:100%;"><tr>';

if($displaydir == 1)
{
$uponelevel = explode("/", $remote_dir);
$number = count($uponelevel) - 1;
$n=1;$uponelevels = "";
while($n < $number){$uponelevels .= '/'. $uponelevel[$n];$n++;}
$lastclick = "folderclick('api/get/filemanager.php?remote_dir=".$uponelevels."&uid=".$server_uid."');";
$table .='<td><center><a style="cursor: pointer;" onClick="'.$lastclick.'">../</a></center></td><td><center></center></td><td><center></center></td>';

}
foreach ($lines as $line_num => $line) {
if ($a == 0){$a=1;}
else
{
$newe=explode("=", $line);
//var_dump($newe); echo "<br />";
$table .='<tr>';


$filename = $newe[7];
$date2 = $newe[6];
$date = $newe[4];
$date1 = $newe[5];
$size = $newe[3];
$type = $newe[0];

$clicked = file_redirect($type, $filename);
if(CS_Check_Exists(str_replace(array("\n","\r\n"), '', $filename),$server_uid) == 1){$dropboxclass = 'dropbox_true';}
else{$dropboxclass = 'dropbox_false';}


$table.= '<td id="' . $filename . '"><center><a style="cursor: pointer;" onClick="' . $clicked . '">' . $filename . '</a>' . a_code($type, $filename) . '</center></td><td><center>' . CORE_bytes($size) . '</center></td><td><center>' . $date1 . ' ' . $date . '@' . $date2 . '</center></td>';
$table.= '</tr>';


}


}
function file_redirect($str, $str1) {
global $remote_dir,$server_uid;
if (substr($str, 0, 1) == "d")
{return "folderclick('api/get/filemanager.php?remote_dir=". $remote_dir ."/". str_replace("/", "", $str1)."&uid=".$server_uid."');";}
else{return "fileclick('editfile.php?filepath=". $remote_dir ."/". $str1."&uid=".$server_uid."');";}
}

function db_upload_click($str, $str1) {
return "db_upload_click('".makeid($str,$str1)."', '". $str . '/' . $str1 ."');";
}

function makeid($str, $str1) {
return base64_encode(str_replace(array("/","."), "", $str . $str1));
}
function a_code($a, $b)
{
global $remote_dir, $dropboxclass;
if (substr($a, 0, 1) != "d")
{return '<a onclick="' .db_upload_click($remote_dir, $b). '"><span id="'.makeid($a, $b).'"><i class="fa fa-dropbox fa-lg '.$dropboxclass.'"></i></span></a>';}
}
$table .='</tbody></table>';
$table = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $table);
$table = str_replace(': ', ':', $table);
$table = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $table);
$data['table'] = base64_encode($table);
header('Content-Type:text/json');
echo json_encode($data);
?>
