<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');

if (isset($_GET['uid']) && !empty($_GET['uid'])) {
    $uid = $_GET['uid'];
}
if (isset($_GET['filepath']) && !empty($_GET['filepath'])) {
    $filepath = $_GET['filepath'];
}
$file = Get_Path($uid,$filepath);
$lines = file($file);
while(empty($lines))
{
sleep (1);
$lines = file($file);
}
Check_Force_SSL();
Check_Login();
Render_Top("Edit File");
Render_Navbar();
Render_Sidebar();
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
            <form method="post" action="#" style="font-size: 16.4px;">
    		<textarea name="content" rows="<?php echo count($lines); ?>" style="width:100%;"><?php
			foreach ($lines as $line_num => $line) {echo "" . htmlspecialchars($line) . "<br />\n";}?></textarea>
			
            <br /><center>
            <input type="submit" class="btn btn-default btn-success" name="save" value="Save" />
            
			<input type="reset" class="btn btn-default btn-warning"name="reset" value="Reset" /> </center></form>
            </div>
        </div>
    </div>
    </div><!-- /row -->
<?php
render_footer();
?>
<script type="text/javascript" src="/lib/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "code",
        "paste"
    ],
    toolbar: "undo redo"
});
</script>
<?php }?>
