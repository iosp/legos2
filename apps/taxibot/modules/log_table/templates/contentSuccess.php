<div id="content">
	<script>
			var isGraphVisible  = true;
			var isTableVisible = false;
			var toToggle = '';
			function toggleTableGraph()
			{
				$("#our_chart").toggle( "blind" );
				$("#table_container").toggle( "blind" );
				
			}
			function toggleBlindGraph(btn)
			{
  				$("#our_chart").toggle( "blind" );
  	
  			//	btn.innerHTML =  isGraphVisible?  "click to show graph...": "click to hide graph...";


  				isGraphVisible = !isGraphVisible;
			}

			function toggleBlindTable(btn)
			{
  				$("#table_container").toggle( "blind" );
  	
  		//	btn.innerHTML =  isTableVisible? "click to show table...": "click to hide table...";
  				


  				isTableVisible = !isTableVisible;
  				
			}
			function showup(btn)
			{
				btn.innerHTML =  "yyy test test test";
			}
	</script>

	<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
	<script src="http://code.jquery.com/ui/1.8.24/jquery-ui.js"></script>
  	<?php use_helper('Javascript')?>
  	
	<div style="float: left">
	<?php if ( isset( $from ) && $records == NULL  ): ?>
		<?php echo javascript_tag()?>
			jQuery().toastmessage(
				'showToast', {
					text     : 'There is no data available for the selected time range.',
					type     : 'error',
					stayTime : 7500,
					position : 'top-right'
			});
			// Move toast-container to the beginning of #'page_content' so he can appear top right
			jQuery('#page_content').prepend(jQuery('.toast-container'));
		<?php echo end_javascript_tag()?>
	<?php else: ?>
	</div>


	<div id="toggleTable">
		<button type="button" onclick="toggleBlindTable(this)"
			style="margin-left: 50px; background: #aaaaaa; font-size: 11px">
			<?php echo image_tag('icons/Database-Table-icon.png'); ?> 		<br />
			Click to toggle table
		</button>

		<div id="table_container">
			<h1>List of Logger Records</h1>
			<table class="daten" id="taxibot-towing" border="1" cellpadding="5">
				<thead>
					<tr>
						<th>NLG Longitudal Force</th>
						<th>Exceeding Amount</th>
						<th>AC Tail Number</th>
						<th>Vehicle Number</th>
						<th>Flight Number</th>
						<th>AC Type</th>
						<th>Time</th>
						<th>Driver Name</th>
						<th>AC Weight</th>
						<th>AC CG</th>
						<th>Location</th>
					</tr>
				</thead>
				<tbody>
		<?php foreach( $records as $record ): ?>
			<tr
						<?php if($record->getNlgLogitudalForce() > $maxFatigue || $record->getNlgLogitudalForce() < $minFatigue){echo ' style="background: red;"';}?>>
						<td><?php echo $record->getNlgLogitudalForce(); ?>
				
						
						<td><?php /*echo $record->getExceedingAmount();*/ ?>
				
						
						<td><?php echo $record->getAircraftTailNumber(); ?>
				
						
						<td><?php /*echo $record->getTractorId();*/ ?>
				
						
						<td><?php /*echo $record->getFlightNumber(); */?>
				
						
						<td><?php echo $record->getAircraftType(); ?>
				
						
						<td><?php echo $record->getUtcTime(); ?>
				
						
						<td><?php /*echo $record->getDriverName();*/ ?>
				
						
						<td><?php /*echo $record->getAircraftWeight();*/ ?>
				
						
						<td><?php /*echo $record->getAircraftCenterGravity();*/ ?>
				
						
						<td><?php echo $record->getLatitude() . " " . $record->getLongitude(); ?>
			
					
					</tr>
		<?php endforeach; ?>
		
		
		</tbody>



			</table>
		</div>

	</div>
	<?php endif; ?>
	<br />
	<br />


	<hr>

	<br />
	<br />
	<!--  
	<div id="toggle" > 	
		<button  type="button" onclick="toggleBlindGraph(this)"   style="margin-left: 50px;  background: #aaaaaa;font-size: 11px">		
			<?php echo image_tag('icons/First-Year-Production-icon.png'); ?>	<br />
			Click to toggle graph	
		</button>	
		
		<div id="our_chart"></div>
	</div>
	
	<script type="text/javascript">
		
		jQuery.noConflict();
		jQuery(document).ready(function() {
			
			// Time series line chart
			
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
					pointSExporttart: Date.UTC(<?php echo date('Y, m, d') ?>),
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

	<br /><br />
	
	<hr>
	-->
	<br />
	<br />

	<div
		style="margin-left: 50px; width: 130px; background: #ccc; font-size: 11px; text-align: center">
		<?php 
			echo image_tag('icons/Excel-icon.png');?>	<br />
		<?php 	echo link_to( 'Export To Excel' , 'log_table/export') ;
		?>
	
	</div>


</div>