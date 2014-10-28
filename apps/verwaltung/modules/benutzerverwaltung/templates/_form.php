<?php include_stylesheets_for_form($form)?>
<?php include_javascripts_for_form($form)?>

<?php use_helper( 'Global' )?>

<?php echo $form->renderFormTag( url_for( $sf_context->getModuleName() . '/edit'), array('method' => 'post') )?>
<div class="form">
	<div class="form_header">Auswahl</div>
		<?php if ($form->hasErrors()): ?> 
			<div class="error_box">
				<?php echo image_tag('achtung.png', array( 'border' => '0', 'alt' => 'Fehler' ))?>
				Es sind Fehler im Formular aufgetreten:<br />
				<?php echo $form->renderGlobalErrors()?>
				<?php echo $form['name']->renderError()?>
				<?php echo $form['login']->renderError()?>
				<?php echo $form['passwort']->renderError()?>
				<?php echo $form['passwort_wiederholen']->renderError()?>
				<?php echo $form['beschreibung']->renderError()?>
			</div>
		<?php endif; ?> 
		
		<div class="form_content">
			<?php echo $form['edit_new']?>
			<?php echo $form['name']->renderLabel()?>
			<?php echo $form['name']?>
			<br />
			<?php echo $form['passwort']->renderLabel()?>
			<?php echo $form['passwort']?>
			<br />
			<?php echo $form['passwort_wiederholen']->renderLabel()?>
			<?php echo $form['passwort_wiederholen']?>
			<br />
			<?php echo $form['login']->renderLabel()?>
			<?php echo $form['login']?>
			<br />
			<?php echo $form['beschreibung']->renderLabel()?>
			<?php echo $form['beschreibung']?>
			<br /> <input type="submit" value="Speichern" class="abfragebutton" />
	</div>
</div>
<?php echo form_end_tag()?>
