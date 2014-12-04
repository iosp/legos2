$(function() {

	var longData = [];
	var latData = [];
	var veolcityData = [];
	var tillerData = [];
	var breakData = [];

	Lahav.fatigueHistory.items.forEach(function(item, index, array) {
		var date = new Date(item[0]);
		var timestamp = date.getTime();
		longData.push([ timestamp, item[1] ]);
		latData.push([ timestamp, item[2] ]);
		veolcityData.push([ timestamp, item[3] ]);
		tillerData.push([ timestamp, item[4] ]);
		breakData.push([ timestamp, item[5] ]);
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
	veolcityData.sort(Comparator);
	tillerData.sort(Comparator);
	breakData.sort(Comparator);
	
	
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});

	// create the chart
	var chart = $('#chart').highcharts('StockChart', {
		
		
        
		chart : {			 
			zoomType : 'x'
		},
		
		rangeSelector: {
            enabled: false
        },

		tooltip : {

		},

		plotOptions : {
			series : {
				point : {
					events : {
						mouseOver : function() {
							// $reporting.html('x: ' + this.x + ', y: ' +
							// this.y);
						}
					}
				},
				events : {
					mouseOut : function() {
						// $reporting.empty();
					}
				}
			}
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
		// , plotLines : [ {
		// color : 'gray',
		// width : 2,
		// value : longData[0][0],
		// zIndex : 5
		// } ]
		},

		yAxis : [ {
			max : 100,
			title : {
				margin : 60,
				text : 'Longitudinal (kN)',
				rotation : 0,
				x : -40
			},
			labels : {
				format : ' ',
			},
			height : '16%',
			gridLineWidth : 0,
			opposite : false,
			plotLines : [ {
				color : '#FF0000',
				dashStyle : 'shortdash',
				width : 1,
				value : Lahav.fatigueHistory.longSafe,
				label : {
					text : 'Safe ' + Lahav.fatigueHistory.longSafe,
					align : 'left',
					x : -60,
					y : 2
				}
			}, {
				color : 'yellow',
				dashStyle : 'shortdash',
				width : 1,
				value : Lahav.fatigueHistory.longfatig,
				zIndex : 5,
				label : {
					text : 'Ftge ' + Lahav.fatigueHistory.longfatig,
					align : 'left',
					x : -60,
					y : 2
				}
			} ]
		}, {
			max : 55,
			title : {
				margin : 60,
				text : 'Lateral (kN)',
				rotation : 0,
				x : -53
			},
			labels : {
				format : ' ',

			},
			top : '21%',
			height : '16%',
			offset : 0,
			gridLineWidth : 0,
			opposite : false,
			plotLines : [ {
				color : 'red',
				dashStyle : 'shortdash',
				width : 1,
				value : Lahav.fatigueHistory.latSafe,
				label : {
					text : 'Safe ' + Lahav.fatigueHistory.latSafe,
					align : 'left',
					x : -60,
					y : 2
				}
			} ]
		}, {
			max : 30,
			min : -3,
			title : {
				margin : 60,
				text : 'Veolcity (Knots)',
				rotation : 0,
				x : -44
			},
			labels : {
				format : ' ',

			},
			top : '42%',
			height : '16%',
			offset : 0,
			gridLineWidth : 0,
			opposite : false,
			plotLines : [ {
				color : 'yellow',
				dashStyle : 'shortdash',
				width : 1,
				value : 23,
				label : {
					text : '23',
					align : 'left',
					x : -20,
					y : 2
				}
			} ]
		}, {			
			title : {
				margin : 60,
				text : 'Tiller (Deg)',
				rotation : 0,
				x : -57
			},
			labels : {
				format : ' ',

			},
			top : '63%',
			height : '16%',
			offset : 0,
			gridLineWidth : 0,
			opposite : false,
			plotLines : [ {
				color : 'gray',
				dashStyle : 'shortdash',
				width : 1,
				value : -90,
				label : {
					text : '-90',
					align : 'left',
					x : -40,
					y : 2
				}
			}, {
				color : 'gray',
				dashStyle : 'shortdash',
				width : 1,
				value : 90,
				label : {
					text : '90',
					align : 'left',
					x : -40,
					y : 2
				}
			} ]
		}, {
			title : {
				margin : 60,
				text : 'Break Event',
				rotation : 0,
				x : -52
			},
			labels : {
				format : ' ',

			},
			top : '84%',
			height : '16%',
			offset : 0,
			gridLineWidth : 0,
			opposite : false,
		} ],

		series : [ {
			name : 'long',
			data : longData,
			type : 'area'
		}, {
			type : 'area',
			name : 'lateral',
			data : latData,
			yAxis : 1
		}, {
			type : 'area',
			name : 'Veolcity',
			data : veolcityData,
			yAxis : 2
		}, {
			type : 'line',
			name : 'Tiller',
			data : tillerData,
			yAxis : 3
		}, {
			type : 'column',
			name : 'Break Event',
			data : breakData,
			yAxis : 4,

		} ]
	});

});