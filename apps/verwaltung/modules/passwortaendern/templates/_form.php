<?php include_stylesheets_for_form($form)?>
<?php include_javascripts_for_form($form)?>

<?php use_helper( 'Global', 'Javascript' )?>

<div class="form">
	<?php echo $form->renderFormTag( url_for( $sf_context->getModuleName() . '/index'), array('method' => 'post') )?>
	<div class="form_header">Passwort</div>
	
	<?php if ($form->hasErrors()): ?> 
		<div class="error_box">
			<?php echo image_tag('achtung.png', array( 'border' => '0', 'alt' => 'Fehler' ))?>
			Es sind Fehler im Formular aufgetreten:<br />
			<?php echo $form->renderGlobalErrors()?>
			<?php echo $form['altes_passwort']->renderError()?>
			<?php echo $form['neues_passwort']->renderError()?>
			<?php echo $form['neues_passwort2']->renderError()?>
		</div>
	<?php endif; ?>  
	
	<div class="form_content">
			<?php echo $form['altes_passwort']->renderLabel()?>
			<?php echo $form['altes_passwort']?>
			<br />
			<?php echo $form['neues_passwort']->renderLabel()?>
			<?php echo $form['neues_passwort']?>
			<br />
			<?php echo $form['neues_passwort2']->renderLabel()?>
			<?php echo $form['neues_passwort2']?>
			<br /> <input type="submit" value="Speichern" class="abfragebutton" />
	</div>
	<?php echo form_end_tag()?>
</div>
