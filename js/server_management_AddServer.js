$(window).load(function(){
	document.getElementById("ip").focus();
	$('#landing').modal('show');
	});

	    var frm = $('#add_server_check');
    	frm.submit(function (ev) {
		document.getElementById("add_server_check_go").disabled = true; 
		$( "#message" ).css( "display", "none" );
		$( "#locadinggif" ).css( "display", "block" );
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
				if(data == "222")
				{
					$( "#message_cont" ).html( "We detected that the ip you supplied already exists in the database. Please check the server list and remove this server first" );
					$( "#message" ).css( "display", "block" );
					$( "#locadinggif" ).css( "display", "none" );
					document.getElementById("add_server_check_go").disabled = false;
				}
				else if(data == "100")
				{	$( "#message_cont" ).html( "Password Empty." );
					$( "#message" ).css( "display", "block" );
					$( "#locadinggif" ).css( "display", "none" );
					document.getElementById("add_server_check_go").disabled = false;
				}
				else if(data == "000")
				{	
					$( "#message_cont" ).html( "IP & Password Empty." );
					$( "#message" ).css( "display", "block" );
					$( "#locadinggif" ).css( "display", "none" );
					document.getElementById("add_server_check_go").disabled = false;
				}
				else if(data == "010")
				{
					$( "#message_cont" ).html( "IP invalid" );
					$( "#message" ).css( "display", "block" );
					$( "#locadinggif" ).css( "display", "none" );
					document.getElementById("add_server_check_go").disabled = false;
				}
                else if(data == "110")
				{
					$( "#message_cont" ).html( "Password wrong or unable to connect to ssh." );
					$( "#message" ).css( "display", "block" );
					$( "#locadinggif" ).css( "display", "none" );
					document.getElementById("add_server_check_go").disabled = false;
				}
				else if(data == "11os")
				{
					$( "#message_cont" ).html( "We detected that your not running CentOS. Please go and reinstall the server with the latest stable release of CentOS." );
					$( "#message" ).css( "display", "block" );
					$( "#locadinggif" ).css( "display", "none" );
					document.getElementById("add_server_check_go").disabled = false;
				}
				
				else if(data == "111")
				{
					$( "#locadinggif" ).css( "display", "none" );
					$('#landing').modal('hide');
					$('#installing').modal('show');
					step1();
				}
            }
        });

        event.preventDefault();
    });
	
	
	
	
	
	
function step1(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=1",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Installing Screen, Nano, Wget & Java-1.7.0-openjdk" );
					$('#stage_num').html( "2" );
					step2();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step2(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=2",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Removeing Old init.d Script" );
					$('#stage_num').html( "3" );
					step3();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step3(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=3",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Downloading init.d Script" );
					$('#stage_num').html( "4" );
					step3a();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step3a(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=3a",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Installing New init.d Script" );
					$('#stage_num').html( "4" );
					step4();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step4(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=4",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Setting users up" );
					$('#stage_num').html( "5" );
					step5();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step5(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=5",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Creating 1 of 2 Directories" );
					$('#stage_num').html( "6" );
					step6();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step6(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=6",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Creating 2 of 2 Directories" );
					$('#stage_num').html( "7" );
					step7();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}

function step7(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=7",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Installing Minecraft Files" );
					$('#stage_num').html( "8" );
					step8();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}
function step8(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=8",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					$('#task').html( "Setup Complete" );
					step9();
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}
function step9(){
$.ajax({
			type: "GET",
			dataType: "json",
			url: "/api/post/install.php?s=9",
			data: frm.serialize(),
            success: function (data) {
				if(data["status"] == "1")
				{
					window.location.replace("server_management.php?page=ManageServer&uid=" + data["Server_UID"]);
				}
				else
				{	
					alert("Something went wrong!");
				
				}
            }
        });
}