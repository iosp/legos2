$(function(){
	$('.th-operational').css('width' , 0);
	if($('#taxibot-missions_list tr').find('.dataTables_empty').length == 0){
		$('#taxibot-missions_list tr:first').prepend('<div class="checkbox-row"></div>');
		$('#taxibot-missions_list tr:gt(0)').prepend('<td class="checkbox-row"><input type="checkbox"></td>');		
	}
	
	$('#mission-delete .yellow-button').addClass('disabled');
	$('#mission-merge .yellow-button').addClass('disabled');
	$('#mission-split .yellow-button').addClass('disabled');	
	$('#mission-confirm').remove();
	$('.operaional-select').prop("disabled",true);
	$('.operaional-select').addClass('remove-arrow');
	
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
	

	function getRowsChecked(){
		var rows = []; 
		
		$('#taxibot-missions_list input:checkbox').toArray().forEach(function(elem, index, array){
			if(elem.checked){				
				rows.push($(elem).closest('tr')[0]);	
			}
		});
		return rows;
	}
	
}); 