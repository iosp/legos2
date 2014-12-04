<?php
require_once dirname ( __FILE__ ) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register ();
class ProjectConfiguration extends sfProjectConfiguration {
	public function setup() {
		// $this->enableAllPluginsExcept( array( 'sfDoctrinePlugin', 'sfCompat10Plugin' ) );
		$this->enableAllPluginsExcept ( array (
				'sfDoctrinePlugin' 
		) );
		
		// Die Zeitzone setzen, damit wir bei der Umstellung Sommer-/Winterzeit keine Fehler im DataWarehouse bekommen.
		date_default_timezone_set ( 'Europe/Berlin' );
		
		/*
		 * Festlegen, wie lange ein Monat in Sekunden ist. Mit diesem Wert wird in den Werkstatt-Applikationen die Wiederkehr von Wartungsterminen in Sekunden berechnet.
		 */
		if (! defined ( 'MONAT_IN_SEKUNDEN' ))
			define ( 'MONAT_IN_SEKUNDEN', 31 * 24 * 60 * 60 );
			
			// config upload path
			/*
		 * sfConfig::add(array( 'sf_upload_dir_name' => $sf_upload_dir_name = 'uploads', 'sf_upload_dir' => sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.$sf_upload_dir_name, ));
		 */
		$this->enablePlugins ( 'sfFeed2Plugin' );
		$this->enablePlugins ( 'sfPropelMigrationsLightPlugin' );
		$this->enablePlugins ( 'drKintPlugin' );
	}
}
