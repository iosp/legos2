<?php
/**
 * Skript zum Kopieren der Schleppdaten aus den csv-Dateien in die Datenbank. Der eigentliche
 * Import befindet sich in "/lib/import.class.php".
 */
require_once (dirname ( __FILE__ ) . '/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration ( 'training'  /*app level !!!*/, 'prod', true );
sfContext::createInstance ( $configuration );

// initialize database manager
$databaseManager = new sfDatabaseManager ( $configuration );
$databaseManager->loadConfiguration ();

if ($argc != 4) {
	echo "Import-Script (PHP) started without date parameter.";
	exit ( 1 );
}

if (is_numeric ( $argv [1] ) && is_numeric ( $argv [2] ) && is_numeric ( $argv [3] )) {
	$import = new ImportTaxibotLog ( $argv [1], $argv [2], $argv [3] );
	$import->import ();
}

?>
