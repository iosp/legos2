<h1>List of towing activities</h1>

<p>All activities of Tractor ID 1:</p>
<ul>
<?php foreach( $activities as $activity ): ?>
	<li><?php echo $activity->getId(); ?> (<?php echo $activity->getTaxibotTractor(); ?>)</li>
<?php endforeach; ?>
</ul>


<p>All activities of Tractor S03 (JOIN statement):</p>
<ul>
<?php foreach( $activities_two as $activity ): ?>
	<li><?php echo $activity->getId(); ?> (<?php echo $activity->getTaxibotTractor(); ?>)</li>
<?php endforeach; ?>
</ul>


<p>All activities of Tractor S03 and S05 (JOIN statement and OR
	statement):</p>
<table class="normal">
	<head>
	
	
	<tr>
		<th>ID</th>
		<th>Tractor</th>
		<th>Departure</th>
	</tr>
	</head>
	<body>
		<?php $i=0?>
		<?php foreach( $activities_three as $activity ): ?>
			
	
	
	<tr class="<?php echo ($i % 2 ? "gerade" : "ungerade") ?>">
		<td><?php echo $activity->getId(); ?></td>
		<td><?php echo $activity->getTaxibotTractor(); ?></td>
		<td><?php echo $activity->getDeparture('H:i:s'); ?></td>
	</tr>
			<?php $i++; ?>
		<?php endforeach; ?>
	</body>
</table>


<p>All activities after 12 o'clock (LIMIT 5):</p>
<ul>
<?php foreach( $activities_four as $activity ): ?>
	<li><?php echo $activity->getId(); ?> (<?php echo $activity->getTaxibotTractor(); ?>), <?php echo $activity->getDeparture('Y-m-d H:i:s'); ?></li>
<?php endforeach; ?>
</ul>
