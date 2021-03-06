<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
CORE_Compress();
CORE_Check_Force_SSL();
if (Check_Login_Value() == 1) {
	Add_log_entry("Auto Login");
    header('location: /dashboard.php?page=Overview');
}
if (!isset($_GET['type'])) {
    $type = "client";
} else {
    $type = $_GET['type'];
}
CORE_Render_Top("Login");
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Login error</h4>
      </div>
      <div class="modal-body">
        <h3><div id="error_code" ></div></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <div class="container">
    <center>
    <?php
if (isset($_GET['session']) && $_GET['session'] == 'true') {
    echo '<div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> Your session has ended, please login again.
</div>';
}
?><div class="alert alert-success" style="max-width:600px; min-width:450px; display:none;" id="welcome_back">
  <strong>Welcome Back!</strong> Redirecting to dashboard.
</div>
    
		<div class="jumbotron" style="background-color:white; width:450px;">
      <form class="form-signin"id="form-signin">
        <h2 class="form-signin-heading">
        <?php
if (isset($_GET['type']) && $_GET['type'] == 'admin') {
    echo 'Admin - ';
} else {
    echo 'Client -';
}
?> ManageMC Login</h2>
        <input id="Email" name="Email" type="text" class="form-control" placeholder="<?php
if (isset($_GET['type']) && $_GET['type'] == 'admin') {
    echo 'Username';
} else {
    echo 'Minecraft Username';
}
?>" required autofocus>
        <input id="Password" name="Password" type="password" class="form-control" placeholder="Password" required>
        <!--<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login in</button></form>
        <br />
        
        <?php
if (isset($_GET['type']) && $_GET['type'] == 'admin') {
    echo '<a href="?type=client';if (isset($_GET['return'])) {echo '&return='.$_GET['return'];}echo'" style="text-decoration:  none;"><button class="btn btn-lg btn-info btn-block">Client Login</button></a>';
} else {
    echo '<a href="?type=admin';if (isset($_GET['return'])) {echo '&return='.$_GET['return'];}echo'" style="text-decoration:  none;"><button class="btn btn-lg btn-danger btn-block">Admin Login</button></a>';
}
?>
        
        
        <center><div id="loaderImage" style="display:none;"><img src="images/712.GIF" width="32" height="32"></center></div>
        </center>
      
		</div></center>
        
    </div> <!-- /container -->
<?php
CORE_Render_Footer();
?>
<script>
$(document).ready(function() {
  $('#form-signin').submit(function(e) {
	  
	 $('#session_message').toggle();
	 $('#loaderImage').toggle();
	e.preventDefault();
    e.stopPropagation();
	
    $.ajax({
       type: "POST",
	   
		<?php
if ($type !== "admin") {
    echo "url: '/api/post/login.php?type=client',";
} else {
    echo "url: '/api/post/login.php?type=admin',";
}
?>

       data: $(this).serialize(),
       success: function(data)
       {
		   
          if (data.data == 'succsess') {
			$('#welcome_back').toggle();
			<?php
			if(!isset($_GET['return']))
			{
if ($type !== "admin") {
    echo "window.location = '/myserver.php';";
} else {
    echo "window.location = '/dashboard.php?page=Overview';";
}
			}
			else {
    echo "window.location = '/api/post/login.php?type=retun&v=".$_GET['return']."';";
}
?>
            
          }
		  
          else {
			  if (data.data == 'loginblocked') {
            window.location = '/ipbanned.php?type=loginblocked';
          }
			  $('#loaderImage').toggle();
			  $('#error_code').html(data.data);
			  $('#myModal').modal('show');
          }
       }
   });
 });
});
$(document).keydown(function(e) {
          if (e.keyCode == '13') {
            $('#myModal').modal('hide');
			document.getElementById('Password').focus()
		  }
        });

</script>