$(function(){
	$('.th-operational').css('width' , 0);
	if($('#taxibot-missions_list tr').find('.dataTables_empty').length == 0){
		$('#taxibot-missions_list tr:first').prepend('<div class="checkbox-row"></div>');
		$('#taxibot-missions_list tr:gt(0)').prepend('<td class="checkbox-row"><input type="checkbox"></td>');		
	}
	
	$('.operaional-select').change(function() {
		var $select = $(this);
		var newValue = $select.val();
		var rowId = $select.closest('tr').attr('data-mission-id');
		var propertyName = $select.closest('td').attr('data-property-name');
		
		savePropertyMission(rowId, propertyName, newValue);
	});
	
	$('#mission-mission-page').on('click', function(event){		
		var rows = getRowsChecked();
		
		if(rows.length > 1){
			alert("Select only one mission to complete your request.");
			return;
		}
		
		if(rows.length == 0){			
			return;
		}
		
		var tr = rows[0];
		 
		var missionId = $(tr).attr("data-mission-id") * 1;			
		if(missionId > 0){
			window.location.href = "../mission/show?missionid=" + missionId;		
		}		 
	});
	
	function savePropertyMission(missionId, propertyName, newValue){
		
		var data = {};
		data.propertyName = propertyName;
		data.missionId = missionId;
		data.value = newValue;
		
		$.ajax({
			data: {data: data},
			url: "../mission_list/saveproperty",
			type: "POST",			
		})
		.done(function(data){
			var t = data;	
		});
		
	}
	
	$('.td-edit-text').dblclick(function(){
		var $tdtext = $(this);
		var oldText = $tdtext.text();
		$tdtext.text("");
		$tdtext.append('<input type="text" class="operational-type-input" value="' + oldText +'"></input>');
		
		var $input = $tdtext.find('input');
		$input.css('display','inline-block'); 
		
		$input.blur(function(){
			finishEditCell($tdtext, $input, oldText);
		});
		
		$input.keypress(function(e) {
		    if(e.which == 13) {
		    	finishEditCell($tdtext, $input, oldText);
		    }
		});
		
		$input.dblclick(function(event){			
			event.stopPropagation();
		});
		
		function finishEditCell($tdtext, $input, oldValue){
			var newValue = $input.val();
			
			if(oldValue == newValue){
				$tdtext.text(oldValue);
				return;
			}
			
			if($tdtext.hasClass('date-format') && !is_valid_date(newValue)){
				$tdtext.text(oldValue);
				alert("The new date time is not valid format!");
			}	
			else{
				var missionId = $tdtext.closest('tr').attr('data-mission-id');
				var currentProperty = $tdtext.closest('td').attr('data-property-name');				
				
				savePropertyMission(missionId, currentProperty, newValue);
				
				$tdtext.text(newValue);
			}
		}
	});
	
	function getRowsChecked(){
		var rows = []; 
		
		$('#taxibot-missions_list input:checkbox').toArray().forEach(function(elem, index, array){
			if(elem.checked){				
				rows.push($(elem).closest('tr')[0]);	
			}
		});
		return rows;
	}
	
	$('#mission-delete').on('click', function(event){
		var rows = getRowsChecked();
		
		if(rows.length == 0){			
			return;
		}
		
		var result = confirm("Change Database and Delete Mission from Legos system?");
		if(!result){
			return;
		}
		
		rows.forEach(function(tr) {
			var missionId = $(tr).attr("data-mission-id") * 1;			
			if(missionId > 0){				
				$('#delete-indicator').removeClass('undisplay-indicator');		
				$('#mission-delete').addClass('button-clicked');
				$.ajax({
					url: "../mission_list/delete?id=" + missionId,
					type: "POST",
					 context: tr
				})
				.done(function(data){
					var tableMissions = $('#taxibot-missions_list').DataTable();
					tableMissions.row(this).remove().draw();
					$('#delete-indicator').addClass('undisplay-indicator');		
					$('#mission-delete').removeClass('button-clicked');
					
				});
			}
		});	
	});
	

	$('#mission-marge').on('click', function(event){
		var rows = getRowsChecked();
		
		if(rows.length == 0){			
			return;
		}
		
		if(rows.length == 1){
			alert("Select at least 2 missions for marge");			
			return;
		}
		
		var result = confirm("Change Database and marge Missions from Legos system?");
		if(!result){
			return;
		}
		
		var missionsIsd = [];
		rows.forEach(function(tr) {
			var missionId = $(tr).attr("data-mission-id") * 1;
			missionsIsd.push(missionId);
		});
		
		if(missionsIsd.length > 0){				
			$('#marge-indicator').removeClass('undisplay-indicator');		
			$('#mission-marge').addClass('button-clicked');
			$.ajax({
				async: false,
				url: "../mission_list/marge",
				type: "POST",
				data: {missionsIsd: missionsIsd}
			})
			.done(function(data){
				location.reload(); 				
			});
		}		
	});
	
	function is_valid_date(value) {
	    // capture all the parts
	    var matches = value.match(/^(\d{4})\-(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/);
	    if (matches === null) {
	        return false;
	    } else{
	        // now lets check the date sanity
	        var year = parseInt(matches[1], 10);
	        var month = parseInt(matches[2], 10) - 1; // months are 0-11
	        var day = parseInt(matches[3], 10);
	        var hour = parseInt(matches[4], 10);
	        var minute = parseInt(matches[5], 10);
	        var second = parseInt(matches[6], 10);
	        var date = new Date(year, month, day, hour, minute, second);
	        if (date.getFullYear() !== year
	          || date.getMonth() != month
	          || date.getDate() !== day
	          || date.getHours() !== hour
	          || date.getMinutes() !== minute
	          || date.getSeconds() !== second
	        ) {
	           return false;
	        } else {
	           return true;
	        }
	    
	    }
	}
	
	
}); 