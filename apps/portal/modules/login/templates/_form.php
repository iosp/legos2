<?php include_stylesheets_for_form($form)?>
<?php include_javascripts_for_form($form)?>
<?php use_helper( 'Global', 'Javascript' )?>

<?php echo $form->renderFormTag( url_for( $sf_context->getModuleName() . '/index'), array('method' => 'post') )?>
	
	<?php echo $form['name']->renderLabel(null, array('style' => 'width:70px'))?>
<br />
<?php echo $form['name']?>
<br />
<?php echo $form['passwort']->renderLabel(null, array('style' => 'width:70px'))?>
<br />
<?php echo $form['passwort']?>
	
	<?php if ($form->hasErrors()): ?>
<div class="error_box">
			<?php echo image_tag('achtung.png', array( 'border' => '0', 'alt' => 'Fehler' ))?>
			Es sind Fehler im Formular aufgetreten:<br />
			<?php echo $form['name']->renderError()?>
			<?php echo $form['passwort']->renderError()?>
		</div>
<?php  endif; ?>
<br />

<input type="submit" value="Anmelden" class="abfragebutton" id="login" />

<?php echo form_end_tag()?>

<?php echo javascript_tag("document.forms[0].elements[0].focus();")?>

