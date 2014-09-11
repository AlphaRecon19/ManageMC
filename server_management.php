<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
CORE_Check_Force_SSL();
CORE_Compress();
Check_Login();
Force_Admin();
CORE_Render_Top("Server Management");
CORE_Render_Navbar();
CORE_Render_Sidebar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
$page = $_GET['page'];if ($page == "ManageServer") {?>
<!-- Modal -->
<div class="modal fade" id="updatemanagemc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title" id="myModalLabel">
<span class="glyphicon glyphicon glyphicon-download-alt"></span>Updating ManageMC</h2> <img src="images/712.GIF" id="loading_img" width="32" height="32" style="float: right; position: relative; margin-top: -40px; display:none;"/></div>
<div class="modal-body" style="width:500px; margin-left: auto; margin-right: auto ;">
<center>
<span id="updatemanagemc_version"></span>
<span id="updatemanagemc_text"><p>Please wait while ManageMC is being updated on this node</p></span>
</div>
</div>
</center>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="col-md-5" style="height: 580px;">
<div class="panel panel-info">
<div class="panel-heading"><h3>Live Server Load</h3>
</div>
<div class="panel-body">
<center><div style="color:#EEE;background:#222;width:320px;/* padding:20px; */border-radius:15px;text-align: center;">
<div id="knobinner" style="position:relative;width:350px;margin:auto;float:left; display:none;">
<div style="position:absolute;left:10px;top:10px">
<input class="knob load0" data-bgcolor="#333" data-displayinput="false" data-fgcolor="#ffec03" data-height="300" data-max="100" data-min="0" data-thickness=".3" data-width="300">
</div>
<div style="position:absolute;left:60px;top:60px;">
<input class="knob load1" data-bgcolor="#333" data-displayinput="false" data-height="200" data-max="100" data-min="0"                                data-thickness=".45" data-width="200" id="datalol1">
</div>
<div style="position:absolute;left:110px;top:110px">
<input class="knob load2" data-bgcolor="#333" data-displayinput="false" data-fgcolor="rgb(127, 255, 0)" data-height="100" data-max="100" data-min="0" data-thickness=".7" data-width="100">
</div>
</div>
<div id="newa" style="overflow:hidden;float:right;width:300px;height:310px;"></div><center id="knobtext" style="position:relative;bottom:0;padding-top:350px;margin:auto;color:#222;overflow:none; display:none;">
<p><span style="color:#EEE;">Load avg: </span>
<span style="background-color:#ffec03">1 min: <span id="load0"></span></span>
<span style="background-color:#87CEEB">5 min: <span id="load1"></span></span>
<span style="background-color:rgb(127, 255, 0);">15 min: <span id="load2"></span>
</span></p>
</center>
<div style="clear:both"></div>
<br />
</div>
</center>
</div>
</div><!-- End Panel -->
</div>
<div class="col-md-5">
<div class="panel panel-info">
<div class="panel-heading">
<h3>Server infomation</h3>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table tableright table-striped">
<tbody>
<tr>
<td><center><b>STATUS</b></center></td>
<td><center><span id="STATUS_Table"><img src="images/712.GIF" width="32" height="32"></span></center></td>
</tr>
<tr>
<td><center><b>IP</b></center></td>
<td><center><span id="IP_Table"><img src="images/712.GIF" width="32" height="32"></span> <span class="glyphicon glyphicon-signal"></span><span id="ms_Table"><img src="images/712.GIF" width="32" height="32"></span>ms</center></td>
</tr>
<tr>
<td><center><b>Disk space</b></center></td>
<td><center><div class="progress"><div class="progress-bar" role="progressbar" id="diskspaceb" style="width: 0%;"><b><span id="diskspacevalue"></span></b></div></div></center><center><span id="diskused"><img src="images/712.GIF" width="32" height="32"></span> of <span id="disktotal"><img src="images/712.GIF" width="32" height="32"></span> Used</center></td>
</tr>
<tr>
<td><center><b>World Size</b></center></td>
<td><center><span id="STATUS_WorldSize"><img src="images/712.GIF" width="32" height="32"></span></center></td>
</tr>
<tr>
<td><center><b>ManageMC Version</b></center></td>
<td><center><span id="ManageMCVersion"><img src="images/712.GIF" width="32" height="32"></span></center><center><br /><button class="btn btn-info" style="margin-top: -20px;" id="UpdateManageMC"><span class="glyphicon glyphicon-download-alt"></span> Update ManageMC</button></center></td>
</tr>
</tbody>
</table>
</div>
</div>
</div><!-- End Panel -->
</div>
<div class="row" style="margin-right: 1px; padding-left: 10px;">
<div class="col-md-12">
<div class="panel panel-info">
<div class="panel-heading">
<h3>Command Center</div>
<div class="panel-body">
<div class="alert alert-danger" id="NewWarning" style="display:none;">
<strong>Warning!:</strong> This server still needs to be claimed by a client. Here is the <button class="btn btn-warning"><span class="glyphicon glyphicon-user"></span> Claim URL</button></div>          
<button id="control_start" class="btn btn-success" disabled="disabled"><span class="glyphicon glyphicon-play"></span> Start</button>
<button id="control_stop" class="btn btn-danger" disabled="disabled"><i class="glyphicon glyphicon-stop"></i> Stop</button>
<button id="control_restart" class="btn btn-info" disabled="disabled"><i class="glyphicon glyphicon-refresh"></i> Restart</button>
<button id="control_reboot" class="btn btn-danger" disabled="disabled"><i class="glyphicon glyphicon-refresh"></i> Reboot</button>
<a href="?page=DeleteServer&uid=<?php echo $_GET['uid']; ?>"><button id="control_delete" class="btn btn-danger" disabled="disabled"><i class="glyphicon glyphicon-trash"></i> Delete</button></a><img src="/images/712.GIF" width="32" height="32" style="margin: 0; position: relative; float: right; display:none;" id="loading">
Show Log: <input type="checkbox" class="js-switch" id="toggle_log" checked />
Auto Refresh: <input type="checkbox" class="js-switch" id="auto_refresh" />
Curently: <span id="status"></span><span><img src="/images/712.GIF" width="32" height="32" style="margin: 0; display:none;" id="status_img"> <button id="control_refresh" class="btn" disabled="disabled"><i class="glyphicon glyphicon-refresh"></i></button></span>
<div id="last_rersault" style="background-color: #696969; color: #0F0; width: 100%; max-height: 330px; margin-top: 10px; font-weight: 500; padding: 5px; border-radius: 5px; overflow: scroll; overflow-y: auto; overflow-x: auto;"></div>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-12 -->
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading"><h3>Ram Free in the last 15 mins</h3>
<a href="/server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=15&type=free"><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon-search"></span> View More</button></a></div>
<div class="panel-body">        
<center><div class="content"><div class="pane"><div id="chartContainerfree" class="case-container" style="width: 100%; height: 440px;"></div></div></div></center>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading"><h3>MS in the last 15 mins</h3>
<a href="/server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=15&type=ms"><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon-search"></span> View More</button></a></div>
<div class="panel-body">        
<center><div class="content"><div class="pane"><div id="chartContainerms" class="case-container" style="width: 100%; height: 440px;"></div></div></div></center>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading"><h3>Server Load in the last 15 mins</h3><a href="/server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=15&type=load"><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon-search"></span> View More</button></a></div>
<div class="panel-body">        
<center><div class="content"><div class="pane"><div id="chartContainerload" class="case-container" style="width: 100%; height: 440px;"></div></div></div></center>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading"><h3>Total players online in the last 15 mins</h3><a href="/server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=15&type=players"><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon-search"></span> View More</button></a></div>
<div class="panel-body">        
<center><div class="content"><div class="pane"><div id="chartContainerplayers" class="case-container" style="width: 100%; height: 440px;"></div></div></div></center>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading"><h3>Filemanager </h3><a href="/server_management.php?page=Filemanager&uid=<?php echo $_GET['uid']; ?>"><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon-folder-open"></span> Filemanager</button></a></div>
<div class="panel-body" style="padding: 0px;">        
<div id="filemanager"  style="width:100%; height: 500px; overflow: scroll; overflow-y: auto; overflow-x: auto;"><center><img src="images/712.GIF" width="32" height="32" style="margin: 10px;"></center></div>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading"><h3>The WayBack Tool</h3><a href="/server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=15&type=players"><button class="btn btn-info btn-lg pull-right" style="margin-top: -45px;"><span class="glyphicon glyphicon-search"></span> View More</button></a></div>
<div class="panel-body" style="padding: 0px;">        
<div id="twbt"  style="width:100%; height: 500px; overflow: scroll; overflow-y: auto; overflow-x: auto;"><center><img src="images/712.GIF" width="32" height="32" style="margin: 10px;"></center></div>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
</div><!-- /row -->
<?php CORE_Render_Footer();
echo CORE_GetJSFiles("lib/switchery/switchery.min.js","js/globalize.min.js","js/dx.chartjs.js","js/knob.js");
?>
<script src="js/server_management_manageserver.php?uid=<?php echo $_GET['uid']; ?>" ></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=load&time=15&res=1"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=ms&time=15&res=1"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=free&time=15&res=1"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=players&time=15&res=1"></script>
<?php exit;}if ($page == "ListServer") {?>
<div class="row" style="padding-left:25px;">
<div class="col-md-10">
<div class="panel panel-info">
<div class="panel-heading"><h3>Server List</h3></div>
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th><center>UID</center></th>
<th><center>STATUS</center></th>
<th><center>VERSION</center></th>
<th><center>OWNER</center></th>
<th><center>IP</center></th>
<th>Manage</th>
</tr>
</thead>
<tbody id="listservers">
<tr>
<td><center><img src="images/712.GIF" width="32" height="32"></center></td>
<td><center><img src="images/712.GIF" width="32" height="32"></center></td>
<td><center><img src="images/712.GIF" width="32" height="32"></center></td>
<td><center><img src="images/712.GIF" width="32" height="32"></center></td>
<td><center><img src="images/712.GIF" width="32" height="32"></center></td>
<td><center><img src="images/712.GIF" width="32" height="32"></center></td>
</tr>
</tbody>
</table>
</div>
</div><!-- End Panel -->
</div>
</div><!-- /row -->
<?php
CORE_Render_Footer();
?><script>
function decode_base64(e){var t={},n,r,i=[],s="",o=String.fromCharCode;var u=[[65,91],[97,123],[48,58],[43,44],[47,48]];for(z in u){for(n=u[z][0];n<u[z][1];n++){i.push(o(n))}}for(n=0;n<64;n++){t[i[n]]=n}for(n=0;n<e.length;n+=72){var a=0,f,l,c=0,h=e.substring(n,n+72);for(l=0;l<h.length;l++){f=t[h.charAt(l)];a=(a<<6)+f;c+=6;while(c>=8){s+=o((a>>>(c-=8))%256)}}}return s}$(document).ready(function(){$.ajax({type:"GET",dataType:"JSON",url:"/api/get/listservers.php",success:function(e){$("#loaderImage").toggle();if(e.num_rows!=0){$("#listservers").html(decode_base64(e.serverlist))}else{$("#listservers").html('<center>We found no servres in the database. Why not add one <a href="server_management.php?page=AddServer">here</a></center>')}}})})</script>
<?php
exit;}//End of ListServers
if ($page == "AddServer") {
?>
<!-- Modal -->
<div class="modal fade" id="landing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span>Add Server</h2></div>
<span id="message" style="display:none;"/>
<div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times; </button>
<strong>Warning! </strong><span id="message_cont"></span>
</div>
</span>
<div class="modal-body" style="width:300px; margin-left: auto ; margin-right: auto ;"><center>
<form id="add_server_check" action="/api/post/add_server_check.php" method="post">
<div class="input-group">
<span class="input-group-addon">
<span class="glyphicon glyphicon-hdd">
</span>
<span style="padding-left:35px;">IP: </span>
</span>
<input type="text" class="form-control" style="height:45px;" id="ip" name="ip" required autocomplete="off" autofocus>
</div>
<div class="input-group">
<span class="input-group-addon" style="width: 94px;">
<span class="glyphicon glyphicon-asterisk">
</span>ROOT <br/> Password: </span>
<input type="text" class="form-control" style="height:45px;" id="password" name="password" required autocomplete="off">
</div>
<center><img src="images/712.GIF" id="locadinggif" width="32" height="32" style="margin-top:15px; display:none;"></center>
</center>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-success" id="add_server_check_go" name="add_server_check_go">GO</button>
<button type="button" class="btn btn-default btn-danger" onclick="history.go(-1);">Cancel</button>
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
<h2 class="modal-title" id="myModalLabel">
<span class="glyphicon glyphicon glyphicon-plus"></span>Step <span id="stage_num">1 </span>of 8 </h2>
</div>
<div class="modal-body" style="width:400px; margin-left: auto; margin-right: auto ;">
<center>
<p>ManageMC will now begin to install itself on the server. <br/>This can take up to 3 minutes. Please keep this tab open until everything completes</p>
<p>Current Task: <span id="task">Updating System </span></p>
</div>
</div>
</center>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
CORE_Render_Footer();
CORE_GetJSFiles("js/server_management_AddServer.js");
exit;}
if ($page == "DeleteServer") {
?>
<!-- Modal -->
<div class="modal fade" id="landing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header"><h2 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-trash"></i> Delete Server</h2></div><div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning!</strong> This will delete all the content on the server and then remove all data associated to this server from the database. This irreversible!</div>
<div class="modal-body" style="width:400px; margin-left: auto ;  margin-right: auto ;"><center>
<p>To remove <b>ALL</b> data from this server and then remove all data associated to this server from the database click GO.</p>
<p>This will take about 1 minute and is irreversible!</p>
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
<div class="modal-header"><h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span>Complete</h2></div>
<div class="modal-body" style="width:400px; margin-left: auto;  margin-right: auto ;"><center>
<p>ManageMC has removed this server completly.</p>
<a href="/dashboard.php?page=Overview"><button type="button" class="btn btn-default btn-info">Dashboard</button></a>
</div>
</div>
</center>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->    
<?php 
CORE_Render_Footer();
CORE_GetJSFiles("js/server_management_DeleteServer.js");
?>
<?php
exit;}
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
if ($page == "Graph") {
$RES = $_GET['res'];
$TIME = $_GET['time'];
$TYPE = $_GET['type'];
if(!isset($_GET['timestamp']))
{$TIMESTAMP =time();}
else
{$TIMESTAMP = $_GET['timestamp'];}
if($TYPE == "load")
{$TYPE_FULL = 'Server load';}
elseif($TYPE == "ms")
{$TYPE_FULL = 'Server ping';}
elseif($TYPE == "free")
{$TYPE_FULL = 'Free RAM';}
elseif($TYPE == "players")
{$TYPE_FULL = 'Players connected';}
?>
<div class="row" style="padding-left:25px;">
<div class="col-md-10">
<div class="panel panel-info">
<div class="panel-heading">
<h3><?php echo $TYPE_FULL; ?> in the last <?php echo CORE_Time_Elapsed($TIME * 60,0);?>.</h3><h4> Change Resolution: <input type="checkbox" class="js-switch" id="toggle_res" /> Change Time: <input type="checkbox" class="js-switch" id="toggle_time" /> Infomation: <input type="checkbox" class="js-switch" id="toggle_info" /></h4>
<div id="res" style="display:none; margin-bottom:2px;">Resolution:
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=<?php echo $TIME; ?>&type=<?php echo $TYPE; ?>">
<button class="btn btn-success" <?php if($RES == 1){echo 'disabled';} ?>>1</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=2&time=<?php echo $TIME; ?>&type=<?php echo $TYPE; ?>">
<button class="btn btn-success" <?php if($RES == 2){echo 'disabled';} ?>>2</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=3&time=<?php echo $TIME; ?>&type=<?php echo $TYPE; ?>">
<button class="btn btn-success" <?php if($RES == 3){echo 'disabled';} ?>>3</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=4&time=<?php echo $TIME; ?>&type=<?php echo $TYPE; ?>">
<button class="btn btn-success" <?php if($RES == 4){echo 'disabled';} ?>>4</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=5&time=<?php echo $TIME; ?>&type=<?php echo $TYPE; ?>">
<button class="btn btn-success" <?php if($RES == 5){echo 'disabled';} ?>>5</button></a></div>
<div id="time" style="display:none; margin-bottom:2px;">Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=1&time=15&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 15){echo 'disabled';} ?>>15m</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=2&time=30&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 30){echo 'disabled';} ?>>30m</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=2&time=45&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 45){echo 'disabled';} ?>>45m</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=3&time=60&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 60){echo 'disabled';} ?>>1H</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=4&time=120&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 120){echo 'disabled';} ?>>2H</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=6&time=240&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 240){echo 'disabled';} ?>>4H</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=8&time=360&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 360){echo 'disabled';} ?>>6H</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=16&time=720&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 720){echo 'disabled';} ?>>12H</button></a>
<a href="server_management.php?page=Graph&uid=<?php echo $_GET['uid']; ?>&res=16&time=1440&type=<?php echo $TYPE; ?>">
<button class="btn btn-info" <?php if($TIME == 1440){echo 'disabled';} ?>>1D</button></a></div>
<div id="info" style="display:none; margin-bottom:2px;"><h4>Infomation:</h4>- There is a total of <span id="total_r"><img src="images/712.GIF" width="32" height="32"></span> records out of a posible <?php  echo round(($TIME / $RES), 0, PHP_ROUND_HALF_DOWN); ?>.<br />- The first record in this graph was recorded <span id="timesince"><img src="images/712.GIF" width="32" height="32"></span><br />- It took a total of <span id="total_t"><img src="images/712.GIF" width="32" height="32"></span> to genarate this graph.</div>
</div>
<div class="panel-body">        
<center><div class="content">
<div class="pane"><div id="chartContainer<?php echo $TYPE; ?>" class="case-container" style="width: 100%; height: 100%;"></div></div>
</div>
<code style="margin-top: 5px;">note: A value of "0" can mean that ManageMC was unable to retreive a valid responce.</code><br /><a href="server_management.php?page=ManageServer&uid=<?php echo $_GET['uid']; ?>"><button class="btn btn-info btn-lg" style="margin-top: 5px;">Manage This Server</button></a></center></div>
</div><!-- End Panel -->
</div><!-- End col-md-6 -->
</div><!-- /row -->
<?php 
CORE_Render_Footer();
CORE_GetJSFiles("/lib/switchery/switchery.min.js","/js/globalize.min.js","js/dx.chartjs.js");
?>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=<?php echo $TYPE; ?>&time=<?php echo $TIME; ?>&res=<?php echo $RES; ?>&stats=true&timestamp=<?php echo $TIMESTAMP; ?>"></script>
<script>
var elem = document.querySelector('#toggle_res');
var elem2 = document.querySelector('#toggle_time');
var elem3 = document.querySelector('#toggle_info');
var init = new Switchery(elem);
var init2 = new Switchery(elem2);
var init3 = new Switchery(elem3);
$("#toggle_time").change(function(){$("#time").toggle();}); 
$("#toggle_res").change(function(){$("#res").toggle();}); 
$("#toggle_info").change(function(){$("#info").toggle();}); 
</script>
<?php
exit;
}
else
{
?>

<div class="col-md-10">
<div class="panel panel-danger">
<div class="panel-heading"><h3>Invalid Page</h3></div>
<div class="panel-body">        
<center>You have provided an invalid page request. Please check that link and try again.
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 --></center>
<?php
}
exit;
}
elseif(empty($_GET['uid']))
{
?>

<div class="col-md-10">
<div class="panel panel-danger">
<div class="panel-heading"><h3>Invalid Page</h3></div>
<div class="panel-body">        
<center>You have provided an invalid Server UID. Please check that link and try again or click <a href="/server_management.php?page=ListServer">here</a> to go back to the server list.
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 --></center>
<?php
}