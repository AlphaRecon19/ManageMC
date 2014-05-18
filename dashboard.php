<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
Check_Force_SSL();
Check_Login();
Force_Admin();
Render_Top("Dashboard");
Render_Navbar();
Render_Sidebar();

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == "Overview") {
?>
<div class="row" style="padding-left:25px;">

    <div class="col-md-2">
        <div class="panel panel-success">
            <div class="panel-heading"><center>Servers</center></div>
            <div class="panel-body"><center><h1 id="servers"><img src="images/712.GIF" width="32" height="32"></h1></center></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-success">
            <div class="panel-heading"><center>Servers Online</center></div>
            <div class="panel-body"><center><h1 id="server_online"><img src="images/712.GIF" width="32" height="32"></h1></center></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-success">
            <div class="panel-heading"><center>Open Tickets</center></div>
            <div class="panel-body"><center><h1 id="open_ticket"><img src="images/712.GIF" width="32" height="32"></h1></center></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-success">
            <div class="panel-heading"><center>Clients</center></div>
            <div class="panel-body"><center><h1 id="client"><img src="images/712.GIF" width="32" height="32"></h1></center></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-success">
            <div class="panel-heading"><center>Players</center></div>
            <div class="panel-body"><center><h1 id="players"><img src="images/712.GIF" width="32" height="32"></h1></center></div>
        </div>
    </div>
    
    
    <div class="col-md-10">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">Activity Log</div>
            <div class="panel-body">
            </div>
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
    </div>

    <div class="col-md-12" style="margin-left: -12px;">
        <div class="panel panel-danger">
            <!-- Default panel contents -->
            <div class="panel-heading">Panel heading</div>
            <div class="panel-body">
                <p>Some default panel content here. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </div>

            <!-- Table --> <table class="table"> <thead> <tr> <th>#</th> <th>First Name</th> <th>Last Name</th> <th>Username</th> </tr> </thead> <tbody> <tr> <td>1</td> <td>Mark</td> <td>Otto</td> <td>@mdo</td> </tr> <tr> <td>2</td> <td>Jacob</td> <td>Thornton</td> <td>@fat</td> </tr> <tr> <td>3</td> <td>Larry</td> <td>the Bird</td> <td>@twitter</td> </tr> </tbody> </table>
        </div>

    </div><!-- /row -->
<?php
render_footer();
?>
<script type="text/javascript" src="/js/dashboard.js"></script>
<?php } if ($page == "Activity") {
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

<div class="col-md-10">
        <div class="alert alert-warning" style="display:none;" id="clear_activity_log_stage_1">
  <strong>Working!</strong> Currently processing your request.<img src="images/712.GIF" width="16" height="16" style="float:right;">
</div>

        <div class="alert alert-success" style="display:none;" id="clear_activity_log_stage_2">
  <strong>Done!</strong> You request has finished.<span class="glyphicon glyphicon-ok" style="float:right;"></span>
</div>
        <div class="panel panel-info">

          <div class="panel-heading"><h3>Activity Log</h3><button class="btn btn-danger btn-lg pull-right" data-toggle="modal" data-target="#myModal" style="margin-top: -45px;"><span class="glyphicon glyphicon-trash"></span> Clear Log</button></div>
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
    <?php
render_footer();
?>
<script>$(document).ready(function(){function e(){$("#clear_activity_log_stage_2").toggle()}$("#clear_activity_log_confirm").click(function(t){$("#clear_activity_log_stage_1").toggle();$.ajax({type:"GET",url:"/api/get/dashboad.php?cmd=activity_log_clear",data:$(this).serialize(),success:function(t){$("#clear_activity_log_stage_1").toggle();$("#loaderImage").toggle();if(t=="done"){$("#clear_activity_log_stage_2").toggle();$.ajax({type:"GET",url:"/api/get/dashboad.php?cmd=activity_log&limit=100",data:$(this).serialize(),success:function(e){$("#loaderImage").toggle();if(e){$("#Activity_Table").html(e)}else{$("#Activity_Table").html("Nothing Found!")}}});setTimeout(e,5e3)}else{}}})});$.ajax({type:"GET",url:"/api/get/dashboad.php?cmd=activity_log&limit=100",data:$(this).serialize(),success:function(e){$("#loaderImage").toggle();if(e){$("#Activity_Table").html(e)}else{$("#Activity_Table").html("Nothing Found!")}}})})</script>
<?php 
 }
 
}?>