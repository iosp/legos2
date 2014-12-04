$(function() {
	var missionsPerDayItems = [];

	Lahav.accumulativeData.items.forEach(function(item, index, array) {
		var date = new Date(item[0]);
		var timestamp = date.getTime();
		missionsPerDayItems.push([ timestamp, item[1] ]);

	});

	function Comparator(a, b) {
		if (a[0] < b[0])
			return -1;
		if (a[0] > b[0])
			return 1;
		return 0;
	}

	missionsPerDayItems.sort(Comparator);

	// create the chart
	
	
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});

	$('#missions-chart').highcharts(
			{
				chart : {
					type : 'spline',					
				},

				xAxis : {
					type : 'datetime',
					dateTimeLabelFormats : { // don't display the dummy year
						month : '%e. %b',
						year : '%b'
					},
					title : {
						text : 'Date'
					}
				},
				
				yAxis : {
					title : {
						text : ''
					},
					min : 0
				},
				
				tooltip : {
					//headerFormat : '<b>{series.name}</b><br>',
					//pointFormat : '{point.x:%e. %b}: {point.y:.2f} m'
				},

				series : [
						{
							name : 'Mission Per Day',						 
							data : missionsPerDayItems
						}, ]
			});

});