<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');

if (isset($_GET['uid']) && !empty($_GET['uid'])) {
    $uid = $_GET['uid'];
}
if (isset($_GET['filepath']) && !empty($_GET['filepath'])) {
    $filepath = $_GET['filepath'];
}
$file = Get_Path($uid,$filepath);
$lines = file($file);
while(empty($lines))
{
sleep (1);
$lines = file($file);
}
Check_Force_SSL();
Check_Login();
Render_Top("Settings");
Render_Navbar();
Render_Sidebar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
}
else
{
$page = "Edit";	
}
    if ($page == "Edit") {
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
<?php
render_footer();
?>
<script type="text/javascript" src="/lib/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "code",
        "paste"
    ],
    toolbar: "undo redo"
});

$(document).ready(function () {
    	$('#form_editfile').submit(function(e) {
		event.preventDefault();
        $("#activity_icon").toggle();
		$.ajax({
        type: "POST",
        dataType: "json",
        url: "/api/post/filesave.php?<?php echo "Server_UID=" . $_GET["uid"] . "&File_Path=" . $_GET["filepath"]; ?>",
		data: $(this).serialize(),
        success: function (e) {
			$("#activity_icon").toggle();
            alert("done");
			console.log(e);
        }
    			});
		
    })
})

</script>
<?php }?>
