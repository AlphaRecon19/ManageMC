<?php
//MYSQL Infomation
    $MYSQL_HOST = 'alpha.koolserve.co.uk';
    $MYSQL_USERNAME = 'managemc';
    $MYSQL_PASSWORD = 'managemc';
    $MYSQL_DB = 'managemc';
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
//Other
    date_default_timezone_set('Europe/London');
        $ManageMC_Version = "0.0.11a Pre-Alpha"; //Do not change this. It is used to check your installation is up to date
	$con   = mysql_mysqli_connect();
	$result = mysqli_query($con, "SELECT * FROM settings");
        $config = array();
	while($row = mysqli_fetch_assoc($result))
	{
            $settings[$row['Name']] = $row;
	}foreach($settings as $key => $value){
            $config[$key] = $value['Value'];
    }
        //process managemc_debug_renderconfigvariables config
        if(($config['managemc_debug_renderconfigvariables'] == 'TRUE') && (Check_Login_Value() == 1)){
	echo '<pre>managemc_debug_renderconfigvariables{
	';
	var_dump($config);
	echo '}</pre>';
        }
        
        //process managemc_debug_error_reporting config
        if($config['managemc_debug_error_reporting'] == 0){
        error_reporting(0);
        }elseif($config['managemc_debug_error_reporting'] == 1){
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        }elseif($config['managemc_debug_error_reporting'] == 2){
        error_reporting(-1);
        }else{
            echo '<!-- managemc_debug_error_reporting not set! -->';
            error_reporting(0);
        }
?>
