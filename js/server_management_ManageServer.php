<?php
header("content-type: application/javascript");
?>
var elem = document.querySelector('#toggle_log');
var elem2 = document.querySelector('#auto_refresh');
var init = new Switchery(elem);
var init2 = new Switchery(elem2);
$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/get/server_management_ManageServer.php?uid=<?php echo $_GET['uid']; ?>",
        success: function (a) {
            if (a.STATUS == "NEW") {
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
            $("#diskused").html(a.diskused)
        }
    })
    on_load();
	control();
});

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
					$("#status").html("<b style='color:#0F0;'>ONLINE</b>");
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#last_rersault").prepend("***** ManageMC found the server <b>ONLINE</b> *****<br />");
                } else if (e == 0) {
					$("#status").html("<b style='color:#F00;'>OFFLINE</b>");
					$("#control_start").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
                    $("#last_rersault").prepend("***** ManageMC found the server <b style='color:#F00;'>OFFLINE</b> *****<br />");
                }
				else {
					$("#status").html("<b>UNKNOWN</b>");
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
date = date.getUTCFullYear() + '-' + ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' + ('00' + date.getUTCDate()).slice(-2) + ' ' + ('00' + date.getUTCHours()).slice(-2) + ':' + ('00' + date.getUTCMinutes()).slice(-2) + ':' + ('00' + date.getUTCSeconds()).slice(-2);
return "<b style='color:#00F;'>>[U]</b> [" + date + "] ";
}
function timestamp_S()
{
var date;
date = new Date();
date = date.getUTCFullYear() + '-' + ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' + ('00' + date.getUTCDate()).slice(-2) + ' ' + ('00' + date.getUTCHours()).slice(-2) + ':' + ('00' + date.getUTCMinutes()).slice(-2) + ':' + ('00' + date.getUTCSeconds()).slice(-2);
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
					$("#status").html("<b style='color:#0F0;'>ONLINE</b>");
					$("#last_rersault").prepend(timestamp_S() + "ManageMC just confirmed the server is <b>ONLINE</b><br />");
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
                } else if (e == 0) {
					$("#status").html("<b style='color:#F00;'>OFFLINE</b>");
					$("#last_rersault").prepend(timestamp_S() + "ManageMC just confirmed the server is <b style='color:#F00;'>OFFLINE</b><br />");
					$("#control_start").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
                }
				else {
					$("#status").html("<b>UNKNOWN</b>");
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
					$("#status").html("<b style='color:#0F0;'>ONLINE</b>");
					$("#last_rersault").prepend("***** ManageMC found the server <b>ONLINE</b> so updated the status to reflect this change *****<br />");	
					}
					$("#control_stop").prop('disabled', false);
					$("#control_restart").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                } else if (e == 0) {
					if($("#status").text() !== "OFFLINE")
					{
					$("#status").html("<b style='color:#F00;'>OFFLINE</b>");
					$("#last_rersault").prepend("***** ManageMC found the server <b style='color:#F00;'>OFFLINE</b> so updated the status to reflect this change *****<br />");
					}
					$("#control_start").prop('disabled', false);
					$("#control_reboot").prop('disabled', false);
					$("#control_refresh").prop('disabled', false);
					$("#control_delete").prop('disabled', false);
                }
				else {
					$("#status").html("<b>UNKNOWN</b>");
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
	$("#status").html("<b style='color:#63F;'>REBOOTING</b>");
	$("#status_img").css("display", "none");
	$.ajax({
            type: "GET",
            url: "/api/get/server_control.php?uid=<?php echo $_GET['uid']; ?>&control=status&a=2",
            data: $(this).serialize(),
            success: function (e) {
                if (e == 1) {
					$("#last_rersault").prepend(timestamp_S() + "ManageMC just confirmed the server is back <b>ONLINE</b> but just confirming again<br />");
					check_status();
				}
				else if (e == 0) {
					check_status_r();
                }
				else {
					$("#status").html("<b>UNKNOWN</b>");
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