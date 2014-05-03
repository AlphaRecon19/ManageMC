<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
	if (isset($_COOKIE['admin_session'])) {
		Add_log_entry("Succsessful Logout");
        setcookie("admin_session", "null", time() - 60 * 60 * 24 * 365 * 10, "/");
		header('location: /login.php?logout=true&type=admin');
		exit;
        }
	if (isset($_COOKIE['client_session'])) {
		Add_log_entry("Succsessful Logout");
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