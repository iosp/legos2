<h1>Failure History</h1>


<div id="time_interval_table_container">
	<table class="time_interval_table" id="time_interval_table" border="1"
		cellpadding="5">
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
	<div id="tabs" >
	
		<ul>
			<li><a href="#tabs-1">Table</a></li>
			<li><a href="#tabs-2">Graph</a></li>
		</ul>
		
		<div id="tabs-1">
			
			<div id="table_container">
				<h1><?php echo 'RESULT'; ?></h1>
				<table class="daten" id="taxibot-towing" border="1" >
					<thead>
						<tr>
							<th>Failure</th>
							<th>Dates</th>							
							<th>Taxibot Number</th>
							<th>Failure Family</th>	
							<th>Mode of Operations</th>
							<th>Mission</th>			
						</tr>
					</thead>
					<tbody>
			
						<?php foreach( $ser_one_arr as $failure ): ?>
							<tr>
						
								<td><?php echo  $failure->getName();  ?></td>
							
								
								<td><?php echo $failure->getDates(); ?></td>
							
								
								<td><?php echo $failure->getTaxibotNumber(); ?></td>
							
								
								<td><?php echo $failure->getFailureFamily();; ?></td>
							
								
								<td><?php echo $failure->getModeOfOperation();; ?></td>
								
								
								<td><?php echo $failure->getMission();; ?></td>
				
					
							</tr>
						<?php endforeach; ?>
				
					</tbody>
		
		
		
				</table>
			</div>
		
		</div>
	
		<div id="tabs-2">
		</div>
	</div>
</div>
<?php  echo use_javascript ( 'jquery.min.js' ); 
			use_javascript ( 'jquery-ui.custom.min.js' );
			use_stylesheet ( 'jquery-ui-1.8.16.custom.css' );
			use_javascript ( 'highcharts.js' );
			?>

 <script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<script type="text/javascript">
var chart;


jQuery(document).ready(function() {
	//
	// A simple column chart
	//
	
	
	//
	// Time series line chart
	//
	chart = new Highcharts.Chart({
			chart: {
				renderTo: 'tabs-2',
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
