<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
Check_Force_SSL();
Check_Login();
Force_Admin();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/img.png">

    <title>Server Management - ManageMC</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="/css/signin.css" rel="stylesheet">
    
    <style>
	.tableleft {
		float:left;
	}
	.tableright {
		float:right;
	}
</style>
    
    
  </head>

  <body onload="on_load(), clock()">

    <div class="container">



<?php
Render_Navbar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == "AddServer") {
        echo '<div class="container-fluid">';
        Render_Sidebar();
?>
        <!-- Modal -->
<div class="modal fade" id="landing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span> Add Server</h2>
      </div>
      <span id="message" style="display:none;" /><div class="alert alert-danger alert-dismissable" style="max-width:600px; min-width:450px;" id="session_message">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> <span id="message_cont"> </span>
</div></span>
      <div class="modal-body" style="width:300px; margin-left: auto ;  margin-right: auto ;"><center>
      
      <form id="add_server_check" action="/api/post/add_server_check.php" method="post">
		<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span><span style="padding-left:35px;">IP:</span></span>
 			<input type="text" class="form-control" style="height:45px;" id="ip" name="ip" required autocomplete="off" autofocus>
		</div>	
        
        <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span> ROOT<br />Password:</span>
 			<input type="text" class="form-control" style="height:45px;" id="password" name="password"  required autocomplete="off">
		</div>
        <center><img src="images/712.GIF" id="locadinggif" width="32" height="32" style="margin-top:15px; display:none;"></center>
        </center>
      </div>
      
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="add_server_check_go" name="add_server_check_go">GO</button>
        <a href="/dashboard.php?page=Overview"><button type="button" class="btn btn-default btn-danger">Cancel</button></a>
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
        <h2 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon glyphicon-plus"></span>Step <span id="stage_num">1</span> of 8</h2></div>
      <div class="modal-body" style="width:400px; margin-left: auto;  margin-right: auto ;"><center>
      <p>ManageMC will now begin to install itself on the server.<br />This can take up to 3 minutes.</p>
      <p>Current Task: <span id="task">Updating System</span></p>
      
		</div>
        
      </div></center>
      
      
      <!--<div class="modal-footer">

        </div>-->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        

    </div> <!-- /container -->

  </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>
<script src="js/server_management_AddServer.js" ></script>
       
        
        <?php
        exit; //Finish page 'Activity'
    }
	if ($page == "DeleteServer") {
        echo '<div class="container-fluid">';
        Render_Sidebar();
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
      
      <p>To remove <b>ALL</b> data from this server and then remove all data associated to this server from the database click GO.</p><p>This will take about 1 minuet and is irreversible!</p>
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
        

    </div> <!-- /container -->

  </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>
<script src="js/server_management_DeleteServer.js" ></script>
       
        
        <?php
        exit; //Finish page 'Activity'
    }
    if ($page == "ManageServer") {
        echo '<div class="container-fluid">';
        Render_Sidebar();
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="panel panel-primary">

          <div class="panel-heading"><h3 id="Server_IP"><img src="images/712.GIF" width="32" height="32"></h3></div>
          <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">

              <tbody>
              	<tr>
                	<td><center><b>Server UID</b> <span id="UID_Table"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                    <td><center><b>STATUS</b> <span id="STATUS_Table"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                </tr>
                <tr>
                <td><center><b>IP</b> <span id="IP_Table"><img src="images/712.GIF" width="32" height="32"></span></center></td>
                	<td><center><span class="glyphicon glyphicon-signal"></span> <b><span id="ms_Table"><img src="images/712.GIF" width="32" height="32"></span></b> ms</center></td>
                    
                	
                </tr>
                
                
              </tbody>
            </table>
            </div>
			</div> <!-- End Panel -->
          </div>
          
          <div class="panel panel-primary">
          <div class="panel-heading"><h3>Command Center</div>
          <div class="panel-body">
          <div class="alert alert-danger" id="NewWarning" style="display:none">
  		  <strong>Warning!</strong> This server still needs to be assigned to a client. Do this now!<span class="glyphicon glyphicon-warning-sign" style="float:right;"></span>
          </div>          
          <div class="table-responsive">
            <table class="table">

              <tbody>
              	<tr>
                	<td><center><button class="btn btn-success btn-lg"><span class="glyphicon glyphicon-play"></span> Start</button></center></td>
                    <td><center><button class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-stop"></i> Stop</button></center></td>
                    <td><center><button class="btn btn-info btn-lg"><i class="glyphicon glyphicon-refresh"></i> Update</button></center></td>
                	<td><center><a href="?page=DeleteServer&uid=<?php echo $_GET['uid']; ?>"><button class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-trash"></i> Delete</button></a></center></td>
                    <td id="NewWarningButton" style="display:none"><center><button class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-user"></span> Assign To Client</button></center></td>
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
          
          <center>
        <div class="demo" style="color:#EEE;background:#222;height:400px;width:400px; padding:20px; border-radius:15px; text-align: center;">
            <div style="position:relative;width:350px;margin:auto; float:left;">
                <div style="position:absolute;left:10px;top:10px">
                    <input class="knob load0" data-min="0" data-max="100" data-bgColor="#333" data-fgColor="#ffec03" data-displayInput=false data-width="300" data-height="300" data-thickness=".3">
                </div>
                <div style="position:absolute;left:60px;top:60px;">
                    <input id="datalol1" class="knob load1" data-min="0" data-max="100" data-bgColor="#333" data-displayInput=false data-width="200" data-height="200" data-thickness=".45">
                </div>
                <div style="position:absolute;left:110px;top:110px">
                    <input class="knob load2" data-min="0" data-max="100" data-bgColor="#333" data-fgColor="rgb(127, 255, 0)" data-displayInput=false data-width="100" data-height="100" data-thickness=".7">
                </div>
                 
            </div>
            <div id="newa" style="overflow:hidden; float:right; width:300px; height:310px;" readonly></div>
            <center style="position:relative; bottom:0; padding-top:300px; margin:auto; color:#222; overflow:none;">
        <p><span style="color:#EEE;">Load avg</span> <span style="background-color:#ffec03"> 1 min:<span id="load0"></span></span><span style="background-color:#87CEEB"> 5 min: <span id="load1"></span></span><span style="background-color:rgb(127, 255, 0);"> 15 min: <span id="load2"></span></span></p>
        <div style="clear:both"></div>
   
        </center>
            
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
<script src="js/bootstrap.min.js" ></script>

<script src="js/server_management_ManageServer.php?uid=<?php
        echo $_GET['uid'];
?>" ></script>
<script src="js/globalize.min.js"></script>
<script src="js/dx.chartjs.js"></script>
<script src="api/get/graph_server_used.php?uid=<?php
        echo $_GET['uid'];
?>"></script>
<script src="api/get/graph_server_ping.php?uid=<?php
        echo $_GET['uid'];
?>"></script>
<script>
        function on_load() {
            $(".load0").val('0').trigger("change");
            $(".load1").val('0').trigger("change");
            $(".load2").val('0').trigger("change");
        }
        function clock() {
            var $load0 = $(".load0"),
                $load1 = $(".load1"),
                $load2 = $(".load2");
				
                     $.getJSON("load.php?uid=YTgwMTc1YTI1YzE1ZThiNDMxYmE1YmVhZGYyNThjMGM=",{mode: 1},function(jsonResult)
      { 
        var str='';
        for(var i=0; i<jsonResult.length;i++)
          {
            load0_100 = jsonResult[i].load0_100;
            load1_100 = jsonResult[i].load1_100;
            load2_100 = jsonResult[i].load2_100;
            
            load0 = jsonResult[i].load0;
            load1 = jsonResult[i].load1;
            load2 = jsonResult[i].load2;
            
            time = jsonResult[i].time;
            
            var rnum = Math.max(load0, load1, load2);
            
            var rlength = '0';
            var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
            newmax = (newnumber + 1) * 100;
            if(rnum < 1)
            {
                newmax = '100';
            }
          }
              
    
    
    $('#load0').fadeOut(200, function() {});
            $('#load1').fadeOut(200, function() {});
            $('#load2').fadeOut(200, function() {});
    $('.load0').trigger('configure',{"max":newmax,});
    $('.load1').trigger('configure',{"max":newmax,});
    $('.load2').trigger('configure',{"max":newmax,});
    
    
     
    
            $load0.val(load0_100).trigger("change");
            $load1.val(load1_100).trigger("change");
            $load2.val(load2_100).trigger("change");
			
            $('#load0').html(load0);
            $('#load1').html(load1);
            $('#load2').html(load2);
            
            $('#load0').fadeIn(500, function() {});
            $('#load1').fadeIn(500, function() {});
            $('#load2').fadeIn(500, function() {});
            
            
            setTimeout('clock()', 5000);
            
        
      });
            };
        </script>
        <script src="js/jquery.knob.js"></script>
        <script>
            $(function($) {

                $(".knob").knob({
                    change : function (value) {
                        //console.log("change : " + value);
                    },
                    release : function (value) {
                        //console.log(this.$.attr('value'));
                        console.log("release : " + value);
                    },
                    cancel : function () {
                        console.log("cancel : ", this);
                    },
                    draw : function () {

                        // "tron" case
                        if(this.$.data('skin') == 'tron') {

                            var a = this.angle(this.cv)  // Angle
                                , sa = this.startAngle          // Previous start angle
                                , sat = this.startAngle         // Start angle
                                , ea                            // Previous end angle
                                , eat = sat + a                 // End angle
                                , r = 1;

                            this.g.lineWidth = this.lineWidth;

                            this.o.cursor
                                && (sat = eat - 0.3)
                                && (eat = eat + 0.3);

                            if (this.o.displayPrevious) {
                                ea = this.startAngle + this.angle(this.v);
                                this.o.cursor
                                    && (sa = ea - 0.3)
                                    && (ea = ea + 0.3);
                                this.g.beginPath();
                                this.g.strokeStyle = this.pColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                                this.g.stroke();
                            }

                            this.g.beginPath();
                            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                            this.g.stroke();

                            this.g.lineWidth = 2;
                            this.g.beginPath();
                            this.g.strokeStyle = this.o.fgColor;
                            this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                            this.g.stroke();

                            return false;
                        }
                    }
                });
                
            });
        </script>
        
        
        <?php
        exit; //Finish page 'Activity'
    }
    if ($page == "ListServer") {
        echo '<div class="container-fluid">';
        Render_Sidebar();
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="panel panel-primary">

          <div class="panel-heading"><h3>Server List</h3></div>
          <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th><center>UID</center></th>
                  <th><center>IP</center></th>
                  <th><center>Client</center></th>
                  <th><center>Edit</center></th>
                </tr>
              </thead>
              <tbody id="listservers">
				<tr>
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

    </div> <!-- /container -->

  </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<script>
$(document).ready(function() {
    $.ajax({
       type: "GET",
       url: '/api/get/listservers.php',
       data: $(this).serialize(),
       success: function(data)
       {
		  $('#loaderImage').toggle();
          if (data) {
            $('#listservers').html(data);
          }
          else {
			  $('#listservers').html('Error Loading Data');
          }
       }
   });
   

   
});</script>
        
        
        <?php
        exit; //Finish page 'Activity'
    }
}