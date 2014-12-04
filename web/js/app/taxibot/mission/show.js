$(function() {
	
	$.ajax({
		  url: 'http://taxibotupload.azurewebsites.net/home/GetBlfLink',
		  data: {blfName: $('.blf-name').text().trim()},
		  type: "GET",
		  dataType: 'jsonp',		  
		  jsonp: "callback",		  
		  success: function (response) {
			  $('.blf-download')[0].href = response;
		  },
		});
	
	if (Lahav.missionPage.items == null)
		return;

	var categories = [];
	var data = [];

	Lahav.missionPage.items.forEach(function(item, index, array) {
		categories.push(item[0]);

		var dateStart = new Date(item[1]);
		var dateEnd = new Date(item[2]);

		data.push([ dateStart.getTime(), dateEnd.getTime() ]);
	});

	function convertTime(inputFormat) {
		function pad(s) {
			return (s < 10) ? '0' + s : s;
		}
		var d = new Date(inputFormat);

		return [ pad(d.getUTCHours()), pad(d.getUTCMinutes()),
				pad(d.getUTCSeconds()) ].join(':');
	}
	
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});

	$(".mission-chart").highcharts(
			{
				chart : {
					type : 'columnrange',
					inverted : true,
					zoomType : 'y'
				},
				
				xAxis : {
					categories : categories,
					gridLineWidth : 1
				},

				title : {
					text : 'Mission Parts'
				},

				yAxis : {
					type : 'datetime',
					dateTimeLabelFormats : {
						second : '%H:%M:%S',
						minute : '%H:%M',
						hour : '%H',
					},
					gridLineWidth : 0
				},

				tooltip : {
					formatter : function() {
						console.log(this);
						return '<b>'
								+ this.x
								+ '</b> started at <b>'
								+ Highcharts.dateFormat('%H:%M:%S',
										this.point.low)
								+ '</b> and ended at <b>'
								+ Highcharts.dateFormat('%H:%M:%S',
										this.point.high) + '</b>';
					}
				},

				plotOptions : {
					columnrange : {
						dataLabels : {
							inside : true,
							align : 'center',
							enabled : true,
							formatter : function() {
								return convertTime(this.point.high
										- this.point.low);
							}
						}
					}
				},

				legend : {
					enabled : false
				},

				series : [ {
					data : data
				} ]

			});

});