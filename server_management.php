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
$page = $_GET['page'];if ($page == "ManageServer") {
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
$serverinfo = get_server_infomation($_GET['uid']);
?>
<div class="row" style="padding-left:25px;">
    <div class="col-md-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>Server Infomation</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table tableright table-striped">
                        <tbody>
                            <tr>
                                <td><center><b>STATUS</b></center></td>
                                <td><center><?php echo $serverinfo['STATUS']?></center></td>
                            </tr>
                            <tr>
                                <td><center><b>IP</b></center></td>
                                <td><center><?php echo $serverinfo['IP']?> <span class="glyphicon glyphicon-signal"></span> <?php echo $serverinfo['MS']?>ms</center></td>
                            </tr>
                            <tr>
                                <td><center><b>Disk space</b></center></td>
                                <td><center><div class="progress"><div class="progress-bar" role="progressbar" id="diskspaceb" style="width: 0%;"><b><span id="diskspacevalue"></span></b></div></div></center><center><span id="diskused"><img src="images/712.GIF" width="16" height="16"></span> of <span id="disktotal"><img src="images/712.GIF" width="16" height="16"></span> Used</center></td>
                            </tr>
                            <tr>
                                <td><center><b>World Size</b></center></td>
                                <td><center><span id="worldsize"><img src="images/712.GIF" width="16" height="16"></span></center></td>
                                </tr>
                            <tr>
                                <td><center><b>ManageMC Version</b></center></td>
                                <td><center><span ><?php echo $serverinfo['MANAGEMC_VERSION']?></center><center><br /><button class="btn btn-info" style="margin-top: -20px;" id="UpdateManageMC"><span class="glyphicon glyphicon-download-alt"></span> Update ManageMC</button></center></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End Panel -->
    </div>
    
     <div class="col-md-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>Server Control</h3>
            </div>
            <div class="panel-body">
                
            </div>
        </div><!-- End Panel -->
    </div>
    
</div><!-- End row -->

<?php CORE_Render_Footer();
//echo CORE_GetJSFiles("lib/switchery/switchery.min.js","js/globalize.min.js","js/dx.chartjs.js","js/knob.js");
?>
<script>
    $.ajax({
        type: "GET",
        url: "/api/get/server_management_manageserver.php?uid=<?php echo $_GET['uid']; ?>",
        success: function (data) {
            if (data.CLIENT_ID == "nill") {
                $("#NewWarning").css("display", "block");
            }
            $("#worldsize").html(data.MCSIZE);
            $("#diskspaceb").css("width", data.DISKFREEP);
            $("#diskspacevalue").html(data.DISKFREEP);
            $("#disktotal").html(data.DISKTOTAL);
            $("#diskused").html(data.DISKUSED);
        }
    });
</script>
<!--
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=load&time=15&res=1"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=ms&time=15&res=1"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=free&time=15&res=1"></script>
<script src="api/get/graph_server.php?uid=<?php echo $_GET['uid']; ?>&type=players&time=15&res=1"></script>-->
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
<center>You have provided an invalid page request. Please check that link and try again.</center>
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
<center>You have provided an invalid Server UID. Please check that link and try again or click <a href="/server_management.php?page=ListServer">here</a> to go back to the server list.</center>
</div>
</div><!-- End Panel -->
</div><!-- End col-md-6 --></center>
<?php
}