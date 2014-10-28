<?php use_helper( 'Javascript' )?>

<?php

echo periodically_call_remote ( array (
		'frequency' => 2,
		'update' => 'update',
		'url' => 'solution_06/render?upper=10&lower=1' 
) )?>

<div id="update"></div>

<div id="content">

	<h1>List of towing activities</h1>



	<table id="taxibot-towing" border="1" cellpadding="5">
		<thead>
			<tr>
				<th>ID</th>
				<th>Flight Number</th>
				<th>Tractor</th>
				<th>Departure</th>
				<th>On Position</th>
				<th>Completed</th>
				<th>Delete activity</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $activities as $activity ): ?>
			<tr>
				<td><?php echo $activity->getId(); ?>
				
				
				<td><?php echo $activity->getTrip(); ?></td>
				<td><?php echo $activity->getTaxibotTractor(); ?></td>
				<td><?php echo $activity->getDeparture(); ?></td>
				<td><?php echo $activity->getReady(); ?></td>
				<td><?php echo $activity->getCompleted(); ?></td>
				<td><?php
			
echo link_to_remote ( image_tag ( 'icons/bin_delete.png', array (
					'alt' => 'Mark activity as deleted',
					'title' => 'Mark activity as deleted',
					'border' => '0' 
			) ), array (
					'url' => 'solution_06/delete?pk=' . $activity->getId (),
					'update' => 'content',
					'loading' => 'Element.hide(\'content\'); Element.show(\'ajax_loading\')',
					'complete' => 'Element.hide(\'ajax_loading\');Element.show(\'content\');',
					'confirm' => 'Delete activity?' 
			) )?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>