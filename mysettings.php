<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
Check_Force_SSL();
Check_Login();
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

    <title>Dashboard - ManageMC</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="/css/signin.css" rel="stylesheet">
    
  </head>

  <body>

    <div class="container">



<?php
Render_Navbar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == "passwd") {
        echo '<div class="container-fluid">';
        Render_Sidebar();
?>
        <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure?</h2>
      </div>
      <div class="modal-body">
        <p>This will remove all the data form the activity log table.<br /><b>This is acction is not reversable without a database backup!</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-danger" data-dismiss="modal" id="clear_activity_log_confirm">OK</button>
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Cancel</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="alert alert-warning" style="display:none;" id="clear_activity_log_stage_1">
  <strong>Working!</strong> Currently processing your request.<img src="images/712.GIF" width="16" height="16" style="float:right;">
</div>

        <div class="alert alert-success" style="display:none;" id="clear_activity_log_stage_2">
  <strong>Done!</strong> You request has finished.<span class="glyphicon glyphicon-ok" style="float:right;"></span>
</div>
        <div class="panel panel-primary">

          <div class="panel-heading"><h3>Change Your Password</h3><!--<button class="btn btn-danger btn-lg pull-right" data-toggle="modal" data-target="#myModal" style="margin-top: -45px;"><span class="glyphicon glyphicon-trash"></span> Clear Log</button>--></div>
          <div class="panel-body">
          <p>So you want to change your password?<br />Complete the form below and you password will change.<br />This will change your password for your authentication to ManageMC, this includes API requests.</p><br />
          <div class="alert alert-warning">
  		  <strong>Warning!</strong> This will log you out!<span class="glyphicon glyphicon-warning-sign" style="float:right;"></span>
          </div>
          
         <center><div class="jumbotron" style="background-color:white; width:450px;">
      <form class="form-signin"id="passwd">
          <input id="Password" name="Password" type="password" class="form-control" placeholder="Current Password" required>
          <input id="Password" name="Password" type="password" class="form-control" placeholder="New Password" required>
          <input id="Password" name="Password" type="password" class="form-control" placeholder="Repeat NewPassword" required>
        <!--<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Change</button>
      </form>
		</div></center>

          
          
			</div> <!-- End Panel -->
          </div>
        </div>
      </div>
    </div>

    </div> <!-- /container -->

  </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<script>
$(document).ready(function() {
	$('#clear_activity_log_confirm').click(function(e){
	$('#clear_activity_log_stage_1').toggle();
		
    $.ajax({
       type: "GET",
       url: '/api/get/dashboad.php?cmd=activity_log_clear',
       data: $(this).serialize(),
       success: function(data)
       {
		   $('#clear_activity_log_stage_1').toggle();
		   
		  $('#loaderImage').toggle();
          if (data == 'done') {
			  $('#clear_activity_log_stage_2').toggle();
			  $.ajax({
       type: "GET",
       url: '/api/get/dashboad.php?cmd=activity_log&limit=100',
       data: $(this).serialize(),
       success: function(data)
       {
		  $('#loaderImage').toggle();
          if (data) {
            $('#Activity_Table').html(data);
          }
          else {
			  $('#Activity_Table').html('Error Loading Data');
          }
       }
	   
	   
   });
			  setTimeout(close_alert, 5000);
          }
          else {
			 
          }
       }
	   
	   
   });
   });
   function close_alert()
   {
   
   $('#clear_activity_log_stage_2').toggle();
   }
    $.ajax({
       type: "GET",
       url: '/api/get/dashboad.php?cmd=activity_log&limit=100',
       data: $(this).serialize(),
       success: function(data)
       {
		  $('#loaderImage').toggle();
          if (data) {
            $('#Activity_Table').html(data);
          }
          else {
			  $('#Activity_Table').html('Error Loading Data');
          }
       }
	   
	   
   });
   

   
});</script>
        
        
        <?php
        exit; //Finish page 'passwd'
    }
}
?>

    <div class="container-fluid">
      <?php
Render_Sidebar();
?>
              <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="panel panel-primary">
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <h1 id="server_online"><center><img src="images/712.GIF" width="32" height="32"></center></h1>
              <h4>Server(s) Online</h4>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <h1 id="open_ticket"><center><img src="images/712.GIF" width="32" height="32"></center></h1>
              <h4>Open Ticket(s)</h4>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <h1 id="client"><center><img src="images/712.GIF" width="32" height="32"></center></h1>
              <h4>Client(s)</h4>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <h1 id="system_status"><center><img src="images/712.GIF" width="32" height="32"></center></h1>
              <h4>System Status</h4>
            </div>
          </div>
</div>
			<div class="panel panel-primary">

          <div class="panel-heading"><h3>Activity Log</h3></div>
          <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>#</center></th>
                  <th><center>Time</center></th>
                  <th><center>IP</center></th>
                  <th><center>User</center></th>
                  <th><center>Message</center></th>
                </tr>
              </thead>
              <tbody id="Activity_Table">
				<tr>
                <td><center><img src="images/712.GIF" width="32" height="32"></center></td>
                <td><center><img src="images/712.GIF" width="32" height="32"></center></td>
                <td><center><img src="images/712.GIF" width="32" height="32"></center></td>
                <td><center><img src="images/712.GIF" width="32" height="32"></center></td>
                <td><center><img src="images/712.GIF" width="32" height="32"></center></td>
                </tr>
                  
              </tbody>
            </table>
            </div>
			</div> <!-- End Panel -->
          
          
          </div>
        </div>
      </div>
    </div>

    </div> <!-- /container -->

  </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<script src="js/dashboard.js" ></script>