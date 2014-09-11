<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpseclib/Net/SSH2.php');
CORE_Check_Force_SSL();
CORE_Compress();
Check_Login();
Force_Admin();
CORE_Render_Top("Settings");
CORE_Render_Navbar();
CORE_Render_Sidebar();
?>

<div class="row" style="padding-left:25px;">   
    
    <div class="col-md-10">
 <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <ul class="nav navbar-nav navbar-left">
            <?php $page = $_SERVER['REQUEST_URI'];
            if ($page == "/settings.php?page=general" ||$page == "/settings.php" ) {
				echo '<li class="active"><a href="/settings.php?page=general">';
			}else{
				echo '<li><a href="/settings.php?page=general">';
			}
			echo 'General</a></li>';
			
			if ($page == "/settings.php?page=hostsettings") {
				echo '<li class="active"><a href="/settings.php?page=hostsettings">';
			}else{
				echo '<li><a href="/settings.php?page=hostsettings">';
			}
			echo 'Host Server</a></li>';
			
			if ($page == "/settings.php?page=advanced") {
				echo '<li class="active"><a href="/settings.php?page=advanced">';
			}else{
				echo '<li><a href="/settings.php?page=advanced">';
			}
			echo 'Advanced</a></li>';
			?>
            </ul>
        </div><!--/.container-fluid -->
      </div>

