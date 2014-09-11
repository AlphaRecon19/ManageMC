<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
 if (isset($_GET['type']) && $_GET['type'] == "retun" && isset($_GET['v'])) {
	 header('location: http://' . $config['Max_Login_Errors_Reset'] . base64_decode(base64_decode($_GET['v'])) . '');
	 exit;
 }
header('Content-Type: application/json');

include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
$con    = mysql_mysqli_connect();
$result = mysqli_query($con, "SELECT * FROM failed_logins WHERE IP='" . $_SERVER['REMOTE_ADDR'] . "' AND Timestamp >= '" . (time() - $config['Max_Login_Errors_Reset']) . "'");
time() - $config['Max_Login_Errors_Reset'];
$num_rows_failed_logins = mysqli_num_rows($result);
$failed_logins = $num_rows_failed_logins + 1;
if ($num_rows_failed_logins >= $config['Max_Login_Errors_Per_IP']) {
    Add_log_entry("The IP " . $_SERVER['REMOTE_ADDR'] . " tried to login but was blocked because of previous number of failed login attempts equal that of the value in the config.php file (" . $config['Max_Login_Errors_Per_IP'] . "", "");
   $server['data'] = 'loginblocked';
   echo json_encode($server);exit;	
} else {
    if (empty($_POST['Email']) or $_POST['Email'] == '') {
        $server['data'] = "Error 1 - Email Address Feild Empty!<br /><small>Attempt " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . "</small>";
        mysqli_query($con, "INSERT INTO `failed_logins` (`UID`, `IP`, `Attempt`, `Timestamp`) VALUES (NULL, '" . $_SERVER['REMOTE_ADDR'] . "', '" . ($failed_logins + 1) . "', '" . time() . "');");
        Add_log_entry("Failed Login (Error 1 - Email Address Feild Empty - " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . ")", "");
        echo json_encode($server);exit;		
    }
    if (empty($_POST['Password']) or $_POST['Password'] == '') {
        $server['data'] = "Error 2 - Password Feild Empty!<br /><small>Attempt " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . "</small>";
        mysqli_query($con, "INSERT INTO `failed_logins` (`UID`, `IP`, `Attempt`, `Timestamp`) VALUES (NULL, '" . $_SERVER['REMOTE_ADDR'] . "', '" . ($failed_logins + 1) . "', '" . time() . "');");
        Add_log_entry("Failed Login (Error 2 - Password Feild Empty - " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . ")", "");
        echo json_encode($server);exit;	
    }
    $Email    = $_POST['Email'];
    $Password = $_POST['Password'];
    if ($_GET['type'] == "client") {
        $file  = file_get_contents('http://api.alpha.managemc.com/minecraft.php?user=' . $Email . '&pass=' . $Password, true);
        $array = json_decode($file);
        $var   = get_object_vars($array);
        if (empty($file)) {
            $server['data'] = "Error 3 - Invalid Login<br /><small>Attempt " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . "</small>";
            Add_log_entry("Failed Login (Error 3 - Invalid Login - " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . ")", "");
            mysqli_query($con, "INSERT INTO `failed_logins` (`UID`, `IP`, `Attempt`, `Timestamp`) VALUES (NULL, '" . $_SERVER['REMOTE_ADDR'] . "', '" . ($failed_logins + 1) . "', '" . time() . "');");
			echo json_encode($server);exit;
        } else {
            $result   = mysqli_query($con, "SELECT * FROM client_users WHERE LoginUserName='$Email'");
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == 1) {
                $result = mysqli_query($con, "UPDATE client_users SET Session='" . $var['accessToken'] . "' WHERE LoginUserName='$Email'");
                setcookie("admin_session", "NULL", time() - 60 * 60 * 24 * 365 * 10, "/");
                setcookie("client_session", $var['accessToken'], time() + 60 * 60 * 24 * 365 * 10, "/");
                $server['data'] = 'Succsess';
                echo json_encode($server);exit;	
            } else {
                $server['data'] = "Error 4 - Client Not Valid<br /><small>We have no servers for you to manage.</small>";
                Add_log_entry("Failed Login (Error 4 - Client Not Valid - " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . ")", "");
                mysqli_query($con, "INSERT INTO `failed_logins` (`UID`, `IP`, `Attempt`, `Timestamp`) VALUES (NULL, '" . $_SERVER['REMOTE_ADDR'] . "', '" . ($failed_logins + 1) . "', '" . time() . "');");
				echo json_encode($server);exit;	
            }
        }
    } else {
        $result   = mysqli_query($con, "SELECT * FROM admin_users WHERE Username='$Email' AND MD5_Password='$Password'");
        $num_rows = mysqli_num_rows($result);
        $row      = mysqli_fetch_array($result);
        if ($num_rows == 1) {
            $newsession =
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999))))))) .
			base64_encode(md5(base64_encode((rand(1, rand(1, 9999999999) * rand(1, rand(1, 9999999999)))))));
            setcookie("admin_session", $newsession, time() + 60 * 60 * 24 * 365 * 10, "/");
            $result = mysqli_query($con, "UPDATE admin_users SET Session='$newsession' WHERE Username='$Email' AND MD5_Password='$Password'");
            $server['data'] = "succsess";
            Add_log_entry("Succsessful Login", $newsession);
			echo json_encode($server);exit;	
        } else {
            $server['data'] = "Error 3 - Invalid Login<br /><small>Attempt " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . "</small>";
            Add_log_entry("Failed Login (Error 3 - Invalid Login - " . $failed_logins . " out of " . $config['Max_Login_Errors_Per_IP'] . ")", "");
            mysqli_query($con, "INSERT INTO `failed_logins` (`UID`, `IP`, `Attempt`, `Timestamp`) VALUES (NULL, '" . $_SERVER['REMOTE_ADDR'] . "', '" . ($failed_logins + 1) . "', '" . time() . "');");
            echo json_encode($server);exit;	
        }
		$server['data'] = "Unknown Error(1)<br /><small>Please contact support with this error!</small>";
        echo json_encode($server);exit;	
    }
}
$server['data'] = "Unknown Error(1)<br /><small>Please contact support with this error!</small>";
echo json_encode($server);
exit;
?>