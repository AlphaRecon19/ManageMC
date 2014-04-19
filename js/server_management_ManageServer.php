<?php
header("content-type: application/javascript");
?>
$(document).ready(function() {
		   
       $.ajax({
       type: "GET",
       url: '/api/get/server_management_ManageServer.php?uid=<?php echo $_GET['uid']; ?>',
       success: function(data)
       {
		   if(data['STATUS'] == "NEW")
		   {
			   $( "#NewWarning" ).css( "display", "block" );
			   $( "#NewWarningButton" ).css( "display", "block" );
		   }
		   
		   	$( "#UID_Table" ).html(data['UID']);
		  	$( "#Server_IP" ).html(data['IP']);
		  	$( "#IP_Table" ).html(data['IP']);
		  	$( "#STATUS_Table" ).html(data['STATUS']);
			$( "#ms_Table" ).html(data['ms']);
		  	$( "#generator-settings_Table2" ).html(data['generator-settings']);
		  	$( "#op-permission-level_Table2" ).html(data['op-permission-level']);
			$( "#allow-nether_Table2" ).html(data['allow-nether']);
		  	$( "#level-name_Table2" ).html(data['level-name']);
		  	$( "#enable-query_Table2" ).html(data['enable-query']);
		  	$( "#allow-flight_Table2" ).html(data['allow-flight']);
		  	$( "#announce-player-achievements_Table2" ).html(data['announce-player-achievements']);
			$( "#server-port_Table2" ).html(data['server-port']);
			$( "#level-type_Table2" ).html(data['level-type']);
		  	$( "#enable-rcon_Table2" ).html(data['enable-rcon']);
		  	$( "#level-seed_Table2" ).html(data['level-seed']);
			$( "#force-gamemode_Table2" ).html(data['force-gamemode']);
			$( "#server-ip_Table2" ).html(data['server-ip']);
		  	$( "#max-build-height_Table2" ).html(data['max-build-height']);
		  	$( "#spawn-npcs_Table2" ).html(data['spawn-npcs']);
			$( "#white-list_Table2" ).html(data['white-list']);
			$( "#spawn-animals_Table2" ).html(data['spawn-animals']);
			$( "#hardcore_Table2" ).html(data['hardcore']);
			$( "#snooper-enabled_Table2" ).html(data['snooper-enabled']);
			$( "#online-mode_Table2" ).html(data['online-mode']);
			$( "#resource-pack_Table2" ).html(data['resource-pack']);
			$( "#pvp_Table2" ).html(data['pvp']);
			$( "#difficulty_Table2" ).html(data['difficulty']);
			$( "#enable-command-block_Table2" ).html(data['enable-command-block']);
			$( "#gamemode_Table2" ).html(data['gamemode']);
			$( "#player-idle-timeout_Table2" ).html(data['player-idle-timeout']);
			$( "#max-players_Table2" ).html(data['max-players']);
			$( "#spawn-monsters_Table2" ).html(data['spawn-monsters']);
			$( "#generate-structures_Table2" ).html(data['generate-structures']);
			$( "#view-distance_Table2" ).html(data['view-distance']);
			$( "#motd_Table2" ).html(data['motd']);
			  
       }
	   
	   
   });
   
   });