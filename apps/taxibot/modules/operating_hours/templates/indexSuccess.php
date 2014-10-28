<?php use_helper( 'Global', 'Javascript',  'Selection' )?>

<h1>Operating Hours</h1>

<?php

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot' , 'OperatingHours'
), '' );
?>