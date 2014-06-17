<?php
$rand1 = base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
$rand = substr($rand1, 0, -1);
$info = explode(".", $server_file);
$filename = str_replace($info[0],"",$server_file);
$local_file = $_SERVER['DOCUMENT_ROOT'] . '/filestore/'. $rand . $filename;

$file = fopen($local_file,"w");
echo fwrite($file,"yolo");
fclose($file);
?>