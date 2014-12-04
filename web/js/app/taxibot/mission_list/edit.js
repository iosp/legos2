$(function() {
	$('#taxibot-missions-list').on('change', '.operaional-select', function() {
		var $select = $(this);
		
		var result = confirm("Change database and update mission?");
		if (!result) {
			$select.val($select.attr('data-selected'));
			return;
		}
		
		var newValue = $select.val();
		var rowId = $select.closest('tr').attr('data-mission-id');
		var propertyName = $select.closest('td').attr('data-property-name');

		$select.attr('data-selected', newValue);
		savePropertyMission(rowId, propertyName, newValue);
	});
	
	$('#taxibot-missions-list').on( 'draw.dt', function(){
		$('.operaional-select').prop("disabled",false);
		$('.operaional-select').removeClass('remove-arrow');
	});	

	function savePropertyMission(missionId, propertyName, newValue) {
		

		var data = {};
		data.propertyName = propertyName;
		data.missionId = missionId;
		data.value = newValue;

		$.ajax({
			data : {
				data : data
			},
			url : "../mission_list/saveproperty",
			type : "POST",
		}).done(function(data) {
			var t = data;
		}).fail(function(data) {
			var t = data;
		});

	}
	
	$('#taxibot-missions-list').on('dblclick', '.td-edit-text', function() { 
		var $tdtext = $(this);
		var oldText = $tdtext.text();
		$tdtext.text("");
		$tdtext
				.append('<input type="text" class="operational-type-input" value="'
						+ oldText + '"></input>');

		var $input = $tdtext.find('input');
		$input.css('display', 'inline-block');
		$input.css('width', '80%');
		$input.focus();

		$input.blur(function() {
			finishEditCell($tdtext, $input, oldText);
		});

		$input.keypress(function(e) {
			if (e.which == 13) {
				finishEditCell($tdtext, $input, oldText);
			}
		});

		$input.dblclick(function(event) {
			event.stopPropagation();
		});		
	});
	
	function finishEditCell($tdtext, $input, oldValue) {
		
		var result = confirm("Change database and update mission?");
		if (!result) {
			$tdtext.text(oldValue);
			return;
		}
		var newValue = $input.val();

		if (oldValue == newValue) {
			$tdtext.text(oldValue);
			return;
		}

		if ($tdtext.hasClass('date-format')
				&& !is_valid_date(newValue)) {
			$tdtext.text(oldValue);
			alert("The new date time is not valid format!");
		} else {
			var missionId = $tdtext.closest('tr').attr(
					'data-mission-id');
			var currentProperty = $tdtext.closest('td')
					.attr('data-property-name');

			savePropertyMission(missionId, currentProperty,
					newValue);

			$tdtext.text(newValue);
		}
	}

	$('#mission-delete')
			.on(
					'click',
					function(event) {
						var rows = Lahav.MissionList.getRowsChecked();

						if (rows.length == 0) {
							return;
						}

						var result = confirm("Change Database and Delete Mission from Legos system?");
						if (!result) {
							return;
						}

						rows
								.forEach(function(tr) {
									var missionId = $(tr).attr(
											"data-mission-id") * 1;
									if (missionId > 0) {
										$('#delete-indicator').removeClass(
												'undisplay-indicator');
										$('#mission-delete').addClass(
												'button-clicked');
										$
												.ajax(
														{
															url : "../mission_list/delete?id="
																	+ missionId,
															type : "POST",
															context : tr
														})
												.done(
														function(data) {
															var tableMissions = $(
																	'#taxibot-missions-list')
																	.DataTable();
															tableMissions.row(
																	this)
																	.remove()
																	.draw();
															$(
																	'#delete-indicator')
																	.addClass(
																			'undisplay-indicator');
															$('#mission-delete')
																	.removeClass(
																			'button-clicked');
															Lahav.MissionList.resetButton();
															Lahav.MissionList.updateTitleSelected();
														});
									}
								});
					});

	$('#mission-confirm').on('click', function(event) {
		var rows = Lahav.MissionList.getRowsChecked();

		if (rows.length == 0) {
			return;
		}

		var missionsIsd = [];
		rows.forEach(function(tr) {
			var missionId = $(tr).attr("data-mission-id") * 1;
			missionsIsd.push(missionId);
		});

		if (missionsIsd.length > 0) {
			$('#confirm-indicator').removeClass('undisplay-indicator');
			$('#mission-confirm').addClass('button-clicked');
			$.ajax({
				url : "../mission_list/confirm",
				type : "POST",
				data : {
					missionsIsd : missionsIsd
				}
			}).done(function(data) {
				// alert(data);
				var isDone = JSON.parse(data);
				if (isDone) {
					location.reload();
				}
			});
		}
	});

	$('#mission-merge')
			.on(
					'click',
					function(event) {
						var rows = Lahav.MissionList.getRowsChecked();

						if (rows.length == 0) {
							return;
						}

						if (rows.length == 1) {
							alert("Select at least 2 missions for merge");
							return;
						}

						var result = confirm("Change Database and merge Missions from Legos system?");
						if (!result) {
							return;
						}

						var missionsIsd = [];
						rows.forEach(function(tr) {
							var missionId = $(tr).attr("data-mission-id") * 1;
							missionsIsd.push(missionId);
						});

						if (missionsIsd.length > 0) {
							$('#merge-indicator').removeClass(
									'undisplay-indicator');
							$('#mission-merge').addClass('button-clicked');
							$.ajax({
								async : false,
								url : "../mission_list/merge",
								type : "POST",
								data : {
									missionsIsd : missionsIsd
								}
							}).done(function(data) {
								var isDone = JSON.parse(data);
								if (isDone) {
									location.reload();
								}
							});
						}
					});

	function is_valid_date(value) {
		// capture all the parts
		var matches = value
				.match(/^(\d{4})\-(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/);
		if (matches === null) {
			return false;
		} else {
			// now lets check the date sanity
			var year = parseInt(matches[1], 10);
			var month = parseInt(matches[2], 10) - 1; // months are 0-11
			var day = parseInt(matches[3], 10);
			var hour = parseInt(matches[4], 10);
			var minute = parseInt(matches[5], 10);
			var second = parseInt(matches[6], 10);
			var date = new Date(year, month, day, hour, minute, second);
			if (date.getFullYear() !== year || date.getMonth() != month
					|| date.getDate() !== day || date.getHours() !== hour
					|| date.getMinutes() !== minute
					|| date.getSeconds() !== second) {
				return false;
			} else {
				return true;
			}
		}
	}
	

	$('#taxibot-missions-list').on('click', '.checkbox-row input:checkbox',
			function() {
				Lahav.MissionList.resetButton();
				Lahav.MissionList.updateTitleSelected();
			});
	
	Lahav.MissionList.resetButton =  function () {
		var selectedRows = Lahav.MissionList.getRowsChecked().length;
		if (selectedRows == 1) {
			$('#mission-page .yellow-button').removeClass('disabled');			
			$('#mission-delete .yellow-button').removeClass('disabled');
			$('#mission-merge .yellow-button').addClass('disabled');
			$('#mission-split .yellow-button').removeClass('disabled');
			$('#mission-confirm .yellow-button').removeClass('disabled');
			
			$('#mission-page').removeClass('disabled');			
			$('#mission-delete').removeClass('disabled');
			$('#mission-merge').addClass('disabled');
			$('#mission-split').removeClass('disabled');
			$('#mission-confirm').removeClass('disabled');
		} else if (selectedRows > 1) {
			$('#mission-page .yellow-button').addClass('disabled');
			$('#mission-delete .yellow-button').removeClass('disabled');
			$('#mission-merge .yellow-button').removeClass('disabled');
			$('#mission-split .yellow-button').addClass('disabled');
			$('#mission-confirm .yellow-button').removeClass('disabled');
			
			$('#mission-page').addClass('disabled');
			$('#mission-delete').removeClass('disabled');
			$('#mission-merge').removeClass('disabled');
			$('#mission-split').addClass('disabled');
			$('#mission-confirm').removeClass('disabled');
		} else {
			$('#mission-page .yellow-button').addClass('disabled');
			$('#mission-delete .yellow-button').addClass('disabled');
			$('#mission-merge .yellow-button').addClass('disabled');
			$('#mission-split .yellow-button').addClass('disabled');
			$('#mission-confirm .yellow-button').addClass('disabled');
			
			$('#mission-page').addClass('disabled');
			$('#mission-delete').addClass('disabled');
			$('#mission-merge').addClass('disabled');
			$('#mission-split').addClass('disabled');
			$('#mission-confirm').addClass('disabled');
		}
	}
});