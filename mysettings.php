<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
CORE_Check_Force_SSL();
Check_Login();
CORE_Render_Top("Settings");
CORE_Render_Navbar();
CORE_Render_Sidebar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
}
else
{
$page = "home";	
}
    if ($page == "passwd") {
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
<div class="row" style="padding-left:25px;">   
    
    <div class="col-md-7 col-md-offset-2">
        <div class="panel panel-info">
            <!-- Default panel contents -->
             <div class="panel-heading"><h3>Change Your Password</h3></div>
          <div class="panel-body">
          <p>So you want to change your password? Complete the form below and you password will change. This will change your password for your authentication to ManageMC, this includes API requests.</p>
          <div class="alert alert-warning">
  		  <strong>Warning!</strong> This will log you out!<span class="glyphicon glyphicon-warning-sign" style="float:right;"></span>
          </div>
          
         <center>
      <form class="form-signin"id="passwd">
          <input id="CPassword" name="CPassword" type="password" class="form-control" placeholder="Current Password" required>
          <input id="NPassword" name="NPassword" type="password" class="form-control" placeholder="New Password" required>
          <input id="NRPassword" name="NRPassword" type="password" class="form-control" placeholder="Repeat New Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Change</button>
      </form></center>
            <center><img src="images/712.GIF" width="32" height="32" id="activity_icon" style="display:none;"></center>
            </div>
        </div>
    </div>
    </div><!-- /row -->
<?php
CORE_Render_Footer();
?>
<?php }?>
