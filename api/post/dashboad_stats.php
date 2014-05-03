<?php
/*

API - dashboad_stats.php

Type : POST
URL : /api/post/dashboad_stats.php
Responce: {"server_online":(l33),"open_ticket":(l34),"client":(l35),"system_status":"(l36)"}


*/
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
$con = mysql_mysqli_connect();
if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch ($action) { //Switch case for value of action
            case "status":
                status();
                break;
        }
    }
}
//Function to check if the request is an AJAX request
function is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function status()
{
    global $con;
    //$return = $_POST;
    $resulta                 = mysqli_query($con, "SELECT * FROM servers WHERE STATUS='ONLINE'");
    $num_rowsa               = mysqli_num_rows($resulta);
    $return["server_online"] = $num_rowsa;
    $return["open_ticket"]   = rand(23, 73);
    $return["client"]        = rand(3, 433);
	$return["players"]        = rand(0, 1000);
    $result                  = mysqli_query($con, "SELECT * FROM servers");
    $num_rows                = mysqli_num_rows($result);
    $return["servers"]       = $num_rows;
    echo json_encode($return);
}
?>