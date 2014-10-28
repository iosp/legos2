<?php

/**
 * startseite actions.
 *
 * @package    legos2
 * @subpackage startseite
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1.2.1 2009-02-02 09:05:43 jgoebel Exp $
 */
class startseiteActions extends sfActions {
	/**
	 * Baut die Portalseite (Übersicht über alle Applikationen und Module)
	 */
	public function executeIndex() {
		// YAML-Datei mit Menüstruktur laden
		$menu = sfYaml::load ( sfConfig::get ( 'sf_root_dir' ) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'menu.yml' );
		
		$this->erlaubteModule = array ();
		foreach ( $menu as $topmenu_entry ) {
			// Es gibt keine Submenüs, wir haben also direkt die Applikation
			if (array_key_exists ( "modules", $topmenu_entry )) {
				$app = $topmenu_entry ['top'];
				
				// Prüfen, ob User Rechte für Module dieser Applikation hat
				if (! $this->getUser ()->isAuthenticated () || ($this->getUser ()->isAuthenticated () && ! in_array ( $topmenu_entry ['applikation'], $this->getUser ()->getAttribute ( 'applikationen', null, 'benutzer' ) ))) {
					continue;
				}
				// Applikationsname und -link holen
				$this->erlaubteModule [$app] = array ();
				$this->erlaubteModule [$app] ['applikation'] = $app;
				$this->erlaubteModule [$app] ['applikation_link'] = $topmenu_entry ['applikation'];
				// Es folgen die Module
				$this->erlaubteModule [$app] ['module'] = array ();
				foreach ( $topmenu_entry ['modules'] as $modul => $name ) {
					// Prüfen, ob der User Rechte für das Modul hat
					if ($this->getUser ()->isAuthenticated () && $this->getUser ()->hasCredential ( $topmenu_entry ['applikation'] . '-' . $modul )) {
						$this->erlaubteModule [$app] ['module'] [] = array (
								$modul => $name 
						);
					}
				}
			} 			// Es gibt Submenüs. Diese gehen wir durch und behandeln sie jeweils als eigene Applikation
			else {
				// Die Bezeichnung des Top-Menüs rauswerfen, weil es hier nicht benötigt wird.
				unset ( $topmenu_entry ['top'] );
				
				foreach ( $topmenu_entry as $submenu_entry ) {
					$app = $submenu_entry ['sub'];
					// Prüfen, ob User Rechte für Module dieser Applikation hat
					if ($this->getUser ()->isAuthenticated () && ! in_array ( $submenu_entry ['applikation'], $this->getUser ()->getAttribute ( 'applikationen', null, 'benutzer' ) )) {
						continue;
					}
					// Applikationsname und -link holen
					$this->erlaubteModule [$app] = array ();
					$this->erlaubteModule [$app] ['applikation'] = $app;
					$this->erlaubteModule [$app] ['applikation_link'] = $submenu_entry ['applikation'];
					// Es folgen die Module
					$this->erlaubteModule [$app] ['module'] = array ();
					foreach ( $submenu_entry ['modules'] as $modul => $name ) {
						// Prüfen, ob der User Rechte für das Modul hat
						if ($this->getUser ()->isAuthenticated () && $this->getUser ()->hasCredential ( $submenu_entry ['applikation'] . '-' . $modul )) {
							$this->erlaubteModule [$app] ['module'] [] = array (
									$modul => $name 
							);
						}
					}
				}
			}
		}
		
		$this->limitExceeds = TaxibotExceedEventPeer::GetRecentLimitExceeds();		 
	}
	
	/**
	 * Leitet auf das Login-Modul im Portal weiter
	 * Wird bei einem Timeout aufgerufen (settings.yml)
	 */
	public function executeLogin() {
		/*
		 * Wenn der User von einer Legos-Seite kommt, dann soll er nach dem Login wieder zu dieser Seite zurück geschickt werden. Dafür speichern wir die URI in der Session.
		 */
		$this->getUser ()->setAttribute ( 'login_redirect', $this->getRequest ()->getUri (), 'benutzer' );
		$this->redirect ( sfConfig::get ( 'app_url_portal' ) . '/login' );
	}
	
	/**
	 * Ermöglicht das Exportieren von Highcharts in verschiedene Dateiformate.
	 * Diese Action wird von allen Charts beim Exportieren aufgerufen.
	 */
	public function executeExportGraph() {
		myExportTools::exportHighchartGraph ();
		return sfView::NONE;
	}
}
