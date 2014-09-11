<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');

function CORE_GetJSFiles() {
$myarray  = func_get_args();
$serialized = serialize($myarray); 
echo "<script src='/js/loadjs.php?scripts=" . $encoded = base64_encode($serialized) ."'></script>";
}

function CORE_Compress(){
global $config;

if($config['compress_enabled'] == 'TRUE')
{
$c = ini_get( 'zlib.output_compression' );
if(empty($c)){
ini_set( 'zlib.output_compression', '1' );
ini_set( 'zlib.output_compression_level', $config['compress_level'] );
}
}	
}
function CORE_bytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE) {
    $format = ($format === NULL) ? '%01.2f %s' : (string) $format;
    if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
    {
        $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
        $mod   = 1024;
    }
    else
    {
        $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
        $mod   = 1000;
    }
    if (($power = array_search((string) $force_unit, $units)) === FALSE)
    {
        $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
	}
    return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
}


//Function Time_Elapsed - This will calculate the time since a timestamp.
function CORE_Time_Elapsed($secs, $full){
$bit = array(
' year'        => $secs / 31556926 % 12,
' week'        => $secs / 604800 % 52,
' day'        => $secs / 86400 % 7,
' hour'        => $secs / 3600 % 24,
' minute'    => $secs / 60 % 60,
' second'    => $secs % 60
);
foreach($bit as $k => $v){
if($v > 1)$ret[] = $v . $k . 's';
if($v == 1)$ret[] = $v . $k;}
array_splice($ret, count($ret)-1, 0, 'and');
if ($full == 1)
{$ret[] = 'ago';}
$final = join(' ', $ret);
if (0 === strpos($final, 'and ')) {$final = str_replace("and ", "", $final);}
return $final;
}

//Function Check_Force_SSL - This function will check to see if $config['Force_SSL'] in /config.php is TURE and then enforce this if true
function CORE_Check_Force_SSL()
{
global $config;
if($config['Force_SSL'] == 'TRUE' && $config['Max_Login_Errors_Reset'] == 'TRUE') {
if(isset($_SERVER['HTTPS'])) {
if('on' == strtolower($_SERVER['HTTPS'])){return true;} //SSL is being used
if('1' == $_SERVER['HTTPS']){return true;} //SSL is being used
}
elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {return true;}
header('location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '');
return false;//SSL is not being used so redirect
}
if($config['Max_Login_Errors_Reset'] == 'TRUE') {
//Check that we are on the correct domain
if ($config['Max_Login_Errors_Reset'] == $_SERVER['HTTP_HOST']) {return true;}
else{header('location: http://' . $config['Max_Login_Errors_Reset'] . $_SERVER['REQUEST_URI'] . '');}
}
}

//Function Render_Sidebar - This function render the sidebar and add the class "active" is the page is in the sidebar
function CORE_Render_Sidebar()
{
$page = $_SERVER['REQUEST_URI'];
echo '
<! /START CORE_Render_Sidebar()/ ->
<div class="container-fluid" style="width:97.5%;">
<div class="col-md-2" style="padding-left:25px; background-color: #FFF;">
<ul class="nav nav-sidebar">
<h3>Dashboard</h3>';
if ($page == "/dashboard.php?page=Overview") {echo '<li class="active"><a href="/dashboard.php?page=Overview">';}
else {echo '<li><a href="/dashboard.php?page=Overview">';}
echo 'Overview</a></li>';
if ($page == "/dashboard.php?page=Activity") {echo '<li class="active"><a href="/dashboard.php?page=Activity">';}
else {echo '<li><a href="/dashboard.php?page=Activity">';}
echo 'Activity</a></li></ul>
<hr style="margin-top: -10px; margin-bottom: -10px;" />
<ul class="nav nav-sidebar">
<h3>Servers</h3>';
if ($page == "/server_management.php?page=AddServer") {echo '<li class="active"><a href="/server_management.php?page=AddServer">';}
else {echo '<li><a href="/server_management.php?page=AddServer">';}
echo 'Add Server</a></li>';
if ($_SERVER["SCRIPT_NAME"] == "/server_management.php" && $page !== "/server_management.php?page=AddServer" && $_SERVER['REQUEST_URI'] !== "/server_management.php") {echo '<li class="active"><a href="/server_management.php?page=ListServer">';}
else {echo '<li><a href="/server_management.php?page=ListServer">';}
echo 'Manage Servers</a></li></ul>
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
<! /END CORE_Render_Sidebar()/ ->
';  
}

//Function Render_Navbar - This function render the Navbar at the top right
function CORE_Render_Navbar()
{
global $ManageMC_Version;
echo '
<! /START CORE_Render_Navbar()/ ->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="http://managemc.com" style="padding-left:50px;">ManageMC</a><small class="navbar-brand" style="font-size: 14px;">'.$ManageMC_Version.'</small>
</div>
<div class="navbar-collapse collapse">
<ul class="nav navbar-nav navbar-right" style="padding-right:50px;">
<li><a href="/dashboard.php?page=Overview">Dashboard</a></li>
<li><a href="http://docs.managemc.com" target="new">Help</a></li>
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
<ul class="dropdown-menu">
<h4>Hi, ' . Username($_COOKIE['admin_session']) . '</h4>
<li class="divider"></li>
<h5><b>My Settings</b></h5>
<li><a href="/mysettings.php?page=passwd">Change Password</a></li>
<li class="divider"></li>
<h5><b>Global Settings</b></h5>
<li><a href="/settings.php">General</a></li>
<li class="divider"></li>
<li><a href="/logout.php">Logout</a></li>
</ul>
</li>
</ul>
</div>
</div>
</div>
<! /END CORE_Render_Navbar()/ ->
';
}

//Function Render_Top - This function render the head of the page
function CORE_Render_Top($name)
{

header('Connection: Keep-Alive');

echo '<! /START CORE_Render_Top()/ ->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/img.png">
    <title>'.$name.' - ManageMC</title>
    <link href="/css/loadcss.php" rel="stylesheet">
</head>
<body>
<! /END CORE_Render_Top()/ ->
';
}

//Function Render_Top - This function render the fotter of the page, should include jquery.
function CORE_Render_Footer()
{
global $config;
echo '</div><!-- /container -->
</body>
</html>';
if($config['jQuery_cdn'] == 'NONE'){echo'<script src="js/jquery.min.js"></script>';}
elseif($config['jQuery_cdn'] == 'GOOGLE'){echo'<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>';}
elseif($config['jQuery_cdn'] == 'MICROSOFT'){echo'<script src="//ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.min.js"></script>';}
elseif($config['jQuery_cdn'] == 'CLOUDFLARE'){echo'<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>';}
else{echo'<script src="js/jquery.min.js"></script>';}
echo '<script>// Fallback to loading jQuery from a local path if the CDN is unavailable(window.jQuery || document.write(\'<script src="/scripts/jquery-1.9.0.min.js"><\/script>\'));  </script>;';

if($config['jQuery_cdn'] == 'NONE'){echo'<script src="js/bootstrap.js"></script>';}
elseif($config['jQuery_cdn'] == 'CLOUDFLARE'){echo'<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>';}
elseif($config['jQuery_cdn'] == 'MAXCDN'){echo'<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>';}
else{echo'<script src="js/bootstrap.js"></script>';}
echo '<script>// Fallback to loading bootstrap from a local path if the CDN is unavailable(window.jQuery || document.write(\'<script src="/scripts/jquery-1.9.0.min.js"><\/script>\'));  </script>;';
}
?>