<?php use_helper( 'Javascript' )?>

<h1>Gruppenverwaltung</h1>

<table class="normal">
	<thead>
		<tr>
			<th>Name</th>
			<th>Beschreibung</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; ?>
		<?php foreach( $gruppen as $gruppe ): ?>
			<tr
			class="<?php (($i % 2) == 0) ? print "ungerade" : print "gerade" ?> clickable_highlighting">
			<td><?php echo $gruppe->getName() ?></td>
			<td><?php echo $gruppe->getBeschreibung() ?></td>
			<td>
					<?php echo link_to( image_tag( 'icons/group_edit.png', array( 'alt' => 'Gruppe bearbeiten', 'title' => 'Gruppe bearbeiten', 'border' => '0' ) ), 'gruppenverwaltung/edit?id=' . $gruppe->getID() )?>
					<?php echo link_to( image_tag( 'icons/group_delete.png', array( 'alt' => 'Gruppe löschen', 'title' => 'Gruppe löschen', 'border' => '0' ) ), 'gruppenverwaltung/delete?id=' . $gruppe->getID(), array( 'confirm' => 'Sie löschen diese Gruppe mitsamt aller zugeordneten Benutzer und verknüpfter Berechtigungen.' ) )?>
				</td>
		</tr>
			<?php $i++; ?>
		<?php endforeach; ?>
	</tbody>
</table>

<hr />
<?php

echo image_tag ( 'icons/group_add.png', array (
		'alt' => 'Symbol Gruppe anlegen',
		'title' => 'Neue Gruppe anlegen',
		'border' => '0' 
) ) . '&nbsp;' . link_to_function ( 'Neue Gruppe anlegen', "jQuery('#addGruppe').slideToggle(75);" )?>

<div id="addGruppe">
	<?php include_partial( 'gruppenverwaltung/form', array( 'form' => $form ) )?>
</div>

<?php if( !isset($show_form) ): ?>
	<?php echo javascript_tag()?>
		// Formular muss gerendert werden, damit autowidth() die Breite
		// kennt. Deswegen erst später verstecken.
		$(document).ready(function(){
			jQuery("#addGruppe").hide();
		});
	<?php echo end_javascript_tag()?>
<?php endif; ?>
