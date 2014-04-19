$(window).load(function(){$('#landing').modal('show');});

	    var frm = $('#delete_server');
    	frm.submit(function (ev) {
		document.getElementById("delete_server_go").disabled = true; 
		$( "#message" ).css( "display", "none" );
		$( "#locadinggif" ).css( "display", "block" );
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
				if(data == "1")
				{
					$('#landing').modal('hide');
					$('#complete').modal('show');
				}
				
				else
				{
					alert("Something went wrong");
				}
            }
        });

        event.preventDefault();
    });