<?php use_helper( 'Global', 'Javascript',  'Selection' )?>

<h1>Log History</h1>


<?php

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot',
		'Kontinental',
		'Stoergruende',
		'AircraftTypes',
		'OnlyExceeding' 
), '' );
?>