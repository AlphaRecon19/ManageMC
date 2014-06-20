<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM servers ORDER BY IP DESC");
while ($row = mysqli_fetch_array($result)) {
	echo '<tr><td><center>' . $row['UID'] . '</cetner></td>';
	echo '<td><center>' . Get_STATUS_COLOUR($row['STATUS']) . '</cetner></td>';
	echo '<td><center>' . $row['MANAGEMC_VERSION'] . '</cetner></td>';
	echo '<td><center>NULL</cetner></td>';
	echo '<td><center>' . $row['IP'] . ' <span class="glyphicon glyphicon-signal"></span>'. Get_MS($row['UID']).'ms</cetner></td>';
	echo '<td><a href="server_management.php?page=ManageServer&uid=' . $row['UID'] . '" ><button class="btn btn-info"><span class="glyphicon glyphicon glyphicon-pencil"></span></button></a></td></tr>';
}
?>