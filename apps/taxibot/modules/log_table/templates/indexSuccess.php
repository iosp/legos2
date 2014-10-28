<?php use_helper( 'Global', 'Javascript', 'Selection' )?>

<h1>Log Table</h1>

<?php

echo selectionFilter ( array (
		'Einzeltag' 
), '', $route, array (
		'Taxibot' 
), '' );
?>