<?php use_helper('Javascript')?>

<div style="float: left">
	<?php if ( isset( $day_from ) && $activities == null ): ?>
		<?php echo javascript_tag()?>
			jQuery().toastmessage(
				'showToast', {
					text     : 'There is no data available in the selected date range.',
					type     : 'error',
					stayTime : 7500,
					position : 'top-right'
			});
			// Move toast-container to the beginning of #'page_content' so he can appear top right
			jQuery('#page_content').prepend(jQuery('.toast-container'));
		<?php echo end_javascript_tag()?>
	<?php else: ?>
</div>

<table id="tabelle-taxibot-towing" class="daten" titel="Activities"
	zusatz_link='<?php echo link_to( image_tag( "excel_icon_trans.png", array( "class" => "excelexport" ) ), "activities/ExcelExportXML", "class=excelexport" );?>'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Flight Number</th>
			<th>Tractor</th>
			<th>Departure</th>
			<th>On Position</th>
			<th>Completed</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $activities as $activity ): ?>
		<tr class="clickable_highlighting">
			<td><?php echo $activity->getId(); ?>
			
			
			<td><?php echo $activity->getTrip(); ?></td>
			<td><?php echo $activity->getTaxibotTractor(); ?></td>
			<td><?php echo $activity->getDeparture(); ?></td>
			<td><?php echo $activity->getReady(); ?></td>
			<td><?php echo $activity->getCompleted(); ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php endif; ?>
