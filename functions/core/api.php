<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');

function API_Secure() {
if(Check_Login_Value() === 0)
{
$data['API_Secure()'] =  '0. Please login or use a api key';
header('Content-Type:text/json');
echo json_encode($data);
exit;
}
else
{
return 1;	
}
}
?>