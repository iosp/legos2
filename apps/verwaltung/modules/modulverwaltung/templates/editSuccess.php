<?php use_helper('Object')?>

<?php echo form_tag( 'modulverwaltung/edit' )?>

<?php echo object_input_hidden_tag( $modul, 'getId' )?>

<?php include_partial( 'form', array( 'form' => $form ) )?>

<hr />
<?php echo link_to( 'Zur&uuml;ck', 'modulverwaltung/list', array( 'class' => 'pfeil' ) )?>
