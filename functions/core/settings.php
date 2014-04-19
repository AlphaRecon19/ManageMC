<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con = mysql_mysqli_connect();
function Settings_digitalocean_apikey()
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM settings WHERE Name='digitalocean_apikey'");
    $row    = mysqli_fetch_array($result);
    return $row['Value'];
}
function Settings_digitalocean_clientid()
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM settings WHERE Name='digitalocean_clientid'");
    $row    = mysqli_fetch_array($result);
    return $row['Value'];
}
function Settings_managemc_apikey()
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM settings WHERE Name='managemc_apikey'");
    $row    = mysqli_fetch_array($result);
    return $row['Value'];
}
?>