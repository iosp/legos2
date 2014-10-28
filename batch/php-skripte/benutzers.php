<?php
require_once (dirname ( __FILE__ ) . '/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration ( 'training', 'prod', true );
sfContext::createInstance ( $configuration );

// initialize database manager
$databaseManager = new sfDatabaseManager ( $configuration );
$databaseManager->loadConfiguration ();

$benutzers = BenutzerPeer::doSelect ( new Criteria () );

foreach ( $benutzers as $value ) {
	echo $value;
	echo "\n";
	echo $value->getPasswort ();
	echo "\n";
	echo $value->getSaltString ();
	echo "\n";
	echo $value->getPasswortSalted ();
	echo "\n";
}

