<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
if (isset($_GET['uid']) && !empty($_GET['uid'])) {
    $server_uid = $_GET['uid'];
}
if (isset($_GET['filepath']) && !empty($_GET['filepath'])) {
    $filepath = $_GET['filepath'];
}
$file = FILE_Check_File($server_uid,$filepath);
$server_ip = Get_IP($server_uid);
$password = Get_ROOTPASSWORD($server_uid);
if ($file == 0)
{
FILE_Download_File_FTP($server_ip,"root",$password,$filepath,$server_uid,0);
$file = FILE_Get_Path($server_uid,$filepath);
$path_parts = pathinfo($file);
if ($path_parts['extension'] == 'gz')
{
$lines = gzfile($file);
}
else
{
$lines = file($file);	
}
FILE_Delete_File($server_uid,$filepath);
}
else
{
FILE_Delete_File($server_uid,$filepath);
FILE_Download_File_FTP($server_ip,"root",$password,$filepath,$server_uid,0);
$file = FILE_Get_Path($server_uid,$filepath);
$path_parts = pathinfo($file);
if ($path_parts['extension'] == 'gz')
{
$lines = gzfile($file);
}
else
{
$lines = file($file);	
}
FILE_Delete_File($server_uid,$filepath);
}



CORE_Check_Force_SSL();
Check_Login();
CORE_Render_Top("Edit File");
CORE_Render_Navbar();
CORE_Render_Sidebar();
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
}
else
{
$page = "Edit";	
}
    if ($page == "Edit") {
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
    
    <div class="col-md-10">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">Editing <?php echo $filepath; ?></div>
            <div class="panel-body">
            <form method="post" action="#" id="form_editfile" style="font-size: 16.4px;">
    		<textarea id="savefiledata" name="savefiledata" rows="<?php echo count($lines); ?>" style="width:100%; padding-bottom: 50px;"><?php
			foreach ($lines as $line_num => $line) {echo "" . htmlspecialchars($line) . "";}?></textarea>
			
            <br /><center>
            <input type="submit" id="save_button" class="btn btn-default btn-success" name="save" value="Save" />
            
			<input type="reset" class="btn btn-default btn-warning"name="reset" value="Reset" /> </center></form>
            <center><img src="images/712.GIF" width="32" height="32" id="activity_icon" style="display:none;"></center>
            </div>
        </div>
    </div>
    </div><!-- /row -->
<?php
CORE_Render_Footer();
?>
<script type="text/javascript">
$(document).ready(function () {
    	$('#form_editfile').submit(function(e) {
		event.preventDefault();
        $("#activity_icon").toggle();
		$.ajax({
        type: "POST",
        dataType: "json",
        url: "/api/post/filesave.php?<?php echo "Server_UID=" . $_GET["uid"] . "&File_Path=" . $_GET["filepath"]; ?>",
		data: $(this).serialize(),
        success: function (e) {
			$("#activity_icon").toggle();
            alert(e.message);
			<?php echo "window.location = '". $_SERVER["HTTP_REFERER"] . "';"; ?>
        }
    			});
		
    })
})

</script>
<?php }?>
