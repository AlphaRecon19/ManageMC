<?php
Check_Force_SSL();
Check_Login();
Force_Admin();
include_once ($_SERVER['DOCUMENT_ROOT'].'/functions/core/settings.php');

echo "<br />Settings_digitalocean_apikey=";
echo Settings_digitalocean_apikey();
echo "<br />Settings_digitalocean_client=";
echo Settings_digitalocean_clientid();
echo "<br />Settings_managemc_apikey=";
echo Settings_managemc_apikey();

?>