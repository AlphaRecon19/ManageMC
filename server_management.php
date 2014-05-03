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
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="panel panel-primary">

          <div class="panel-heading"><h3 id="Server_IP"><img src="images/712.GIF" width="32" height="32"> UID=<span id="UID_Table"><img src="images/712.GIF" width="32" height="32"></span></h3></div>
          <div class="panel-body">
          <div style="color:#EEE;background:#222;width:380px;padding:20px;border-radius:15px;text-align: center; float:left;">
          <div id="knobinner" style="position:relative;width:350px;margin:auto;float:left; display:none;"><div style="position:absolute;left:10px;top:10px"><input class="knob load0" data-bgcolor="#333" data-displayinput="false" data-fgcolor="#ffec03" data-height="300" data-max="100" data-min="0" data-thickness=".3" data-width="300"></div><div style="position:absolute;left:60px;top:60px;"><input class="knob load1" data-bgcolor="#333" data-displayinput="false" data-height="200" data-max="100" data-min="0" data-thickness=".45" data-width="200" id="datalol1"></div><div style="position:absolute;left:110px;top:110px"><input class="knob load2" data-bgcolor="#333" data-displayinput="false" data-fgcolor="rgb(127, 255, 0)" data-height="100" data-max="100" data-min="0" data-thickness=".7" data-width="100"></div></div><div id="newa" style="overflow:hidden;float:right;width:300px;height:310px;"></div><center id="knobtext" style="position:relative;bottom:0;padding-top:350px;margin:auto;color:#222;overflow:none; display:none;"><p><span style="color:#EEE;">Load avg: </span><span style="background-color:#ffec03"> 1 min:<span id="load0"></span></span><span style="background-color:#87CEEB"> 5 min: <span id="load1"></span></span><span style="background-color:rgb(127, 255, 0);"> 15 min: <span id="load2"></span></span></p></center><div style="clear:both"></div><br></div>
          <div class="table-responsive" >
            <table class="table tableright table-striped" style="width: 430px;">

              <tbody>
              	<tr>
                	<td><center><b>STATUS</b></center></td>
                    <td><center><span id="STATUS_Table"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>IP</b></center></td>
                	<td><center><span id="IP_Table"><img src="images/712.GIF" width="32" height="32"></span> <span class="glyphicon glyphicon-signal"></span><span id="ms_Table"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>Diskspace</b></center></td>
                    <td><center><div class="progress"><div class="progress-bar" role="progressbar" id="diskspaceb" style="width: 0%;">
                    	<b><span id="diskspacevalue"></span></b></div></div></center>
                    	<center><span id="diskused"></span> of <span id="disktotal"></span></center>
                    </td>
                </tr>
                <tr>
                	<td></td>
                    <td></td>
                </tr>
                
              </tbody>
            </table>
            </div>
			</div> <!-- End Panel -->
          </div>
          
          <div class="panel panel-primary">
          <div class="panel-heading"><h3>Command Center</div>
          <div class="panel-body">
          <div class="alert alert-danger" id="NewWarning" style="display:none; height:100px;">
  		  <strong>Warning!</strong> This server still needs to be assigned to a client. Do this now!<center id="NewWarningButton"><button class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-user"></span> Assign To Client</button></center>
          
          </div>          
          <div class="table-responsive">
            <table class="table">

              <tbody>
              	<tr>
                	<td><center><button class="btn btn-success btn-lg"><span class="glyphicon glyphicon-play"></span> Start</button></center></td>
                    <td><center><button class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-stop"></i> Stop</button></center></td>
                    <td><center><button class="btn btn-info btn-lg"><i class="glyphicon glyphicon-refresh"></i> Update</button></center></td>
                	<td><center><a href="?page=DeleteServer&uid=<?php echo $_GET['uid']; ?>"><button class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-trash"></i> Delete</button></a></center></td>
                </tr>
                               
              </tbody>
            </table>
            </div>
			</div> <!-- End Panel -->
          </div>
          
          
          
          <div class="panel panel-primary">
          <div class="panel-heading"><h3>Ram Free in the last 15 mins</div>
          <div class="panel-body">        
          
          <center><div class="content">
			<div class="pane">
				<div id="chartContainer" class="case-container" style="width: 90%; height: 440px;"></div>
			</div>
            </div></center>
            
			</div> <!-- End Panel -->
          </div>
          
          <div class="panel panel-primary">
          <div class="panel-heading"><h3>MS in the last 15 mins</div>
          <div class="panel-body">        
          
          <center><div class="content">
			<div class="pane">
				<div id="chartContainerMS" class="case-container" style="width: 90%; height: 440px;"></div>
			</div>
            </div></center>
            
			</div> <!-- End Panel -->
          </div>
		           
          
          
          <div class="panel panel-primary">
          <div class="panel-heading"><h3>Server Load</div>
          <div class="panel-body">        
          
          
          <center><div class="content">
			<div class="pane">
				<div id="chartContainerLOAD" class="case-container" style="width: 90%; height: 440px;"></div>
			</div>
            </div></center>
          
            
		</div> <!-- End Panel -->
          </div>
          
          

          
          
          
          
          <div class="panel panel-primary">
          <div class="panel-heading"><h3>server.properties</h3><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon glyphicon-pencil"></span> EDIT</button></div>
          <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">

              <tbody>
				<tr>
                	<td><center><b>generator-settings </b><span id="generator-settings_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>op-permission-level </b><span id="op-permission-level_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>allow-nether </b><span id="allow-nether_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>level-name </b><span id="level-name_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>enable-query </b><span id="enable-query_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>allow-flight </b><span id="allow-flight_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>announce-player-achievements </b><span id="announce-player-achievements_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>server-port </b><span id="server-port_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>level-type </b><span id="level-type_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>server-ip </b><span id="server-ip_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>max-build-height </b><span id="max-build-height_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>spawn-npcs </b><span id="spawn-npcs_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>white-list </b><span id="white-list_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>spawn-animals </b><span id="spawn-animals_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>hardcore </b><span id="hardcore_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>snooper-enabled </b><span id="snooper-enabled_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>online-mode </b><span id="online-mode_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>resource-pack </b><span id="resource-pack_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>pvp </b><span id="pvp_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>difficulty </b><span id="difficulty_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>enable-command-block </b><span id="enable-command-block_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>gamemode </b><span id="gamemode_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>player-idle-timeout </b><span id="player-idle-timeout_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>max-players </b><span id="max-players_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>spawn-monsters </b><span id="spawn-monsters_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><b>generate-structures </b><span id="generate-structures_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>view-distance </b><span id="view-distance_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                	<td><center><b>motd </b><span id="motd_Table2"><img src="images/712.GIF" width="32" height="32"></span></center></td>
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
<script src="js/bootstrap.js" ></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=load"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=ms"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=free"></script>
<script src="js/server_management_ManageServer.php?uid=<?php echo $_GET['uid']; ?>" ></script>
<script src="js/globalize.min.js"></script>
<script src="js/dx.chartjs.js"></script>
<script src="js/knob.js"></script>
        
        
        <?php
        exit;     }
	
	
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
						<span class="input-group-addon">
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
				<p>
					 ManageMC will now begin to install itself on the server. <br/>
					This can take up to 3 minutes.
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
        <a href="/dashboard.php?page=Overview"><button type="button" class="btn btn-default btn-danger">Cancel</button></a>
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