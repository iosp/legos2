<?php
require_once (dirname ( __FILE__ ) . '/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration ( 'portal', 'dev', true );
sfContext::createInstance ( $configuration )->dispatch ();
