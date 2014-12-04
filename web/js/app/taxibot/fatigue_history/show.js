$(function() {

	var longData = [];
	var latData = [];

	Lahav.fatigueHistory.items.forEach(function(item, index, array) {
		var date = new Date(item[0]);
		var timestamp = date.getTime();
		longData.push([ timestamp, item[1] ]);
		latData.push([ timestamp, item[2] ]);
	});

	function Comparator(a, b) {
		if (a[0] < b[0])
			return -1;
		if (a[0] > b[0])
			return 1;
		return 0;
	}

	longData.sort(Comparator);
	latData.sort(Comparator);
	
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});

	// create the chart
	var chart = $('#long-chart').highcharts('StockChart', {
 
	    chart: {
	    	zoomType : 'x'
        },
        
		xAxis : {
			type : 'datetime',
			dateTimeLabelFormats : {
				second : '%Y-%m-%d<br/>%H:%M:%S',
				minute : '%Y-%m-%d<br/>%H:%M',
				hour : '%Y-%m-%d<br/>%H:%M',
				day : '%Y<br/>%m-%d',
				week : '%Y<br/>%m-%d',
				month : '%Y-%m',
				year : '%Y'
			}
		},

		yAxis : [ {
			max : 100,
			title : {
				margin : 150,
				text : ' ',
				rotation : 0,
				x : -150
			},
			labels : {
				format : ' ',
			},			
			gridLineWidth : 0,
			opposite : false,
			plotLines : [ 
              {
				color : 'red',
				dashStyle : 'shortdash',
				width : 1,
				value : Lahav.fatigueHistory.longSafe,
				label : {
					text : 'Longitudinal Safety ' + Lahav.fatigueHistory.longSafe,
					align : 'left',
					x : -150,
					y : 2
				}
			},
			{
				color : 'yellow',
				dashStyle : 'shortdash',
				width : 1,
				value : Lahav.fatigueHistory.longfatig,
				zIndex : 5,
				label : {
					text : 'Longitudinal Fatigue ' + Lahav.fatigueHistory.longfatig,
					align : 'left',
					x : -150,
					y : 2
				}
			} ]
		}, {
			max : 55,
			title : {
				margin : 150,
				text : ' ',
				rotation : 0,
				x : -150
			},
			labels : {
				format : ' ',

			},			
			offset : 0,
			gridLineWidth : 0,
			opposite : false,
			plotLines : [ {
				color : 'red',
				dashStyle : 'shortdash',
				width : 1,
				value : Lahav.fatigueHistory.latSafe,
				label : {
					text : 'Lateral Safety ' + Lahav.fatigueHistory.latSafe,
					align : 'left',
					x : -150,
					y : 2
				}
			} ]
		} ],

		series : [ {
			name : 'Longitudinal (kN)',
			marker: {
				 symbol: 'url(' + Lahav.fatigueHistory.flagIcon + ')'
            },
			data : longData,
			type : 'areaspline'
		}, {
			type : 'areaspline',
			marker: {
                symbol: 'url(' + Lahav.fatigueHistory.flagIcon + ')'
            },
			name : 'Lateral (kN)',
			data : latData,
			yAxis : 1
		} ]
	});
	
	return;
});