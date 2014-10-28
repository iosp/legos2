<?php include_stylesheets_for_form($form)?>
<?php include_javascripts_for_form($form)?>

<?php use_helper( 'Global', 'Javascript' )?>

<div class="form">
	<?php echo $form->renderFormTag( url_for( $sf_context->getModuleName() . '/edit'), array('method' => 'post') )?>
	<div class="form_header">Modulverwaltung</div>
	
	<?php if( $form->hasErrors() ): ?> 
		<div class="error_box">
			<?php echo image_tag('achtung.png', array( 'border' => '0', 'alt' => 'Fehler' ))?>
			Es sind Fehler im Formular aufgetreten:<br />
			<?php echo $form->renderGlobalErrors()?>
			<?php echo $form['name']->renderError()?>
		</div>
	<?php endif; ?>  
	
	<div class="form_content">
		<?php echo $form['name']->renderLabel()?>
		<?php echo $form['name']?>
		<br /> <input type="submit" value="Speichern" class="abfragebutton" />
	</div>
	<?php echo form_end_tag()?>
</div>
