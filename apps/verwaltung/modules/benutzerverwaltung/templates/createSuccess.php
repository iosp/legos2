<?php use_helper( 'Object', 'Validation' )?>

<?php echo form_tag( 'benutzerverwaltung/update' )?>


<h1>Neuen Benutzer anlegen</h1>

<?php include_partial( 'form', array( 'form' => $form ) )?>

<hr />
<?php echo link_to( 'Zurück', 'benutzerverwaltung/list' )?>
