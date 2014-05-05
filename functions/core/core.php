<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');

// /functions/core.php
// The core functions that allow managemc to function!

function RETURN_TIME()
{
    
    return time();
    
}


function Check_Force_SSL()
{
    global $Force_SSL, $ManageMC_Domain;
    if ($Force_SSL == TRUE) {
        if (isset($_SERVER['HTTPS'])) {
            if ('on' == strtolower($_SERVER['HTTPS']))
                return true; //SSL is being used
            if ('1' == $_SERVER['HTTPS'])
                return true; //SSL is being used
        } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        }
        header('location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '');
        return false;
    }
    //Check that we are on the correct domain
    if ($ManageMC_Domain == $_SERVER['HTTP_HOST']) {
        return true;
    } else {
        header('location: http://' . $ManageMC_Domain . $_SERVER['REQUEST_URI'] . '');
    }
    
}

function Render_Sidebar()
{
    $page = $_SERVER['REQUEST_URI'];
    echo '<div class="container-fluid" style="width:97.5%;">
      <div class="col-md-2" style="padding-left:25px; background-color: #FFF;">
          <ul class="nav nav-sidebar">
          	<h3>Dashboard</h3>
            ';
    if ($page == "/dashboard.php?page=Overview") {
        echo '<li class="active"><a href="/dashboard.php?page=Overview">';
    } else {
        echo '<li><a href="/dashboard.php?page=Overview">';
    }
    echo 'Overview</a></li>
			';
    if ($page == "/dashboard.php?page=Activity") {
        echo '<li class="active"><a href="/dashboard.php?page=Activity">';
    } else {
        echo '<li><a href="/dashboard.php?page=Activity">';
    }
    echo 'Activity</a></li>
          </ul>
          <hr style="margin-top: -10px; margin-bottom: -10px;" />
          <ul class="nav nav-sidebar">
          	<h3>Servers</h3>
			';
    if ($page == "/server_management.php?page=AddServer") {
        echo '<li class="active"><a href="/server_management.php?page=AddServer">';
    } else {
        echo '<li><a href="/server_management.php?page=AddServer">';
    }
    echo 'Add Server</a></li>
			';
    if ($_SERVER["SCRIPT_NAME"] == "/server_management.php" && $page !== "/server_management.php?page=AddServer") {
        echo '<li class="active"><a href="/server_management.php?page=ListServer">';
    } else {
        echo '<li><a href="/server_management.php?page=ListServer">';
    }
    echo 'Manage Servers</a></li>

          </ul>
		  <hr style="margin-top: -10px; margin-bottom: -10px;" />
          <ul class="nav nav-sidebar">
		    <h3>Clients</h3>
            <li><a href="">Add Client</a></li>
            <li><a href="">Manage Client</a></li>
          </ul>
		  <hr style="margin-top: -10px; margin-bottom: -10px;" />
          <ul class="nav nav-sidebar">
		    <h3>Staff</h3>
            <li><a href="">Add Staff</a></li>
            <li><a href="">Manage Staff</a></li>
          </ul>
        </div>
		
		
';
    
    
}

function Render_Navbar()
{
    echo '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://managemc.com" style="padding-left:50px;">ManageMC</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" style="padding-right:50px;">
                <li><a href="/dashboard.php?page=Overview">Dashboard</a>
                </li>
                <li><a href="http://docs.managemc.com" target="new">Help</a>
                </li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <h4>Hi, ' . Username($_COOKIE['admin_session']) . '</h4>
                        <li class="divider"></li>
                        <h5><b>My Settings</b></h5>
                        <li><a href="/mysettings.php?page=passwd">Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>';
}
function Render_Top($name)
{
    echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/img.png">
    <title>'.$name.' - ManageMC</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="/css/signin.css" rel="stylesheet">
</head>

<body>';
}

function Render_Footer()
{
    echo '</div><!-- /container -->
</body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>';
}
?>