<?php
header("content-type: application/javascript");
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/server.php');
?>
var elem = document.querySelector('#toggle_log');
var elem2 = document.querySelector('#auto_refresh');
var init = new Switchery(elem);
var init2 = new Switchery(elem2);
$(document).ready(function () {
    server_info();
    filemanager();
    on_load();
	control();
});
function server_info() {
$.ajax({
        type: "GET",
        url: "/api/get/server_management_manageserver.php?uid=<?php echo $_GET['uid']; ?>",
        success: function (a) {
            if (a.CLIENT_ID == "nill") {
                $("#NewWarning").css("display", "block");
            }
            $("#UID_Table").html(a.UID);
            $("#IP_Table").html(a.IP);
            $("#STATUS_Table").html(a.STATUS);
            $("#ms_Table").html(a.ms);
            $("#STATUS_WorldSize").html(a.mcsize);
            $("#diskspaceb").css("width", a.diskfreep);
            $("#diskspacevalue").html(a.diskfreep);
            $("#disktotal").html(a.disktotal);
            $("#diskused").html(a.diskused);
            $("#ManageMCVersion").html(a.ManageMCVersion);
        }
    })
}
function filemanager() {
$.ajax({
        type: "JSON",
        url: "/api/get/filemanager.php?uid=<?php echo $_GET['uid']; ?>&remote_dir=/home/minecraft/minecraft/",
        success: function (a) {
            $("#filemanager").html(a.table);
        }
    })
}

function on_load() {
    $(".load0").val("0").trigger("change");
    $(".load1").val("0").trigger("change");
    $(".load2").val("0").trigger("change");
    clock()
}

function clock() {
    var c = $(".load0"),
        b = $(".load1"),
        a = $(".load2");
    $.getJSON("api/get/server_load.php?uid=<?php echo $_GET['uid']; ?>", {
        mode: 1
    }, function (d) {
        var h = "";
        for (var f = 0; f < d.length; f++) {
            load0_100 = d[f].load0_100;
            load1_100 = d[f].load1_100;
            load2_100 = d[f].load2_100;
            load0 = d[f].load0;
            load1 = d[f].load1;
            load2 = d[f].load2;
            time = d[f].time;
            var e = Math.max(load0, load1, load2);
            var g = "0";
            var j = Math.round(e * Math.pow(10, g)) / Math.pow(10, g);
            newmax = (j + 1) * 100;
            if (e < 1) {
                newmax = "100"
            }
        }
        $("#load0").fadeOut(200, function () {});
        $("#load1").fadeOut(200, function () {});
        $("#load2").fadeOut(200, function () {});
        $(".load0").trigger("configure", {
            max: newmax
        });
        $(".load1").trigger("configure", {
            max: newmax
        });
        $(".load2").trigger("configure", {
            max: newmax
        });
        c.val(load0_100).trigger("change");
        b.val(load1_100).trigger("change");
        a.val(load2_100).trigger("change");
        $("#load0").html(load0);
        $("#load1").html(load1);
        $("#load2").html(load2);
        $("#load0").fadeIn(500, function () {});
        $("#load1").fadeIn(500, function () {});
        $("#load2").fadeIn(500, function () {});
        $("#knobinner").css("display", "block");
        $("#knobtext").css("display", "block");
        setTimeout("clock()", 5000)
    })
};

$("#UpdateManageMC").click(function () {
$("#loading_img").toggle("fast");
$("#updatemanagemc_text").html('<p>Please wait while ManageMC is being updated on this node</p>');
$("#updatemanagemc_version").html('');
$("#updatemanagemc").modal("show");
		$("#UpdateManageMC").prop('disabled', true);
        $.ajax({
            type: "JSON",
            url: "/api/get/server_update_managemc.php?uid=<?php echo $_GET['uid']; ?>",
            success: function (e) {
            $("#loading_img").toggle("fast");
                if (e.msg == "1") {
                    $("#updatemanagemc_text").html('<p>ManageMC has been successfully updated to the latest version.<br />You can now close this dialog</p><br /><button type="button" class="btn btn-info" data-dismiss="modal">OK</button>');
                    server_info();
                    $("#updatemanagemc_version").html('<code>New Version: ' + e.version + '</code><br />');
                    server_info();
					$("#UpdateManageMC").prop('disabled', false);
                } else {
                server_info();
                	$("#updatemanagemc_text").html('<p>There was a problem updating ManageMC.<br />Please try again in a few moments</p><code>' + e.msg + '</code><br /><br /><button type="button" class="btn btn-info" data-dismiss="modal">OK</button>');
                    $("#UpdateManageMC").prop('disabled', false);
                }
            }
        })
    });

