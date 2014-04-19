<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM servers");
while ($row = mysqli_fetch_array($result)) {
	echo '<tr><td>' . $row['UID'] . '</td>';
	echo '<td>' . $row['IP'] . '</td>';
	echo '<td>NULL</td>';
	echo '<td><a href="server_management.php?page=ManageServer&uid=' . $row['UID'] . '" ><button class="btn btn-info"><span class="glyphicon glyphicon glyphicon-pencil"></span> EDIT</button></a></td></tr>';
}
?>