<table class="daten no_footer" titel="<?php echo $titel ?>">
	<thead>
		<tr>
			<th>Modul</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; ?>
		<?php foreach( $module as $modul ): ?>
			<tr
			class="<?php (($i % 2) == 0) ? print "gerade" : print "ungerade" ?>">
			<td><?php echo $modul->getName() ?></td>
			<td>
					<?php if ( $zugeordnete ): ?>
						<?php echo link_to( image_tag( 'icons/delete.png', array( 'alt' => 'Modul entfernen', 'title' => 'Modul entfernen', 'border' => '0' ) ), 'benutzerverwaltung/deleteModul?benutzer_id='.$benutzerID.'&modul_id='.$modul->getID() )?>
					<?php else: ?>
						<?php echo link_to( image_tag( 'icons/add.png', array( 'alt' => 'Modul hinzufügen', 'title' => 'Modul hinzufügen', 'border' => '0' ) ), 'benutzerverwaltung/addModul?benutzer_id='.$benutzerID.'&modul_id='.$modul->getID() )?>
					<?php endif; ?>
				</td>
		</tr>
			<?php $i++; ?>
		<?php endforeach; ?>
	</tbody>
</table>