<?php
$page = "general";
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
}
    if ($page == "general") {?>
        <div class="panel panel-info">
          <div class="panel-body">
		  <!-- Start Speed -->
		  <span id="speed_save"><h2>Speed</h2></span>
		  <form name="speed_form" id="speed_form" action="test.php" method="post">
		  <div class="table-responsive">
          <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width:15%">$config[]</th>
            <th style="width:20%">Value</th>
			<th style="width:65%">Description</th>
          </tr>
        </thead>
        <tbody>	
          <tr>
            <td>jQuery_cdn</td>
            <td><center>
				<select onchange="save_form('speed', 'Speed')" id="jQuery_cdn" name="jQuery_cdn">
					<option value="NONE" <?php if($config['jQuery_cdn'] == 'NONE'){echo 'selected="selected"';} ?>>NONE [Default]</option>
					<option value="GOOGLE" <?php if($config['jQuery_cdn'] == 'GOOGLE'){echo 'selected="selected"';} ?>>GOOGLE [Recommended]</option>
					<option value="MICROSOFT" <?php if($config['jQuery_cdn'] == 'MICROSOFT'){echo 'selected="selected"';} ?>>MICROSOFT</option>
					<option value="CLOUDFLARE" <?php if($config['jQuery_cdn'] == 'CLOUDFLARE'){echo 'selected="selected"';} ?>>CLOUDFLARE</option>
				</select>
			</center></td>
			<td>Setup cdn for ajax</td>
          </tr>
          <tr>
            <td>bootstrap_cdn</td>
            <td><center>
				<select onchange="save_form('speed', 'Speed')" id="bootstrap_cdn" name="bootstrap_cdn">
					<option value="NONE" <?php if($config['bootstrap_cdn'] == 'NONE'){echo 'selected="selected"';} ?>>NONE [Default]</option>
					<option value="CLOUDFLARE" <?php if($config['bootstrap_cdn'] == 'CLOUDFLARE'){echo 'selected="selected"';} ?>>CLOUDFLARE [Recommended]</option>
					<option value="MAXCDN" <?php if($config['bootstrap_cdn'] == 'MAXCDN'){echo 'selected="selected"';} ?>>MAXCDN</option>
				</select>
			</center></td>
			<td>Bootstrap CDN</td>
          </tr>
		  <tr>
            <td>compress_enabled</td>
            <td><center>
				<select onchange="save_form('speed', 'Speed')" id="compress_enabled" name="compress_enabled">
					<option value="TRUE" <?php if($config['compress_enabled'] == 'TRUE'){echo 'selected="selected"';} ?>>TRUE</option>
					<option value="FALSE" <?php if($config['compress_enabled'] !== 'TRUE'){echo 'selected="selected"';} ?>>FALSE</option>
				</select>
			</center></td>
			<td>Turn on or off server compression</td>
          </tr>
		  <tr>
            <td>compress_level</td>
            <td><center>
				<select onchange="save_form('speed', 'Speed')" id="compress_level" name="compress_level">
					<option value="1" <?php if($config['compress_level'] == '1'){echo 'selected="selected"';} ?>>1</option>
					<option value="2" <?php if($config['compress_level'] == '2'){echo 'selected="selected"';} ?>>2</option>
					<option value="3" <?php if($config['compress_level'] == '3'){echo 'selected="selected"';} ?>>3</option>
					<option value="4" <?php if($config['compress_level'] == '4'){echo 'selected="selected"';} ?>>4</option>
					<option value="5" <?php if($config['compress_level'] == '5'){echo 'selected="selected"';} ?>>5</option>
					<option value="6" <?php if($config['compress_level'] == '6'){echo 'selected="selected"';} ?>>6</option>
					<option value="7" <?php if($config['compress_level'] == '7'){echo 'selected="selected"';} ?>>7</option>
					<option value="8" <?php if($config['compress_level'] == '8'){echo 'selected="selected"';} ?>>8</option>
					<option value="9" <?php if($config['compress_level'] == '9'){echo 'selected="selected"';} ?>>9</option>
				</select>
			</center></td>
			<td>Set the compression level</td>
          </tr>
        </tbody>
      </table>
          </div>
		  </form>
		  <!-- eof Speed -->
		  <!-- Start Security -->
		  <span id="security_save"><h2>Security</h2></span>
		  <form name="security_form" id="security_form" action="test.php" method="post">
		  <div class="table-responsive">
          <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width:15%">$config[ ]</th>
            <th style="width:20%">Value</th>
			<th style="width:65%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Force_SSL</td>
            <td><center>
				<select onchange="save_form('security', 'Security')" id="Force_SSL" name="Force_SSL">
					<option value="TRUE" <?php if($config['Force_SSL'] == 'TRUE'){echo 'selected="selected"';} ?>>TRUE</option>
					<option value="FALSE" <?php if($config['Force_SSL'] !== 'TRUE'){echo 'selected="selected"';} ?>>FALSE</option>
				</select>
			</center></td>
			<td>This option forces HTTPS:// to be used on all of this ManageMC installation. HTTPS:// needs to be enabled first before selecting true</td>
          </tr>
          <tr>
            <td>ManageMC_Domain</td>
            <td><center><input type="text" name="ManageMC_Domain" autocomplete="off" value="<?php echo $config['ManageMC_Domain']; ?>" onchange="save_form('security', 'Security')"></center></td>
			<td>This is the domain that ManageMC will only run on if $config['ManageMC_URL_Checks'] is set to TRUE.</td>
          </tr>
		  <tr>
            <td>ManageMC_URL_Checks</td>
            <td><center><select onchange="save_form('security', 'Security')" id="ManageMC_URL_Checks" name="ManageMC_URL_Checks">
					<option value="TRUE" <?php if($config['Max_Login_Errors_Reset'] == 'TRUE'){echo 'selected="selected"';} ?>>TRUE</option>
					<option value="FALSE" <?php if($config['Max_Login_Errors_Reset'] !== 'TRUE'){echo 'selected="selected"';} ?>>FALSE</option>
				</select>
			</center></td>
			<td>Enable URL checking, this will force ManageMC to only run on the domain defined in $config['ManageMC_Domain']</td>
          </tr>
          <tr>
			<td>Max_Login_Errors_Per_IP</td>
            <td><center><input type="number" name="Max_Login_Errors_Per_IP" id="Max_Login_Errors_Per_IP" autocomplete="off" value="<?php echo $config['Max_Login_Errors_Per_IP']; ?>" onchange="save_form('security', 'Security')" style="width:40px;"></center></td>
			<td>How many times can an IP have a login error before they get IP Banned</td>
          </tr>
	    <tr>
			<td>Max_Login_Errors_Reset</td>
            <td><center><input type="number" name="Max_Login_Errors_Reset" id="Max_Login_Errors_Reset" autocomplete="off" value="<?php echo $config['Max_Login_Errors_Reset']; ?>" onchange="save_form('security', 'Security')" style="width:40px;"></center></td>
			<td>How long the IP Ban should last before reset.</td>
          </tr>
        </tbody>
      </table>
          </div>
		  </form>
		  <!-- eof Security -->
		  </div>
        </div>
    </div>
    </div><!-- /row -->
    <?php }elseif ($page == "hostsettings") {?>
        <div class="panel panel-info">
          <div class="panel-body">
		  <!-- Start SSH Config -->
		  <span id="ssh_save"><h2>SSH Config</h2></span>
		  <form name="ssh_form" id="ssh_form" action="test.php" method="post">
		  <div class="table-responsive">
          <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width:15%">$config[]</th>
            <th style="width:20%">Value</th>
			<th style="width:65%">Description</th>
          </tr>
        </thead>
        <tbody>	
         <tr>
            <td>Host_SSH_Username</td>
            <td><center><input type="text" name="Host_SSH_Username" id="Host_SSH_Username" autocomplete="off" value="<?php echo $config['Host_SSH_Username']; ?>" onchange="save_form('ssh', 'SSH Config')"></center></td>
			<td>SSH, Username for the server ManageMC is hosted on, either root or a sudo user.</td>
          </tr>
          <tr>
            <td>Host_SSH_Password</td>
            <td><center><input type="password" name="Host_SSH_Password" id="Host_SSH_Password" autocomplete="off" value="" onchange="save_form('ssh', 'SSH Config')"></center></td>
			<td>Password for the server ManageMC is hosted on. (Only enter if you are changing the password.)</td>
          </tr>
        </tbody>
      </table>
      
      <h2>CronTab</h2>
      <pre>
      <?php
	  
	  $ssh = new Net_SSH2('127.0.0.1');
   		if (!@$ssh->login($config['Host_SSH_Username'], $config['Host_SSH_Password'])) {}
		else{
		echo $server  = $ssh->exec('crontab -u root -l');
		}
		?></pre>
          </div>
		  </form>
		  <!-- eof SSH Config -->
		  </div>
        </div>
    </div>
    </div><!-- /row -->
    <?php }elseif ($page == "advanced") {?>
        <div class="panel panel-info">
          <div class="panel-body">
		  <!-- Start Debuging Config -->
	    <span id="debuging_save"><h2>Debuging</h2></span>
	    <form name="debuging_form" id="debuging_form" action="test.php" method="post">
	    <div class="table-responsive">
          <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width:15%">$config[]</th>
            <th style="width:20%">Value</th>
	    <th style="width:65%">Description</th>
          </tr>
        </thead>
        <tbody>	
          <tr>
            <td>managemc_debug_renderconfigvariables</td>
            <td><center>
	    <select onchange="save_form('debuging', 'Debuging')" id="managemc_debug_renderconfigvariables" name="managemc_debug_renderconfigvariables">
					<option value="TRUE" <?php if(!isset($config['managemc_debug_renderconfigvariables'])){$config['managemc_debug_renderconfigvariables'] = 'FALSE';}
					if($config['managemc_debug_renderconfigvariables'] == 'TRUE'){echo 'selected="selected"';} ?>>TRUE</option>
					<option value="FALSE" <?php if($config['managemc_debug_renderconfigvariables'] !== 'TRUE'){echo 'selected="selected"';} ?>>FALSE</option>
				</select>
	    </center>
	    <td>Show config variables at the top of the page</td>
          </tr>
	  
	  <tr>
            <td>managemc_debug_error_reporting</td>
            <td><center>
	    <select onchange="save_form('debuging', 'Debuging')" id="managemc_debug_error_reporting" name="managemc_debug_error_reporting">
					<option value="0" <?php if(!isset($config['managemc_debug_error_reporting'])){$config['managemc_debug_error_reporting'] = 0;}
					if($config['managemc_debug_error_reporting'] == 0){echo 'selected="selected"';} ?>>0</option>
					<option value="1" <?php if($config['managemc_debug_error_reporting'] == 1){echo 'selected="selected"';} ?>>1</option>
					<option value="2" <?php if($config['managemc_debug_error_reporting'] == 2){echo 'selected="selected"';} ?>>2</option>
				</select>
	    </center>
	    <td>Error reporting level.</td>
          </tr>
        </tbody>
      </table>
          </div>
		  </form>
		  <!-- eof SSH Config -->
		  </div>
        </div>
    </div>
    </div><!-- /row -->
    <?php }
CORE_Render_Footer();
?>

<script>
function save_form($ids, $title)
{
var dataa = $("#"+$ids+"_form").serialize();
$("#"+$ids+"_form :input").attr('disabled', true);
$("#"+$ids+"_save").html('<h2>'+$title+' <img src="images/712.GIF" width="32" height="32"></h2>');
    $.ajax({
           type: "POST",
           url: "test.php",
           data: dataa, // serializes the form's elements.
           success: function(data)
           {
		   $("#"+$ids+"_save").html("<h2>"+$title+"</h2>");
		   $("#"+$ids+"_form :input").attr('disabled', false);
           }
         });
}
</script>