function control() {
	$("#loading").toggle("fast");
	$("#status_img").toggle("fast");
	$.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=status",
            data: $(this).serialize(),
            success: function (e) {
				$("#control_delete").prop('disabled', false);
				$("#loading").toggle("fast");
				$("#status_img").toggle("fast");
                if (e == 1) {
					$("#status").html("<?php echo Get_STATUS_COLOUR("ONLINE"); ?>");
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#last_rersault").prepend("***** ManageMC found the server <b>ONLINE</b> *****<br />");
                } else if (e == 0) {
					$("#status").html("<?php echo Get_STATUS_COLOUR("ONLINE"); ?>");
					$("#control_start").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
                    $("#last_rersault").prepend("***** ManageMC found the server <?php echo Get_STATUS_COLOUR("ONLINE"); ?> *****<br />");
                }
				else {
					$("#status").html("<?php echo Get_STATUS_COLOUR("UNKNOWN"); ?>");
					$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                    $("#last_rersault").prepend("***** ManageMC had a problem checking the server *****<br />");
                }
            }
        })

	$("#toggle_log").change(function() {
    $("#last_rersault").toggle();
	}); 
	
    $("#control_start").click(function () {
		$("#last_rersault").prepend(timestamp() + "ManageMC is starting the server<br />");
		disable_all();
        $.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=start",
            data: $(this).serialize(),
            success: function (e) {
				$("#control_delete").prop('disabled', false);
                if (e) {
                    $("#last_rersault").prepend(e);
					check_status();
                } else {
                    $("#last_rersault").prepend("An Error Occurred. Check your connection");
                   	$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                }
            }
        })
    });
	
	$("#control_stop").click(function () {
		$("#last_rersault").prepend(timestamp() + "ManageMC is stopping the server<br />");
		disable_all();
        $.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=stop",
            data: $(this).serialize(),
            success: function (e) {
				$("#control_delete").prop('disabled', false);
                if (e) {
                    $("#last_rersault").prepend(e);
					check_status();
                } else {
                    $("#last_rersault").prepend("An Error Occurred. Check your connection");
                   	$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                }
            }
        })
    });
	$("#control_restart").click(function () {
		$("#last_rersault").prepend(timestamp() + "ManageMC is restarting the server<br />");
		disable_all();
        $.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=restart",
            data: $(this).serialize(),
            success: function (e) {
				$("#control_delete").prop('disabled', false);
                if (e) {
                    $("#last_rersault").prepend(e);
					check_status();
                } else {
                    $("#last_rersault").prepend("An Error Occurred. Check your connection");
                   	$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                }
            }
        })
    });
	$("#control_reboot").click(function () {
		$("#last_rersault").prepend(timestamp() + "ManageMC is rebooting the server<br />");
		disable_all();
        $.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=reboot",
            data: $(this).serialize(),
            success: function (e) {
				$("#control_delete").prop('disabled', false);
                if (e) {
                    $("#last_rersault").prepend(e);
					check_status_r();
                } else {
                    $("#last_rersault").prepend("An Error Occurred. Check your connection");
                   	$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                }
            }
        })
    });
	$("#control_refresh").click(function () {
		refresh_s();
    });
}
function disable_all()
{
$("#loading").toggle("fast");
$("#control_start").prop('disabled', true);
$("#control_stop").prop('disabled', true);
$("#control_restart").prop('disabled', true);
$("#control_reboot").prop('disabled', true);
$("#control_refresh").prop('disabled', true);
$("#control_delete").prop('disabled', true);
}
function timestamp()
{
var date;
date = new Date();
date = date.getFullYear() + '-' + ('00' + (date.getMonth()+1)).slice(-2) + '-' + ('00' + date.getDate()).slice(-2) + ' ' + ('00' + date.getHours()).slice(-2) + ':' + ('00' + date.getMinutes()).slice(-2) + ':' + ('00' + date.getSeconds()).slice(-2);
return "<b style='color:#00F;'>>[U]</b> [" + date + "] ";
}
function timestamp_S()
{
var date;
date = new Date();
date = date.getFullYear() + '-' + ('00' + (date.getMonth()+1)).slice(-2) + '-' + ('00' + date.getDate()).slice(-2) + ' ' + ('00' + date.getHours()).slice(-2) + ':' + ('00' + date.getMinutes()).slice(-2) + ':' + ('00' + date.getSeconds()).slice(-2);
return "<b style='color:#FFF;'><[S]</b> [" + date + "] ";
}
function check_status()
{
	$("#status_img").toggle("fast");
	$.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=status&a=1",
            data: $(this).serialize(),
            success: function (e) {
				$("#control_delete").prop('disabled', false);
				$("#loading").toggle("fast");
				$("#status_img").toggle("fast");
                if (e == 1) {
					$("#status").html("<?php echo Get_STATUS_COLOUR("ONLINE"); ?>");
					$("#last_rersault").prepend(timestamp_S() + "ManageMC just confirmed the server is <b>ONLINE</b><br />");
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
                } else if (e == 0) {
					$("#status").html("<?php echo Get_STATUS_COLOUR("ONLINE"); ?>");
					$("#last_rersault").prepend(timestamp_S() + "ManageMC just confirmed the server is <?php echo Get_STATUS_COLOUR("ONLINE"); ?><br />");
					$("#control_start").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
                }
				else {
					$("#status").html("<?php echo Get_STATUS_COLOUR("UNKNOWN"); ?>");
					$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                    $("#last_rersault").prepend("<center>***** ManageMC had a problem checking the server's status. *****</center>");
                }
            }
        })
}
function refresh_s()
{
disable_all();
$("#status_img").toggle("fast");
	$.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=status&a=1",
            data: $(this).serialize(),
            success: function (e) {
				$("#loading").toggle("fast");
				$("#status_img").toggle("fast");
                if (e == 1) {
					if($("#status").text() !== "ONLINE")
					{
					$("#status").html("<?php echo Get_STATUS_COLOUR("ONLINE"); ?>");
					$("#last_rersault").prepend("***** ManageMC found the server <?php echo Get_STATUS_COLOUR("ONLINE"); ?> so updated the status to reflect this change *****<br />");	
					}
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                } else if (e == 0) {
					if($("#status").text() !== "OFFLINE")
					{
					$("#status").html("<?php echo Get_STATUS_COLOUR("OFFLINE"); ?></b>");
					$("#last_rersault").prepend("***** ManageMC found the server <?php echo Get_STATUS_COLOUR("OFFLINE"); ?> so updated the status to reflect this change *****<br />");
					}
					$("#control_start").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                }
				else {
					$("#status").html("<?php echo Get_STATUS_COLOUR("UNKNOWN"); ?>");
					$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                    $("#last_rersault").prepend("<center>***** ManageMC had a problem checking the server's status. *****</center>");
                }
            }
        })
}
function check_status_r()
{
	$("#status").html("<?php echo Get_STATUS_COLOUR("REBOOTING"); ?></b>");
	$("#status_img").css("display", "none");
	$.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=status&a=2",
            data: $(this).serialize(),
            success: function (e) {
                if (e == 1) {
					$("#last_rersault").prepend(timestamp_S() + "ManageMC just confirmed the server is back <?php echo Get_STATUS_COLOUR("ONLINE"); ?> but just confirming again<br />");
					check_status();
				}
				else if (e == 0) {
					check_status_r();
                }
				else {
					$("#status").html("<?php echo Get_STATUS_COLOUR("UNKNOWN"); ?>");
					$("#control_start").prop('disabled', false);
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                    $("#last_rersault").prepend("<center>***** ManageMC had a problem checking the server's status. *****</center>");
                }
            }
        })
}