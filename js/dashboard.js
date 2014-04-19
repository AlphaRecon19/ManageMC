$(document).ready(function() {
    $.ajax({
       type: "GET",
       url: '/api/get/dashboad.php?cmd=activity_log&limit=5',
       data: $(this).serialize(),
       success: function(data)
       {
		  $('#loaderImage').toggle();
          if (data) {
            $('#Activity_Table').html(data);
          }
          else {
			  $('#Activity_Table').html('Error Loading Data');
          }
       }
   });
   

   
});
$(document).ready(function(){
		var data = {
			"action": "status"
		};
		data = $(this).serialize() + "&" + $.param(data);
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/api/post/dashboad_stats.php",
			data: data,
			success: function(data) {
				$("#server_online").html(data["server_online"]);
				$("#open_ticket").html(data["open_ticket"]);
				$("#client").html(data["client"]);
				$("#servers").html(data["servers"]);
							}
		});
		return false;
});