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
<?php } if ($page == "Activity") {
	
	
	if (isset($_GET['s']))
	{
		$start_n = $_GET['s'];
	}
	else
	{
		$start_n = 0;
	}
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
<th><center>
<a id="Hash" style="cursor:pointer; display:none;">#</a>
<a id="Hasha" style="cursor:pointer;"><b class="caret "></b> #</a>
<a id="Hashd" style="cursor:pointer; display:none;">^ #</a>
</center></th>

<th><center>
<a id="Time" style="cursor:pointer;">Time</a>
<a id="Timea" style="cursor:pointer; display:none;"><b class="caret "></b> Time</a>
<a id="Timed" style="cursor:pointer; display:none;">^ Time</a>
</center></th>

<th><center>
<a id="IP" style="cursor:pointer;">IP</a>
<a id="IPa" style="cursor:pointer; display:none;"><b class="caret "></b> IP</a>
<a id="IPd" style="cursor:pointer; display:none;">^ IP</a>
</center></th>

<th><center>
<a id="User" style="cursor:pointer;">User</a>
<a id="Usera" style="cursor:pointer; display:none;"><b class="caret "></b> User</a>
<a id="Userd" style="cursor:pointer; display:none;">^ User</a>
</center></th>

<th><center>
<a id="Message" style="cursor:pointer;">Message</a>
<a id="Messagea" style="cursor:pointer; display:none;"><b class="caret "></b> Message</a>
<a id="Messaged" style="cursor:pointer; display:none;">^ Message</a>
</center></th>

</tr>
<center><h3><span id="Header_Table"></span></h3></center>
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
<?php
CORE_Render_Footer();
?>
<script>$(document).ready(function(){
	
	$.ajax({
	url:"/api/get/log.php?cmd=activity_log&limit=50&v1=hash&v2=a&s=<?php echo $start_n; ?>",
	type:"JSON",
	success:function(e){
		if(e.table){
			$("#Activity_Table").html(decode_base64(e.table));
			$("#Header_Table").html(decode_base64(e.header));
			}else
			{window.location = "/dashboard.php?page=Activity";}
			}
});
function e() {
    $("#clear_activity_log_stage_2").toggle()
}
$("#clear_activity_log_confirm").click(function (t) {
    $("#clear_activity_log_stage_1").toggle();
    $.ajax({
        type: "JSON",
        url: "/api/get/log.php?cmd=activity_log_clear",
        data: $(this).serialize(),
        success: function (t) {
            $("#clear_activity_log_stage_1").toggle();
            $("#loaderImage").toggle();
            if (decode_base64(t.msg) == "done") {
                $("#clear_activity_log_stage_2").toggle();
                setTimeout(e, 5e3)
            } else {}
        }
    })
});
$("#Hash").click(function () {
    reset_Activity_Table();
    toggle_all("#Hasha", "#Hash");
    update_Activity_Table("hash", "a")
});
$("#Hasha").click(function () {
    reset_Activity_Table();
    toggle_all("#Hashd", "#Hash");
    update_Activity_Table("hash", "d")
});
$("#Hashd").click(function () {
    reset_Activity_Table();
    toggle_all("#Hasha", "#Hash");
    update_Activity_Table("hash", "a")
});
$("#Time").click(function () {
    reset_Activity_Table();
    toggle_all("#Timea", "#Time");
    update_Activity_Table("time", "a")
});
$("#Timea").click(function () {
    reset_Activity_Table();
    toggle_all("#Timed", "#Time");
    update_Activity_Table("time", "d")
});
$("#Timed").click(function () {
    reset_Activity_Table();
    toggle_all("#Timea", "#Time");
    update_Activity_Table("time", "a")
});
$("#IP").click(function () {
    reset_Activity_Table();
    toggle_all("#IPa", "#IP");
    update_Activity_Table("ip", "a")
});
$("#IPa").click(function () {
    reset_Activity_Table();
    toggle_all("#IPd", "#IP");
    update_Activity_Table("ip", "d")
});
$("#IPd").click(function () {
    reset_Activity_Table();
    toggle_all("#IPa", "#IP");
    update_Activity_Table("ip", "a")
});
$("#User").click(function () {
    reset_Activity_Table();
    toggle_all("#Usera", "#User");
    update_Activity_Table("user", "a")
});
$("#Usera").click(function () {
    reset_Activity_Table();
    toggle_all("#Userd", "#User");
    update_Activity_Table("user", "d")
});
$("#Userd").click(function () {
    reset_Activity_Table();
    toggle_all("#Usera", "#User");
    update_Activity_Table("user", "a")
});
$("#Message").click(function () {
    reset_Activity_Table();
    toggle_all("#Messagea", "#Message");
    update_Activity_Table("message", "a")
});
$("#Messagea").click(function () {
    reset_Activity_Table();
    toggle_all("#Messaged", "#Message");
    update_Activity_Table("message", "d")
});
$("#Messaged").click(function () {
    reset_Activity_Table();
    toggle_all("#Messagea", "#Message");
    update_Activity_Table("message", "a")
})








})

function reset_Activity_Table() {
	$("#Activity_Table").html('<tr><td><center><img src="images/712.GIF" width="32" height="32"></center></td><td><center><img src="images/712.GIF" width="32" height="32"></center></td><td><center><img src="images/712.GIF" width="32" height="32"></center></td><td><center><img src="images/712.GIF" width="32" height="32"></center></td><td><center><img src="images/712.GIF" width="32" height="32"></center></td></tr>');
}

function toggle_all(appart, next) {

$("#Hash").css("display","block");
$("#Hasha").css("display","none");
$("#Hashd").css("display","none");

$("#Time").css("display","block");
$("#Timea").css("display","none");
$("#Timed").css("display","none");

$("#IP").css("display","block");
$("#IPa").css("display","none");
$("#IPd").css("display","none");

$("#User").css("display","block");
$("#Usera").css("display","none");
$("#Userd").css("display","none");

$("#Message").css("display","block");
$("#Messagea").css("display","none");
$("#Messaged").css("display","none");


$(next).css("display","none");
$(appart).css("display","block");
}
function update_Activity_Table(v1, v2) {
	$.ajax({
	url:"/api/get/log.php?cmd=activity_log&limit=50&v1=" + v1 + "&v2=" + v2 +'&s=<?php echo $start_n; ?>',
	type:"JSON",
	success:function(e){
		if(decode_base64(e.table)){
			$("#Activity_Table").html(decode_base64(e.table));
			$("#Header_Table").html(decode_base64(e.header));
			}else
			{$("#Activity_Table").html("<center>Nothing Found!</center>")}
			}
});
}

function decode_base64(s) {
    var e={},i,k,v=[],r='',w=String.fromCharCode;
    var n=[[65,91],[97,123],[48,58],[43,44],[47,48]];

    for(z in n){for(i=n[z][0];i<n[z][1];i++){v.push(w(i));}}
    for(i=0;i<64;i++){e[v[i]]=i;}

    for(i=0;i<s.length;i+=72){
    var b=0,c,x,l=0,o=s.substring(i,i+72);
         for(x=0;x<o.length;x++){
                c=e[o.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){r+=w((b>>>(l-=8))%256);}
         }
    }
    return r;
    }
</script>
<?php 
 }
 
}?>