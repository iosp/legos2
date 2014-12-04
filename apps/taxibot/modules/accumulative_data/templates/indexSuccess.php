<?php use_helper( 'Global', 'Javascript',  'Selection' )?>

<h1>Accumulative Data</h1>


<?php

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot', 'AccumulativeData' 
), '' );
?>