<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
$con = mysql_mysqli_connect();

function CS_Check_Exists($file, $server_uid) {
global $con;
$result   = mysqli_query($con, "SELECT * FROM cloud_store WHERE SUID='" . $server_uid . "' AND FILENAME='" . $file . "'");
return $num_rows = mysqli_num_rows($result);
}
?>