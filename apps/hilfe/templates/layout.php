<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
		<?php use_helper( 'Javascript' )?>
		<?php include_http_metas()?>
		<?php include_metas()?>
		<?php include_title()?>
		<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body>
		<?php echo $sf_content?>
		<br />
	<br />
	<br />
	<div class="form_table" align="left"><?php echo link_to_function( 'Fenster schließen', 'window.close()' ) ?></div>
</body>
</html>
