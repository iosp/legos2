<?php use_helper( 'Menu', 'Auswahl' )?>

<h1>Towing Activities</h1>

<?php

echo auswahlFilter ( array (
		'Tag' 
), null, $route, array (
		'Schlepper' 
), '' );
?>
