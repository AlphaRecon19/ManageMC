<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
Check_Force_SSL();
Check_Login();
Force_Admin();
Render_Top("Server Management");
Render_Navbar();
Render_Sidebar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
	
	if ($page == "ManageServer") {
?>
<div class="row" style="padding-left:25px;">

    <div class="col-md-5" style="height: 580px;">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h3>Live Server Load</h3>
            </div>
            <div class="panel-body">
                <center>
                    <div style="color:#EEE;background:#222;width:320px;/* padding:20px; */border-radius:15px;text-align: center;">

                        <div id="knobinner" style="position:relative;width:350px;margin:auto;float:left; display:none;">
                            <div style="position:absolute;left:10px;top:10px">
                                <input class="knob load0" data-bgcolor="#333"
                                data-displayinput="false"
                                data-fgcolor="#ffec03"
                                data-height="300"
                                data-max="100"
                                data-min="0"
                                data-thickness=".3"
                                data-width="300">
                            </div>
                            <div style="position:absolute;left:60px;top:60px;">
                                <input class="knob load1" data-bgcolor="#333"
                                data-displayinput="false"
                                data-height="200"
                                data-max="100"
                                data-min="0"
                                data-thickness=".45"
                                data-width="200"
                                id="datalol1">
                            </div>
                            <div style="position:absolute;left:110px;top:110px">
                                <input class="knob load2" data-bgcolor="#333"
                                data-displayinput="false"
                                data-fgcolor="rgb(127, 255, 0)"
                                data-height="100"
                                data-max="100"
                                data-min="0"
                                data-thickness=".7"
                                data-width="100">
                            </div>
                        </div>

                        <div id="newa" style="overflow:hidden;float:right;width:300px;height:310px;">
                        </div>
                        <center id="knobtext" style="position:relative;bottom:0;padding-top:350px;margin:auto;color:#222;overflow:none; display:none;">
                            <p>
                                <span style="color:#EEE;">Load avg: </span>
                                <span
                                style="background-color:#ffec03">1 min:
                                    <span
                                    id="load0"></span>
                                        </span>
                                        <span
                                        style="background-color:#87CEEB">5
                                            min:
                                            <span
                                            id="load1"></span>
                                                </span>
                                                <span
                                                style="background-color:rgb(127, 255, 0);">15
                                                    min:
                                                    <span
                                                    id="load2"></span>
                                                        </span>
                            </p>
                        </center>
                        <div style="clear:both"></div>
                        <br />
                    </div>

                </center>
            </div>

        </div>
        <!-- End Panel -->
    </div>


    <div class="col-md-5">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h3>Server INFO</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table tableright table-striped">
                        <tbody>
                            <tr>
                                <td>
                                    <center><b>STATUS</b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <span
                                        id="STATUS_Table">
                                            <img
                                            src="images/712.GIF"
                                            width="32"
                                            height="32">
                                                </span>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><b>IP</b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <span
                                        id="IP_Table">
                                            <img
                                            src="images/712.GIF"
                                            width="32"
                                            height="32">
                                                </span>
                                                <span
                                                class="glyphicon glyphicon-signal"></span>
                                                    <span
                                                    id="ms_Table">
                                                        <img
                                                        src="images/712.GIF"
                                                        width="32"
                                                        height="32">
                                                            </span>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><b>Disk space</b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <div
                                        class="progress">
                                            <div
                                            class="progress-bar"
                                            role="progressbar"
                                            id="diskspaceb"
                                            style="width: 0%;">
                                                <b><span id="diskspacevalue"></span></b>
                </div>
            </div>
            </center>
            <center><span id="diskused"></span> of
                <span
                id="disktotal"></span>
            </center>
            </td>
            </tr>
            <tr>
                                <td>
                                    <center><b>World Size</b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <span
                                        id="STATUS_WorldSize">
                                            <img
                                            src="images/712.GIF"
                                            width="32"
                                            height="32">
                                                </span>
                                    </center>
                                </td>
                            </tr>

            </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Panel -->
</div>

<div class="col-md-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3>Command Center</div>
          <div class="panel-body">
          <div class="alert alert-danger" id="NewWarning" style="display:none;">
  		  <strong>Warning!:</strong> This server still needs to be assigned to a client. Here is the <button class="btn btn-warning"><span class="glyphicon glyphicon-user"></span> Claim URL</button>
          </div>          
          <button id="control_start" class="btn btn-success" disabled="disabled"><span class="glyphicon glyphicon-play"></span> Start</button>
<button id="control_stop" class="btn btn-danger" disabled="disabled"><i class="glyphicon glyphicon-stop"></i> Stop</button>
<button id="control_restart" class="btn btn-info" disabled="disabled"><i class="glyphicon glyphicon-refresh"></i> Restart</button>
<button id="control_reboot" class="btn btn-danger" disabled="disabled"><i class="glyphicon glyphicon-refresh"></i> Reboot</button>
<a href="?page=DeleteServer&uid=<?php echo $_GET['uid']; ?>"><button id="control_delete" class="btn btn-danger" disabled="disabled"><i class="glyphicon glyphicon-trash"></i> Delete</button></a><img src="/images/712.GIF" width="32" height="32" style="margin: 0; position: relative; float: right; display:none;" id="loading">
Show Log: <input type="checkbox" class="js-switch" id="toggle_log" checked />
Auto Refresh: <input type="checkbox" class="js-switch" id="auto_refresh" />
Curently: <span id="status"></span><span><img src="/images/712.GIF" width="32" height="32" style="margin: 0; display:none;" id="status_img"> <button id="control_refresh" class="btn" disabled="disabled"><i class="glyphicon glyphicon-refresh"></i></button></span>
<div id="last_rersault" style="background-color: #696969; color: #0F0; width: 100%; max-height: 330px; margin-top: 10px; font-weight: 500; padding: 5px; border-radius: 5px; overflow: scroll; overflow-x: auto;"></div>
        </div>
		</div><!-- End Panel -->
		</div><!-- End col-md-12 -->
		<div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading"><h3>Ram Free in the last 15 mins</div>
          <div class="panel-body">        
          
          <center><div class="content">
			<div class="pane">
				<div id="chartContainer" class="case-container" style="width: 90%; height: 440px;"></div>
			</div>
            </div></center>
            
			</div>
		</div><!-- End Panel -->
		</div><!-- End col-md-6 -->
		
		<div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading"><h3>MS in the last 15 mins</div>
          <div class="panel-body">        
          
          <center><div class="content">
			<div class="pane">
				<div id="chartContainerMS" class="case-container" style="width: 90%; height: 440px;"></div>
			</div>
            </div></center>
            
			</div>
		</div><!-- End Panel -->
		</div><!-- End col-md-6 -->
		
		<div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading"><h3>Server Load in the last 15 mins</div>
          <div class="panel-body">        
          
          <center><div class="content">
			<div class="pane">
				<div id="chartContainerLOAD" class="case-container" style="width: 90%; height: 440px;"></div>
			</div>
            </div></center>
            
			</div>
		</div><!-- End Panel -->
		</div><!-- End col-md-6 -->
		
		<div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading"><h3>server.properties</h3>
            <a href="/editfile.php?uid=<?php echo $_GET['uid']; ?>&filepath=/home/minecraft/minecraft/server.properties"><button class="btn btn-info btn-lg pull-right"
            style="margin-top: -45px;"><span class="glyphicon glyphicon glyphicon-pencil"></span> EDIT</button></a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                Null
            </div>
        </div>
    </div>
    <!-- End Panel -->
</div>
<!-- End col-md-6 -->

</div>
<!-- /row -->

      
        
        <?php
render_footer();
		?>
<script src='lib/switchery/switchery.min.js'></script>
<script src="js/globalize.min.js"></script>
<script src="js/dx.chartjs.js"></script>
<script src="js/knob.js"></script>
<script src="js/server_management_ManageServer.php?uid=<?php echo $_GET['uid']; ?>" ></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=load"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=ms"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=free"></script>
		<?php
		exit;
		}
	
	
    if ($page == "ListServer") {
?>
<div class="row" style="padding-left:25px;">

    <div class="col-md-10">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h3>Server List</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <center>UID</center>
                                </th>
                                <th>
                                    <center>IP</center>
                                </th>
                                <th>
                                    <center>Edit</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="listservers">
                            <tr>
                                <td>
                                    <center>
                                        <img src="images/712.GIF" width="32" height="32">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <img src="images/712.GIF" width="32" height="32">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <img src="images/712.GIF" width="32" height="32">
                                    </center>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Panel -->
        </div>

    </div>
    <!-- /row -->
<?php
render_footer();
?><script>
$(document).ready(function(){$.ajax({type:"GET",url:"/api/get/listservers.php",data:$(this).serialize(),success:function(e){$("#loaderImage").toggle();if(e){$("#listservers").html(e)}else{$("#listservers").html('<center>We found no servres in the database. Why not add one <a href="server_management.php?page=AddServer">here</a></center>')}}})})</script><?php
}//End of ListServers
if ($page == "AddServer") {
?>
<!-- Modal -->
<div class="modal fade" id="landing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="myModalLabel">
				<span class="glyphicon glyphicon glyphicon-plus">
				</span>
				Add Server</h2>
			</div>
			<span id="message" style="display:none;"/>
			<div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
				&times; </button>
				<strong>
				Warning! </strong>
				<span id="message_cont">
				</span>
			</div>
			</span>
			<div class="modal-body" style="width:300px; margin-left: auto ; margin-right: auto ;">
				<center>
				<form id="add_server_check" action="/api/post/add_server_check.php" method="post">
					<div class="input-group">
						<span class="input-group-addon">
						<span class="glyphicon glyphicon-hdd">
						</span>
						<span style="padding-left:35px;">
						IP: </span>
						</span>
						<input type="text" class="form-control" style="height:45px;" id="ip" name="ip" required autocomplete="off" autofocus>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="width: 94px;">
						<span class="glyphicon glyphicon-asterisk">
						</span>
						ROOT <br/>
						Password: </span>
						<input type="text" class="form-control" style="height:45px;" id="password" name="password" required autocomplete="off">
					</div>
					<center>
					<img src="images/712.GIF" id="locadinggif" width="32" height="32" style="margin-top:15px; display:none;">
					</center>
					</center>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="add_server_check_go" name="add_server_check_go">
					GO </button>
					<button type="button" class="btn btn-default btn-danger" onclick="history.go(-1);">
					Cancel </button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="installing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="myModalLabel">
				<span class="glyphicon glyphicon glyphicon-plus">
				</span>
				Step <span id="stage_num">
				1 </span>
				of 8 </h2>
			</div>
			<div class="modal-body" style="width:400px; margin-left: auto; margin-right: auto ;">
				<center>
				<p>ManageMC will now begin to install itself on the server. <br/>This can take up to 3 minutes. Please keep this tab open until everything completes
				</p>
				<p>
					 Current Task: <span id="task">
					Updating System </span>
				</p>
			</div>
		</div>
		</center>
		<!--
<div class="modal-footer">
</div>
-->
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
render_footer();
?><script src="js/server_management_AddServer.js" ></script>
<?php
}
if ($page == "DeleteServer") {
?>
        <!-- Modal -->
<div class="modal fade" id="landing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-trash"></i> Delete Server</h2>
      </div><div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> This will delete all the content on the server and then remove all data associated to this server from the database. This irreversible!
</div>
      <div class="modal-body" style="width:400px; margin-left: auto ;  margin-right: auto ;"><center>
      
      <p>To remove <b>ALL</b> data from this server and then remove all data associated to this server from the database click GO.</p><p>This will take about 1 minute and is irreversible!</p>
      </div>
      
      <div class="modal-footer">
      <form id="delete_server" action="/api/post/delete_server.php?uid=<?php echo $_GET['uid']; ?>" method="post">
        <button type="submit" class="btn btn-success" id="delete_server_go" name="add_server_check_go">GO</button>
        <a href="/server_management.php?page=ManageServer&uid=<?php echo $_GET['uid']; ?>"><button type="button" class="btn btn-default btn-danger">Cancel</button></a>
        </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Modal -->
<div class="modal fade" id="complete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span>Complete</h2></div>
      <div class="modal-body" style="width:400px; margin-left: auto;  margin-right: auto ;"><center>
      <p>ManageMC has removed this server completly.</p>
      <a href="/dashboard.php?page=Overview"><button type="button" class="btn btn-default btn-info">Dashboard</button></a>
      
		</div>
        
      </div></center>
      
      
      <!--<div class="modal-footer">

        </div>-->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        
<?php 
render_footer();
?>
<script src="js/server_management_DeleteServer.js" ></script>
<?php }
}?>