<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
CORE_Check_Force_SSL();
Check_Login();
Force_Admin();
CORE_Compress();
CORE_Render_Top("Dashboard");
CORE_Render_Navbar();
CORE_Render_Sidebar();
if (isset($_GET['page'])&&!empty($_GET['page'])){$page = $_GET['page'];
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
<div class="panel-heading">Activity Log</div>
<div class="panel-body">
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
</div><!-- /row -->
<div class="row">
<div class="col-md-4">
<div class="panel panel-danger">
<div class="panel-heading"><center>ManageMC News</center></div>
<div class="panel-body"><span id="managemc_news"><center><img src="images/712.GIF" width="32" height="32"></center></span></div>
</div>
</div>
<div class="col-md-8">
<div class="panel panel-success">
<div class="panel-heading"><center>Players</center></div>
<div class="panel-body"><center><img src="images/712.GIF" width="32" height="32"></center></div>
</div>
</div>
</div><!-- /row -->
<?php
CORE_Render_Footer();
?>
<script type="text/javascript" src="/js/dashboard.js"></script>
<?php } if ($page == "Activity") {?>
<style>
ul.pagination {
margin: -20px;
}
input.form-control.input-sm {
position: absolute;
width: 400px;
margin-left: 14px;
}
</style>
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
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>UID</th>
			<th>TimeStamp</th>
			<th>IP</th>
			<th>User</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
</table>
</div>
</div> <!-- End Panel -->
<?php
CORE_Render_Footer();
?>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<script>
$(document).ready(function() {
    $('#example').dataTable( {
	"oLanguage": {
         "sProcessing": ""
       },
	"bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "ajax": "worker.php"
    } );
} );
</script>
<?php 
 }
 
}?>