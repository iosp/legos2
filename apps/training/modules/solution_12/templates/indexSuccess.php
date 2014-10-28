<h1>Highcharts examples</h1>

<p>This first example is a simple column chart without any highcharts
	options:</p>
<div id="chart_1"></div>

<p>This chart makes use of some highcharts options:</p>
<div id="chart_2"></div>

<script type="text/javascript"><?php // "echo javascript_tag()" from symfony Javascript-Helper would do the same ?>
var chart;
jQuery.noConflict();

jQuery(document).ready(function() {
	//
	// A simple column chart
	//
	chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart_1',
				type: 'column'
			},
			
			title: {
				text: 'Number of activities per tractor'
			},
			
			xAxis: {
				categories: <?php echo $tractor ?>,
				title: {
					text: 'Tractor'
				}
			},
			
			yAxis: {
				title: {
					text: 'Activities'
				}
			},
			
			series: [{
				name: 'Activities',
				data: <?php echo $activities?>
			}]
		});
	
	
	//
	// Time series line chart
	//
	chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart_2',
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
				filename: 'Solution_12_Export_<?php echo date('Y-m-d')?>'
			},
		});
});

</script>
