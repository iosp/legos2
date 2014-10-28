<?php use_helper('Form', 'Javascript')?>

<h1>Gruppenübersicht</h1>

<?php include_partial( 'form', array( 'form' => $form ) )?>

<table class="daten">
	<thead>
		<tr>
			<th>Benutzer</th>
			<th>Gruppe</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; ?>
		<?php foreach( $benutzer_gruppe as $user ): ?>
			<tr
			class="<?php (($i % 2) == 0) ? print "ungerade" : print "gerade" ?> clickable_highlighting">
			<td><?php echo $name_select_array [ $user->getbenutzerid() ] ?></td>
			<td><?php echo $group_select_array [ $user->getgruppeid() ] ?></td>
		</tr>
			<?php $i++; ?>
		<?php endforeach; ?>
	</tbody>
</table>
