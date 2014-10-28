<h1>Failure History</h1>


<div id="time_interval_table_container">
	<table class="time_interval_table" id="time_interval_table" border="1">
		<thead>
			<tr>
				<th>From</th>
				<th>to</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td> <?php echo $from_str?>
				
				
				<td> <?php echo $to_str?>
			
			
			</tr>
			<tr>
				<td> <?php echo "00:01"?>
				
				
				<td> <?php echo "23:59"?>
			
			
			</tr>

		</tbody>
	</table>
</div>
<div id="content">

	
		
		
	
	
		<div id="longitudalChart">
		</div>
	
</div>

<?php  echo use_javascript ( 'jquery.min.js' ); 
			use_javascript ( 'jquery-ui.custom.min.js' );
			use_stylesheet ( 'jquery-ui-1.8.16.custom.css' );
			use_javascript ( 'highcharts.js' );
			?>

<script type="text/javascript">
var chartLongitudal;


jQuery(document).ready(function() {
	//
	// A simple column chart
	//
	
	// Time series line chart
	//
	chartLongitudal = new Highcharts.Chart({
			chart: {
				renderTo: 'longitudalChart',
				type: 'line',
				zoomType: 'x',
				animation: false,
				width: 1100
			},
			
			title: {
				text: 'Random time series data'
			},
			
			subtitle: {
				text: 'Click and drag to zoom'
			},
			
			plotOptions: {
				line: {
					lineWidth: 2,
					marker: {
					enabled: true,
						fillColor: null,
						lineColor: "#FFFFFF",
						lineWidth: 0,
						radius:	0,
						states: {
							hover: {
								enabled: true,
								radius: 5
							}
						}
					}
				}
			},
			
			xAxis: {
				type: 'datetime',
				title: {
					text: null
				}
			},
			
			yAxis: [{
			        labels: {
			    		align: 'right',
			    		x: -3
			    	},
			        title: {
			            text: 'Logitudal (kN)'
			        },
			        height: '60%',
			        lineWidth: 2
			    }, {
			    	labels: {
			    		align: 'right',
			    		x: -3
			    	},
			        title: {
			            text: 'Lateral (kN)'
			        },
			        top: '65%',
			        height: '35%',
			        offset: 0,
			        lineWidth: 2
			    }],
			
			tooltip: {
				enabled: true,
				shared: true,
				valueDecimals: 0,
				xDateFormat: "<b>Time:</b> " + "%H:%M"
			},
			
			series: [{
				type: 'line',
				pointStart: Date.UTC(<?php echo date('Y, m, d') ?>),
				pointInterval: 1000 * 60,
				name: 'Time series 1',
				data: <?php echo $series_one?>
			}, {
				type: 'line',
				pointStart: Date.UTC(<?php echo date('Y, m, d') ?>),
				pointInterval: 1000 * 60,
				name: 'Time series 2',
				data: <?php echo $series_two?>
			}],
			
			exporting: {
				enabled: true,
				url: '<?php echo sfConfig::get('app_url_portal') ?>/startseite/exportGraph',
				buttons: {
					exportButton:{
						enabled: true,
						hoverSymbolFill: '#ffba17',
						hoverSymbolStroke: '#555555',
						menuItems:[ 
							{
								text: '<?php echo image_tag( 'icons/page_white_picture.png', array( 'size' => '16x16', 'alt' => '', 'title' => 'PNG-Export', 'border' => '0' ) ); ?> Export as PNG'
							},
							{
								text: '<?php echo image_tag( 'icons/page_white_picture.png', array( 'size' => '16x16', 'alt' => '', 'title' => 'JPG-Export', 'border' => '0' ) ); ?> Export as JPG'
							},
							{
								text: '<?php echo image_tag( 'icons/page_white_acrobat.png', array( 'size' => '16x16', 'alt' => '', 'title' => 'PDF-Export', 'border' => '0' ) ); ?> Export as PDF'
							},
							{
								text: '<?php echo image_tag( 'icons/page_white_vector.png', array( 'size' => '16x16', 'alt' => '', 'title' => 'SVG-Export', 'border' => '0' ) ); ?> Export as SVG'
							},
							{
								text: '<?php echo link_to( image_tag( 'icons/page_white_excel.png', array( 'size' => '16x16', 'alt' => '', 'title' => 'Excel-Export', 'border' => '0' ) ) . ' Export as XLS', 'solution_12/excelExportXML' ) ?>',
								onclick: function() {
								}
							}
						]
					},
					printButton:{
						enabled: true,
						hoverSymbolFill: '#ffba17',
						hoverSymbolStroke: '#555555'
					}
				},
				filename: 'Longitudal Fatigue<?php echo date('Y-m-d')?>'
			},
		});
});




</script>
