<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con   = mysql_mysqli_connect();
$data = $_POST;

foreach($data as $key => $value){
	
	$result = mysqli_query($con, "SELECT * FROM settings WHERE Name='".$key."'");
		if (mysqli_num_rows($result) == 1){
			mysqli_query($con, "UPDATE settings SET Value='$value' WHERE Name='".$key."'");
		}else{
			mysqli_query($con,"DELETE FROM settings WHERE Name='".$key."'");
			mysqli_query($con,"INSERT INTO settings (UID, Name, Value) VALUES ('', '".$key."', '".$value."')");
	}
}
exit;
?>

