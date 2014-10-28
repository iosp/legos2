<?php include_stylesheets_for_form($form)?>
<?php include_javascripts_for_form($form)?>

<?php use_helper( 'Global', 'Javascript' )?>

<div class="form" style="margin-bottom: 5px;">
	<?php echo $form->renderFormTag( url_for( $sf_context->getModuleName() . '/index'), array('method' => 'post') )?>
	<div class="form_header">Auswahl</div>

	<div class="form_content">
		<?php echo $form['group']->renderLabel()?>
		<?php echo $form['group']?>
		<br />
		<?php echo $form['user']->renderLabel()?>
		<?php echo $form['user']?>
	</div>
	<?php echo form_end_tag()?>
</div>

<?php echo javascript_tag()?>
	function selectChange(changer) {
		document.forms[0].elements["uebersicht["+changer+"]"].selectedIndex = 0;
		document.forms[0].submit();
	}
<?php echo end_javascript_tag()?>
