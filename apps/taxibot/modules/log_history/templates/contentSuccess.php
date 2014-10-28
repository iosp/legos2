<?php
ini_set ( "memory_limit", "2048M" );
set_time_limit ( 1500 );
?>
<div id="content">
	<div id="table_container">
		<h1><?php echo 'RESULT'; ?></h1>
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
					<?php if($record->getIsExceeding() ){echo ' style="background: red;"';}?>>
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