$(function() {
	window.Lahav = window.Lahav || {}; 
	window.Lahav.MissionList = window.Lahav.MissionList || {}; 
	 
	$('#taxibot-missions-list')
		.next('.table_bottom')
		.find('#taxibot-missions-list_paginate')
		.before("<div class='table-selected'><b class='num-mission-selected'>No</b><b> missions selected</span></b>");
	
	$('#mission-page').on('click', function(event) {
		var rows = Lahav.MissionList.getRowsChecked();

		if (rows.length > 1) {
			alert("Select only one mission to complete your request.");
			return;
		}

		if (rows.length == 0) {
			return;
		}

		var tr = rows[0];

		var missionId = $(tr).attr("data-mission-id") * 1;
		if (missionId > 0) {
			window.location.href = "../mission/show?missionid=" + missionId;
		}
	});
	
	$('#taxibot-missions-list')
		.on('click', '.checkbox-row input:checkbox',
		function() {
			Lahav.MissionList.resetButton();
			Lahav.MissionList.updateTitleSelected ();
		});

	window.Lahav.MissionList.getRowsChecked = function() {
		var rows = [];

		$('#taxibot-missions-list input:checkbox').toArray().forEach(
				function(elem, index, array) {
					if (elem.checked && !$(elem).hasClass('reset-checkboxes')) {
						rows.push($(elem).closest('tr')[0]);
					}
				});
		return rows;
	}; 
	
	
	window.Lahav.MissionList.updateTitleSelected = 	function (){
		var rowsSelcted = Lahav.MissionList.getRowsChecked().length;
		$('.num-mission-selected').text(rowsSelcted == 0 ? 'No ' : rowsSelcted);
	};

	$(".reset-checkboxes").click(function(event) {

		if ($(this).prop('checked')) {
			$('#taxibot-missions-list input:checkbox').prop('checked', true);
			 
		} else {
			$('#taxibot-missions-list input:checkbox').prop('checked', false);
			 
		}
		Lahav.MissionList.resetButton();
		Lahav.MissionList.updateTitleSelected ();
	});
	
	Lahav.MissionList.resetButton =  function () {
		var selectedRows = Lahav.MissionList.getRowsChecked().length;
		if (selectedRows == 1) {
			$('#mission-page .yellow-button').removeClass('disabled');	
			$('#mission-page').removeClass('disabled');					
		}  else {
			$('#mission-page .yellow-button').addClass('disabled');
			$('#mission-page').addClass('disabled');			
		}
	} 
});