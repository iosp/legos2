<?php use_helper( 'Global', 'Javascript',  'Selection' )?>

<h1>Mission</h1>


<?php

echo selectionFilter ( array ( 'Einzeltag'), null, $route, array ( 'Taxibot', 'Mission' ), '' );
?>