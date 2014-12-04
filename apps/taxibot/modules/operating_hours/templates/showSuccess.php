<?php
use_helper ( 'Global', 'Javascript', 'Selection' );
echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot',
		'OperatingHours' 
), '', true, false );
?>

<?php
ini_set ( "memory_limit", "2048M" );
set_time_limit ( 1500 );
?>
<div id="content"></div>
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


<div id="mode_table_container" class="col-md-6">
	<h1><?php echo "Taxibot Operating Hours"  ?></h1>
	<table class="daten" id="taxibot-towing" border="1" cellpadding="5">
		<thead>
			<tr>
				<th>Taxibot Number</th>
				<th>Maintenence Tow</th>
				<th>DCM Hours</th>
				<th>PCM Hours</th>
				<th>Total Work Hours</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $tractorTimes as $id => $tractorHours): ?>
			<tr>
				<td><?php echo $tractorHours['TtractorName']; ?></td>
				<td><?php echo $tractorHours['maint'] ;?></td>
				<td><?php echo $tractorHours['dcm'] ;?></td>
				<td><?php echo $tractorHours['pcm']; ?></td>
				<td><?php echo $tractorHours['total'];?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- 	Export Button -->
	<div>
		<br /> 
		<?php echo link_to( 'Export Data' , "operating_hours/export?file=$filenameOperatingHours")?>
	</div>

</div>




<div id="engines_table_container" class="col-md-6">
	<h1><?php echo "Engines Operating Hours"  ?></h1>
	<table class="daten" id="taxibot-towing" border="1">
		<thead>
			<tr>
				<th>Taxibot Number</th>
				<th>Left Engine Total Hours</th>
				<th>Right Engine Total Hours</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $tractorTimes as $id => $tractorHours): ?>
			<tr>
				<td><?php echo $tractorHours['TtractorName']; ?>
				
				
				
				
				<td><?php echo $tractorHours['Left Hours'];?>
				
				
				
				
				<td><?php echo $tractorHours['Right Hours'] ; ?>
			
			
			
			
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- 	Export Button -->
	<div>
		<br /> 
		<?php echo link_to( 'Export Data' , "operating_hours/export?file=$filenameEngines")?>
	</div>


</div>

