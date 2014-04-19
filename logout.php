<?php
	if (isset($_COOKIE['admin_session'])) {
        setcookie("admin_session", "null", time() - 60 * 60 * 24 * 365 * 10, "/");
		header('location: /login.php?logout=true&type=admin');
		exit;
        }
	if (isset($_COOKIE['client_session'])) {
        setcookie("client_session", "null", time() - 60 * 60 * 24 * 365 * 10, "/");
		header('location: /login.php?logout=true&type=client');
		exit;
        }
		else
		{
	header('location: /login.php?logout=true');
	exit;
		}
?>