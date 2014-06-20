<?php error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
if (isset($_GET['page']) && !empty($_GET['page'])) {$remote_dir = '/home/minecraft/minecraft';}else{$remote_dir = $_GET['remote_dir'];}
$server_uid = $_GET['uid'];
$server_ip = Get_IP($server_uid);
$password = Get_ROOTPASSWORD($server_uid);
$file = FILE_Check_File($server_uid,$remote_dir);
if ($file == 1)
{FILE_Delete_File($server_uid,$remote_dir);}
$dir_file = FILE_SSH_Save_Directory($remote_dir, $server_ip, $password, $server_uid);
$file = FILE_Get_Path($server_uid,$remote_dir);
$lines = file($file);
$file = FILE_Check_File($server_uid,$remote_dir);
if ($file == 1)
{FILE_Delete_File($server_uid,$remote_dir);}
$a=0;
$table = "";
$table .='<table class="table tableright table-striped"  style="width:100%;"><thead style="width:100%;"><tr><th><center>Filename</center></th><th><center>Size</center></th><th><center>Last Modified</center></th></tr></thead><tbody id="listservers" style="width:100%;"><tr>';
$uponelevel = explode("/", $remote_dir);
$number = count($uponelevel) - 1;
$n=1;$uponelevels = "";
while($n < $number){$uponelevels .= '/'. $uponelevel[$n];$n++;}
$table .='<td><center><a href="test.php?remote_dir='.$uponelevels.'&uid='.$server_uid.'">../</a></center></td><td><center></center></td><td><center></center></td>';
foreach ($lines as $line_num => $line) {
	if ($a == 0)
	{
		$a=1;
	}
	else
	{
			$e             = explode(" ", $line);
			$new = "";
			foreach ($e as $a => $c) {
			$new .= $c."|";
			}
			$new = str_replace("||||||||", "", $new);
			$new = str_replace("|||||||", "", $new);
			$new = str_replace("||||||", "", $new);
			$new = str_replace("|||||", "", $new);
			$new = str_replace("||||", "", $new);
			$new = str_replace("|||", "", $new);
			$newf = str_replace("||", "", $new);
			$newe             = explode("|", $newf);
			foreach ($newe as $a => $c) {
				$n = 1;
				while($n < 1024)
				{if($c == "minecraft".$n){$yolo = 1; $n = 1024;}
				else{
				$n++;
				}
				}
			}
			$table .='<tr>';
			if (!isset($newe[7]) && $newe[7]== "")
			{$table .='<td><center><a href="'.file_redirect($newe[0], $newe[6]).'&uid='.$server_uid.'">'. $newe[6] .'</a></center></td><td><center>'. $newe[2] .'</center></td><td><center>'. $newe[3] . '' .$newe[4]. '@' . $newe[5] .'</center></td>';}
			elseif (!isset($newe[8]) && $newe[8]== "")
			{$table .='<td><center><a href="'.file_redirect($newe[0], $newe[6]) .'&uid='.$server_uid.'">'. $newe[6] .'</a></center></td><td><center><1k</center></td><td><center>'. $newe[3] . '' .$newe[4]. '@' . $newe[5] .'</center></td>';}
			elseif (!isset($newe[9]) && $newe[9]== "")
			{$table .='<td><center><a href="'.file_redirect($newe[0], $newe[7]) .' &uid='.$server_uid.'">'. $newe[7] .'</a></center></td><td><center>'. $newe[3] .'</center></td><td><center>'. $newe[4] . ' ' .$newe[5]. '@' . $newe[6] .'</center></td>';}
            $table .='</tr>';
	}
	}
	function file_redirect($str, $str1) {
	global $remote_dir;
	if (substr($str, 0, 1) == "d")
	{return 'test.php?remote_dir='. $remote_dir .'/'. str_replace("/", "", $str1);
	}else{return 'editfile.php?filepath='. $remote_dir .'/'. $str1;}
	}
$table .='</tbody></table>';
$items['table'] = $table;
header('Content-Type:text/json');
echo json_encode($items);
?>
