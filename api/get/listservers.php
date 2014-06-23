<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/api.php');
$data['API_Secure()'] =  API_Secure();
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM servers ORDER BY IP DESC");
$buffer = "";
while ($row = mysqli_fetch_array($result)) {
	$buffer .= '<tr><td><center>' . $row['UID'] . '</cetner></td>';
	$buffer .= '<td><center>' . Get_STATUS_COLOUR($row['STATUS']) . '</cetner></td>';
	$buffer .= '<td><center>' . $row['MANAGEMC_VERSION'] . '</cetner></td>';
	$buffer .= '<td><center>NULL</cetner></td>';
	$buffer .= '<td><center>' . $row['IP'] . ' <span class="glyphicon glyphicon-signal"></span>'. Get_MS($row['UID']).'ms</cetner></td>';
	$buffer .= '<td><a href="server_management.php?page=ManageServer&uid=' . $row['UID'] . '" ><button class="btn btn-info"><span class="glyphicon glyphicon glyphicon-pencil"></span></button></a></td></tr>';
}
$data["serverlist"]       = base64_encode($buffer);
echo json_encode($data);
?>