<h1>Charted log data</h1>

<div id="our_chart"></div>

<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		//
		// Time series line chart
		//
		chart = new Highcharts.Chart({
				chart: {
					renderTo: 'our_chart',
					type: 'line',
					zoomType: 'x',
					animation: false
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
				
				yAxis: {
					title: {
						text: 'Random values'
					}
				},
				
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
					data: <?php echo $data?>
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
					filename: 'log_highcharts__Export_<?php echo date('Y-m-d')?>'
				},
			});
	});

</script>

<?php echo $data ?>