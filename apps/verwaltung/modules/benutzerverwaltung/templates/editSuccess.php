<?php use_helper( 'Object', 'Validation' )?>

<?php echo form_tag( 'benutzerverwaltung/edit' )?>
<?php if ( isset( $benutzer) ) : ?>
<?php echo object_input_hidden_tag( $benutzer, 'getID' )?>
<?php endif;?>

<h1>Benutzerdaten bearbeiten</h1>
<?php include_partial( 'form', array( 'form' => $form ) )?>

<br />
<?php echo link_to( 'Zurück', 'benutzerverwaltung/list', array( 'class' => 'pfeil' ) )?>
