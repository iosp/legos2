<table>
<?php foreach ($daise as $d):?>
	<tr>
		<td><?php echo $d->getTaxibotTractor()->getName();?></td>
		<td><?php echo $d->getTrip(); ?></td>
	</tr>
<?php endforeach;?>
</table>