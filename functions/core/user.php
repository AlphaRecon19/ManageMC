<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con = mysql_mysqli_connect();
function Check_Login()
{
    global $con;
    if (isset($_COOKIE['admin_session']) && !empty($_COOKIE['admin_session'])) {
        if (Check_Login_Value() == 1) {
			return 1;
        } else {
        header('location: /login.php?session=true&type=admin&return='.base64_encode(base64_encode($_SERVER['REQUEST_URI'])));
        exit;
        }
    }
    if (isset($_COOKIE['client_session']) && !empty($_COOKIE['client_session'])) {
        if (Check_Login_Value() == 1) {
			return 1;
        } else {
        header('location: /login.php?session=true&type=client&return='.base64_encode(base64_encode($_SERVER['REQUEST_URI'])));
        exit;
        }
    } else {
        return 0;
        header('location: /login.php?session=true');
        exit;
    }
}
function Check_Login_Value()
{
    global $con;
    if (isset($_COOKIE['admin_session']) && !empty($_COOKIE['admin_session'])) {
        $cookie_session = $_COOKIE['admin_session'];
        $result         = mysqli_query($con, "SELECT * FROM admin_users WHERE session='$cookie_session'");
        $num_rows       = mysqli_num_rows($result);
        if ($num_rows == 1) {
            return 1;
        } else {
            return 0;
        }
    }
    elseif (isset($_COOKIE['client_session']) && !empty($_COOKIE['client_session'])) {
        $cookie_session = $_COOKIE['client_session'];
        $result         = mysqli_query($con, "SELECT * FROM client_users WHERE Session='$cookie_session'");
        $num_rows       = mysqli_num_rows($result);
        if ($num_rows == 1) {
            return 1;
        } else {
            return 0;
        }
    }
	else{
		return 0;
	}
}
function Force_Client()
{
    if (isset($_COOKIE['admin_session']) && !isset($_COOKIE['client_session'])) {
        header('location: /dashboard.php?force_client=true&page=Overview');
    } else {
    }
}
function Force_Admin()
{
    if (isset($_COOKIE['client_session']) && !isset($_COOKIE['admin_session'])) {
        header('location: /myserver.php?force_admin=true');
    } else {
    }
}
function Username($session)
{
	global $con;
	if (isset($session)) {
        $cookie_session = $session;
        $result         = mysqli_query($con, "SELECT * FROM admin_users WHERE session='$cookie_session'");
        $num_rows       = mysqli_num_rows($result);
        if ($num_rows == 1) {
            while ($row = mysqli_fetch_array($result)) {
                return $row['Username'];
            }
        } else {
            return 0;
        }
    }
    elseif (isset($_COOKIE['admin_session']) && !empty($_COOKIE['admin_session'])) {
        $cookie_session = $_COOKIE['admin_session'];
        $result         = mysqli_query($con, "SELECT * FROM admin_users WHERE session='$cookie_session'");
        $num_rows       = mysqli_num_rows($result);
        if ($num_rows == 1) {
            while ($row = mysqli_fetch_array($result)) {
                return $row['Username'];
            }
        } else {
            header('location: /login.php?session=true&type=admin&return='.base64_encode(base64_encode($_SERVER['REQUEST_URI'])));
        }
    }
    elseif (isset($_COOKIE['client_session']) && !empty($_COOKIE['client_session'])) {
        $cookie_session = $_COOKIE['client_session'];
        $result         = mysqli_query($con, "SELECT * FROM client_users WHERE Session='$cookie_session'");
        $num_rows       = mysqli_num_rows($result);
        if ($num_rows == 1) {
            while ($row = mysqli_fetch_array($result)) {
                return $row['Username'];
            }
        } else {
            header('location: /login.php?session=true&type=client&return='.base64_encode(base64_encode($_SERVER['REQUEST_URI'])));
        }
    }
	else {
        header('location: /login.php?session=true&return='.base64_encode(base64_encode($_SERVER['REQUEST_URI'])));
        exit;
    }
}
?>