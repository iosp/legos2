$(function() {
	setFlightNumber($("#auswahl_FlightNumber"));
	$("#auswahl_FlightNumber").change(function() {
		saveFlightNumber(this);
	});
	
	setTailNumber($("#auswahl_TailNumber"));
	$("#auswahl_TailNumber").change(function() {
		saveTailNumber(this);
	});
	
	setTractorName($("#auswahl_TaxibotNumber"));
	$("#auswahl_TaxibotNumber").change(function() {
		saveTractorName(this);
	});
	
	setStartTime();
	$("#time-helper").find("[name=from-time-selection]").change(function() {
		saveStartTime(this);
	});
	
	setEndTime();
	$("#time-helper").find("[name=to-time-selection]").change(function() {
		saveEndTime(this);
	}); 
	
	if($('#auswahl_tag_von, #auswahl_tag_bis').length > 0 ){
		$('#auswahl_tag_von, #auswahl_tag_bis').daterangepicker( {
			dateFormat: 'dd.mm.yy',
			presetRanges: [
				{text: 'Yesterday', dateStart: 'yesterday', dateEnd: 'yesterday'},
				{text: 'Last 7 days', dateStart: 'yesterday-7days', dateEnd: 'yesterday'},
				{text: 'Month Untill Yesterday', dateStart: function(){ return Date.parse('today').moveToFirstDayOfMonth();  }, dateEnd: 'yesterday' }
			],
			presets: {
				specificDate: 'Specific Date',
				dateRange: 'Date Range'
			},
			posX:7,
			posY:230,
			rangeStartTitle: 'From',
			rangeEndTitle: 'To',
			doneButtonText: 'OK',
			datepickerOptions: {
				showOtherMonths: 'true',
				selectOtherMonths: 'true',
				closeText: 'Close',
				prevText: '&#x3c; Back',
				nextText: 'Forward &#x3e;',
				currentText: 'Today',
				monthNames: ['January','February','March','April','May','June',
					'July','August','September','October','November','December'],
				monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun',
					'Jul','Aug','Sep','Oct','Nov','Dec'],
				dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				dayNamesShort: ['Su','Mo','Tu','We','Th','Fr','Sa'],
				dayNamesMin: ['Su','Mo','Tu','We','Th','Fr','Sa'],
				weekHeader: 'Week ',
				firstDay: 1
			},
			onChange: function(){
				debugger;
				saveStartDate(); 
				saveEndDate();
			}
		} ); 
		 setStartDefaultDate(); 
		 setEndDefaultDate();
	 }
	 
	 if($('#auswahl_tag_einzeln').length > 0){
		$('#auswahl_tag_einzeln').daterangepicker( {
			dateFormat: 'dd.mm.yy',
			presetRanges: [
				{text: 'Yesterday', dateStart: 'gestern', dateEnd: 'gestern'}
			],
			presets: {
				specificDate: 'Date'
			},
			posX:7,
			posY:252,
			doneButtonText: 'OK',
			datepickerOptions: {
				showOtherMonths: 'true',
				selectOtherMonths: 'true',
				closeText: 'schließen',
				prevText: '&#x3c; zurück',
				nextText: 'Vor &#x3e;',
				currentText: 'heute',
				monthNames: ['January','February','March','April','May','June',
					'July','August','September','October','November','December'],
				monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun',
					'Jul','Aug','Sep','Oct','Nov','Dec'],
				dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				dayNamesShort: ['Su','Mo','Tu','We','Th','Fr','Sa'],
				dayNamesMin: ['Su','Mo','Tu','We','Th','Fr','Sa'],
				weekHeader: 'Wo',
				firstDay: 1
			},
			onChange: function(){								
				saveSingleDate();
				updateSingleDate();
			}
		} );  
		setSingleDate();
	 }
});



