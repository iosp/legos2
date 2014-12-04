$(document).ready( function() {	
	var lastcancelId = -1;
	$("#dialog-alert").hide();
	//return;
    var timer  = setInterval(function() {				    	
		$.ajax({
	    	type: "POST",				    	
	    	url:  window.Lahav.limitExccedAlertUrl + "/lastid/" + lastcancelId,
	 		success: function (result){
				var data = $.parseJSON(result);
				lastcancelId = data.lastIdMessage;
	 			if (data.isError) {
					$( "#dialog-alert" ).dialog({
						//autoOpen: true,
			   			closeOnEscape: true, 
			   			modal: true,
			   			width: 700,
			   			height:700,
			   			//dialogClass: 'dialogButtons',			   		
			   			buttons: [{ text: "Close window",
		   			        	    click: function() { $( this ).dialog( "close" ); }
			   			          }]
			         });
					
					var date = new Date(data.dataCancel.date);
					
					$("#date_cancel")
						.text("Cancel Flight - Overload, Safe Limit")
						.append("<div>" + data.dataCancel.time + ", " + date.toDateString() + "</div>");
					
					$("#airline").text(data.dataCancel.airline);
					$("#ac_type").text( data.dataCancel.ac_type);
					$("#tail_number").text(data.dataCancel.tail_number );
					$("#taxibot_id").text( data.dataCancel.taxibot_id );
					$("#driver_id").text( data.dataCancel.driver_id );
					$("#position_lat").text( data.dataCancel.position_lat  );
					$("#position_lon").text( data.dataCancel.position_lon  );
					$("#additional_information").text( data.dataCancel.additional_information );
					
					$( ".ui-dialog-titlebar a" ).text('X');
					$( ".ui-dialog-buttonset" ).appendTo('#dialog-alert');
					$('#dialog-alert #dialog-iai-legos').remove();
					$('#dialog-alert').append('<div id="dialog-iai-legos">IAI-LEGOS</div>');
					$( ".ui-dialog-buttonset button" )
						.addClass('dialog-close-button')
						.prepend('<span class="dialog-close-button-icon">X</span>');
					$('#dialog-alert').css("height","560px");
		 	    }
	 		},
	    	error: function (result){
		    	console.log('error' + result.error.msg  );
				clearInterval(timer);
	 		}
		});
	}, 1000);
 }); 