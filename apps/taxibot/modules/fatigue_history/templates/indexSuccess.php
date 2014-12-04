<?php use_helper( 'Global', 'Javascript',  'Selection' )?>

<h1>Fatigue History</h1>


<?php

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot', 'FatigueHistory' 
), '' );
?>