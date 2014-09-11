<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
$con = mysql_mysqli_connect();
function Add_log_entry($message, $session)
{
    global $con, $username;
    if (isset($session)) {
		if($session == "System")
		{
			$username = "System";
		}
		else
		{
        $username = Username($session);
		}
    } else {
        $username = Username();
    }
    if ($username === 0) {
        $username = "unknown";
    }
    $result = mysqli_query($con, "INSERT INTO `activity_log` (`UID`, `TimeStamp`, `IP`, `User`, `Message`) VALUES (NULL, '" . time() . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $username . "', '" . $message . "');");
}
?>