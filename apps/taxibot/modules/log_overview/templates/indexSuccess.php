<div id="content">

	<h1>List of towing activities</h1>

	<table class="daten" id="taxibot-towing" border="1" cellpadding="5">
		<thead>
			<tr>
				<th>LogId</th>
				<th>LogFile Number</th>
				<th>Tractor_id</th>
				<th>Load</th>
				<th>Date</th>
				<th>LoadValidity</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $activities as $activity ): ?>
			<tr
				<?php if($activity->getLoadExceeded()){echo ' style="background: red;"';}?>>

				<td><?php echo $activity->getLogId(); ?>
				
				
				<td><?php echo $activity->getLogFile(); ?></td>
				<td><?php echo $activity->getTractorId(); ?></td>
				<td><?php echo $activity->getLoad(); ?></td>
				<td><?php echo $activity->getDate(); ?></td>
				<td><?php echo $activity->getLoadValidity(); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<br />
	<br />
	<div style="width: 100; height: 50; background-color: red">
		<?php echo link_to( 'XML-Export' , 'log_overview/export')?>
	</div>


</div>