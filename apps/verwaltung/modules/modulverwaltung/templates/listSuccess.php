<h1>Modulverwaltung</h1>

<table class="daten">
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
			class="<?php (($i % 2) == 0) ? print "ungerade" : print "gerade" ?> clickable_highlighting">
			<td><?php echo $modul->getName() ?></td>
			<td>
				<?php
			
echo link_to ( image_tag ( 'icons/brick_edit.png', array (
					'alt' => 'Modul bearbeiten',
					'title' => 'Modul bearbeiten',
					'border' => '0' 
			) ), 'modulverwaltung/edit?id=' . $modul->getID () )?>
				<?php
			
echo link_to ( image_tag ( 'icons/brick_delete.png', array (
					'alt' => 'Modul löschen',
					'title' => 'Modul löschen',
					'border' => '0' 
			) ), 'modulverwaltung/delete?id=' . $modul->getID (), 'post=true&confirm=Sind Sie sicher?' )?>
			</td>
		</tr>
		<?php $i++; ?>
	<?php endforeach; ?>
	</tbody>
</table>

<hr />
<?php

echo image_tag ( 'icons/brick_add.png', array (
		'alt' => 'Symbol Modul anlegen',
		'title' => 'Neues Modul anlegen',
		'border' => '0' 
) ) . '&nbsp;' . link_to ( 'Neues Modul anlegen', 'modulverwaltung/edit' ) ?>
