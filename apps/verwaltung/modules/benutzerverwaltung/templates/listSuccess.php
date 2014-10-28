<?php use_helper( 'Javascript' )?>

<h1>Benutzerverwaltung</h1>
<br />

<table class="daten">
	<thead>
		<tr>
			<th>Login</th>
			<th>Name</th>
			<th>Beschreibung</th>
			<th>Letzter Login</th>
			<th>Anzahl Logins</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; ?>
		<?php foreach( $benutzers as $benutzer ): ?>
			<tr
			class="<?php (($i % 2) == 0) ? print "gerade" : print "ungerade" ?> clickable_highlighting">
			<td><?php echo $benutzer->getLogin() ?></td>
			<td><?php echo $benutzer->getName() ?></td>
			<td><?php echo $benutzer->getBeschreibung() ?></td>
			<td><?php echo $benutzer->getLastLogin() ?></td>
			<td><?php echo $benutzer->getLoginCount() ?></td>
			<td>
					<?php echo link_to( image_tag( 'icons/user_edit.png', array( 'alt' => 'Benutzer bearbeiten', 'title' => 'Benutzer bearbeiten', 'border' => '0' ) ), 'benutzerverwaltung/edit?id='.$benutzer->getID() ) ?>&nbsp;
					<?php echo link_to( image_tag( 'icons/group.png', array( 'alt' => 'Gruppen und Module bearbeiten', 'title' => 'Gruppen und Module bearbeiten', 'border' => '0' ) ), 'benutzerverwaltung/gruppe?benutzer_id='.$benutzer->getID() ) ?>&nbsp;
					<?php echo link_to( image_tag( 'icons/user_delete.png', array( 'alt' => 'Benutzer löschen', 'title' => 'Benutzer löschen', 'border' => '0' ) ), 'benutzerverwaltung/delete?benutzer_id='.$benutzer->getID(), array('confirm' => 'Benutzer wirklich löschen?') )?>
				</td>
		</tr>
			<?php $i++; ?>
		<?php endforeach; ?>
	</tbody>
</table>

<br />
<?php echo image_tag( 'icons/user_add.png', array( 'alt' => 'Symbol Benutzer anlegen', 'title' => 'Neuen Benutzer anlegen', 'border' => '0' ) ) . '&nbsp;' . link_to( 'Neuen Benutzer anlegen', 'benutzerverwaltung/edit' )?>
