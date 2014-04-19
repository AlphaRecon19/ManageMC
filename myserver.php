<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
Check_Force_SSL();
Check_Login();
Force_Client();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/img.png">

    <title>Server Management - ManageMC</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="/css/signin.css" rel="stylesheet">
    
    <style>
	.tableleft {
		float:left;
	}
	.tableright {
		float:right;
	}
</style>
    
    
  </head>

  <body>

    <div class="container">



<?php
Render_Navbar();
echo '<div class="container-fluid">';
Render_Sidebar();
?>
        <!-- Modal -->
<div class="modal fade" id="landing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span> Add Server</h2>
      </div>
      <span id="message" style="display:none;" /><div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> <span id="message_cont"> </span>
</div></span>
      <div class="modal-body" style="width:300px; margin-left: auto ;  margin-right: auto ;"><center>
      
      <form id="add_server_check" action="/api/post/add_server_check.php" method="post">
		<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span><span style="padding-left:35px;">IP:</span></span>
 			<input type="text" class="form-control" style="height:45px;" id="ip" name="ip" required autocomplete="off" autofocus>
		</div>	
        
        <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span> ROOT<br />Password:</span>
 			<input type="text" class="form-control" style="height:45px;" id="password" name="password"  required autocomplete="off">
		</div>
        <center><img src="images/712.GIF" id="locadinggif" width="32" height="32" style="margin-top:15px; display:none;"></center>
        </center>
      </div>
      
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="add_server_check_go" name="add_server_check_go">GO</button>
        <a href="/dashboard.php?page=Overview"><button type="button" class="btn btn-default btn-danger">Cancel</button></a>
        </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Modal -->
<div class="modal fade" id="installing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span>Step <span id="stage_num">1</span> of 8</h2></div>
      <div class="modal-body" style="width:400px; margin-left: auto;  margin-right: auto ;"><center>
      <p>ManageMC will now begin to install itself on the server.<br />This can take up to 3 minutes.</p>
      <p>Current Task: <span id="task">Updating System</span></p>
      
		</div>
        
      </div></center>
      
      
      <!--<div class="modal-footer">

        </div>-->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        

    </div> <!-- /container -->

  </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>    