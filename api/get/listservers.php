<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM servers");
while ($row = mysqli_fetch_array($result)) {
	echo '<tr><td><center>' . $row['UID'] . '</cetner></td>';
	echo '<td><center>' . $row['IP'] . '</cetner></td>';
	echo '<td><cetner><a href="server_management.php?page=ManageServer&uid=' . $row['UID'] . '" ><button class="btn btn-info"><span class="glyphicon glyphicon glyphicon-pencil"></span> EDIT</button></a></cetner></td></tr>';
}
?>