<?php
if ($show_link) {
	echo link_to ( "Hilfe", '/hilfe/pdf/' . $app . '-' . $modul . '.pdf', array (
			'class' => 'pfeil',
			'target' => '_hilfe' 
	) );
	echo "&nbsp;";
}
?>