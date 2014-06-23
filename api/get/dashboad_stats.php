<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/api.php');
$data['API_Secure()'] =  API_Secure();
$con = mysql_mysqli_connect();
$resulta                 = mysqli_query($con, "SELECT * FROM servers WHERE STATUS='ONLINE'");
$n_p = 0;
while ($row = mysqli_fetch_array($resulta)){$n_p = $n_p + Get_ONLINE_PLAYER_NUMBER($row['UID']);}
$resulta               = mysqli_query($con, "SELECT * FROM servers WHERE STATUS='ONLINE'");
$num_rowsa             = mysqli_num_rows($resulta);
$data["server_online"] = $num_rowsa;
$data["open_ticket"]   = rand(23, 73);
$data["client"]        = rand(3, 433);
$data["players"]       = $n_p;
$result                = mysqli_query($con, "SELECT * FROM servers");
$num_rows              = mysqli_num_rows($result);
$data["servers"]       = $num_rows;
echo json_encode($data);
?>