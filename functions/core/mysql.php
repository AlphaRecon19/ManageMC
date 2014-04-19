<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function mysql_mysqli_connect()
{
    global $MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DB;
    // Create connection
    $con = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DB);
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        return $con;
    }
}
?>