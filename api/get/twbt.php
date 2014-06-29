<?php error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/cloudstore.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/api.php');
CORE_Compress();
$data['API_Secure()'] =  API_Secure();
if (isset($_GET['remote_dir']) && empty($_GET['remote_dir'])) {$remote_dir = '/home/minecraft/snapshots/'; $displaydir = 0;}else{$remote_dir = $_GET['remote_dir']; $displaydir = 1;}

$dir_chk = explode("/", $remote_dir);
if($dir_chk[1] == "home" && $dir_chk[2] == "minecraft" && $dir_chk[3] == "snapshots" && $remote_dir != '/home/minecraft/snapshots/')
{$remote_dir = $remote_dir;
$displaydir = 1;
}
else
{$remote_dir = '/home/minecraft/snapshots/';
$displaydir = 0;
}


$server_uid = $_GET['uid'];
$password = Get_ROOTPASSWORD($server_uid);
$server_ip = Get_IP($server_uid);
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
$lastclick = "folderclicktwbt('api/get/twbt.php?remote_dir=".$uponelevels."&uid=".$server_uid."');";
$table .='<td><center><a style="cursor: pointer;" onClick="'.$lastclick.'">../</a></center></td><td><center></center></td><td><center></center></td>';

}
foreach ($lines as $line_num => $line) {
if ($a == 0){$a=1;}
else
{
$e=explode(" ", $line);
$new = "";
foreach ($e as $a => $c) {$new .= $c."|";}
$new = str_replace("||||||||", "", $new);
$new = str_replace("|||||||", "", $new);
$new = str_replace("||||||", "", $new);
$new = str_replace("|||||", "", $new);
$new = str_replace("||||", "", $new);
$new = str_replace("|||", "", $new);
$newf= str_replace("||", "", $new);
$newe= explode("|", $newf);
$table .='<tr>';
if (!isset($newe[7]) && $newe[7] == "")
{$clicked = file_redirect($newe[0], $newe[6]);
if(CS_Check_Exists(str_replace(array("\n","\r\n"), '', $newe[6]),$server_uid) == 1){$dropboxclass = 'dropbox_true';}
else{$dropboxclass = 'dropbox_false';}
$table.= '<td id="' . $newe[6] . '"><center><a style="cursor: pointer;" onClick="' . $clicked . '">' . $newe[6] . '</a><a onclick="onclick="' .db_upload_click($remote_dir, $newe[6]). '">' . a_code($remote_dir, $newe[6]) . '</center></td><td><center>' . CORE_bytes($newe[2]) . '</center></td><td><center>' . $newe[3] . '' . $newe[4] . '@' . $newe[5] . '</center></td>';
}
elseif (!isset($newe[8]) && $newe[8] == "")
{
if(is_numeric($newe[3]))
{
$clicked = file_redirect($newe[0], $newe[6]);
if(CS_Check_Exists(str_replace(array("\n","\r\n"), '', $newe[6]),$server_uid) == 1){$dropboxclass = 'dropbox_true';}
else{$dropboxclass = 'dropbox_false';}
$table.= '<td id="' . $newe[6] . '"><center><a style="cursor: pointer;" onClick="' . $clicked . '" >' . $newe[6] . '</a><a onclick="' .db_upload_click($remote_dir, $newe[6]). '">' . a_code($newe[0], $newe[6]) . '</center></td><td><center>' . CORE_bytes($newe[3]) . '</center></td><td><center>' . $newe[4] . '@' . $newe[5] . '</center></td>';
}
else
{	
$clicked = file_redirect($newe[0], $newe[6]);
if(CS_Check_Exists(str_replace(array("\n","\r\n"), '', $newe[6]),$server_uid) == 1){$dropboxclass = 'dropbox_true';}
else{$dropboxclass = 'dropbox_false';}
$table.= '<td id="' . $newe[6] . '"><center><a style="cursor: pointer;" onClick="' . $clicked . '" >' . $newe[6] . '</a><a onclick="' .db_upload_click($remote_dir, $newe[6]). '">' . a_code($newe[0], $newe[6]) . '</center></td><td><center>' . CORE_bytes($newe[1]) . '</center></td><td><center>' . $newe[3] . '' . $newe[4] . '@' . $newe[5] . '</center></td>';
}
}
elseif (!isset($newe[9]) && $newe[9] == "")
{$clicked = file_redirect($newe[0], $newe[7]);
$db_upload_click = file_redirect($newe[0], $newe[7]);
if(CS_Check_Exists(str_replace(array("\n","\r\n"), '', $newe[7]),$server_uid) == 1){$dropboxclass = 'dropbox_true';}
else{$dropboxclass = 'dropbox_false';}
$table.= '<td id="' . $newe[7] . '"><center><a style="cursor: pointer;" onClick="' . $clicked . '" >' . $newe[7] . '</a><a onclick="' .db_upload_click($remote_dir, $newe[7]). '">' . a_code($newe[0], $newe[7]) . '</center></td><td><center>' . CORE_bytes($newe[3]) . '</center></td><td><center>' . $newe[4] . ' ' . $newe[5] . '@' . $newe[6] . '</center></td>';
}
$table.= '</tr>';
}
}
function file_redirect($str, $str1) {
global $remote_dir,$server_uid;
if (substr($str, 0, 1) == "d")
{return "folderclicktwbt('api/get/twbt.php?remote_dir=". $remote_dir ."/". str_replace("/", "", $str1)."&uid=".$server_uid."');";}
else{return "fileclick('editfile.php?filepath=". $remote_dir ."/". $str1."&uid=".$server_uid."');";}
}

function db_upload_click($str, $str1) {
return "db_upload_click('".makeid($str,$str1)."', '". $str . '/' . $str1 ."');";
}

function makeid($str, $str1) {
return str_replace(array("/",".",":"), "_", $str . $str1);
}
function a_code($a, $b)
{
global $remote_dir, $dropboxclass;
if (substr($a, 0, 1) != "d")
{return '<a onclick="' .db_upload_click($remote_dir, $b). '"><span id="'.makeid($a, $b).'"><i class="fa fa-dropbox fa-lg '.$dropboxclass.'"></i></span></a>';	}
}
$table .='</tbody></table>';
$table = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $table);
$table = str_replace(': ', ':', $table);
$table = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $table);
$data['table'] = base64_encode($table);
header('Content-Type:text/json');
echo json_encode($data);
?>
