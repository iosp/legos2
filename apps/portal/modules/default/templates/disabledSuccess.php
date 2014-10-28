<?php echo image_tag('/sf/sf_default/images/icons/disabled48.png', array('alt' => 'module disabled', 'class' => 'sfTMessageIcon', 'size' => '48x48'))?>
<h1>Dieses Modul wurde deaktiviert. Bitte wenden Sie sich an den
	Administrator.</h1>

<hr />

<h2>Sie können nun...</h2>
<ul>
	<li><a href="javascript:history.go(-1)">...zurück zur vorherigen Seite
			gehen.</a></li>
	<li><?php echo link_to('...zur Startseite des Moduls zurück gehen', '@homepage') ?></li>
</ul>