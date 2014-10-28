<?php use_helper( 'Global', 'Javascript',  'Selection' )?>

<h1>Limit Exceed</h1>


<?php

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot','LimitExceed'  
), '' );
?>