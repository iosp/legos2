<table class="daten no_footer" titel="<?php echo $titel ?>">
	<thead>
		<tr>
			<th>Name</th>
			<th>Beschreibung</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0;?>
		<?php foreach( $gruppen as $gruppe ): ?>
			<tr
			class="<?php (($i % 2) == 0) ? print "gerade" : print "ungerade" ?>">
			<td><?php echo $gruppe->getName() ?></td>
			<td><?php echo $gruppe->getBeschreibung() ?></td>
			<td>
					<?php if ( $zugeordnete ): ?>
						<?php echo link_to( image_tag( 'icons/delete.png', array( 'alt' => 'Gruppe entfernen', 'title' => 'Gruppe entfernen', 'border' => '0' ) ), 'benutzerverwaltung/deleteGruppe?benutzer_id='.$benutzerID.'&gruppe_id='.$gruppe->getID() )?>
					<?php else: ?>
						<?php echo link_to( image_tag( 'icons/add.png', array( 'alt' => 'Gruppe hinzufügen', 'title' => 'Gruppe hinzufügen', 'border' => '0' ) ), 'benutzerverwaltung/addGruppe?benutzer_id='.$benutzerID.'&gruppe_id='.$gruppe->getID() )?>
					<?php endif; ?>
				</td>
		</tr>
			<?php $i++; ?>
		<?php endforeach; ?>
	</tbody>
</table>
