
<?php use_helper( 'Global', 'Javascript',  'Selection' );
	ini_set('upload_max_filesize', '64M');?>
<h1>Import</h1>



<?php

echo selectionFilter ( array (
		'Einzeltag' 
), 'file', $route, array (
		'Taxibot' ,'Import'
), '' );
?>