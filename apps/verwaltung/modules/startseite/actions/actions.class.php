<?php

/**
 * startseite actions.
 *
 * @package    legos2
 * @subpackage startseite
 * @author     jan
 * @version    SVN: $Id: actions.class.php,v 1.1.2.1 2009-02-02 09:04:50 jgoebel Exp $
 */
class startseiteActions extends sfActions {
	/**
	 * Hier wird das erste Modul aus der aktuellen Applikation gesucht, fuer das der Benutzer die Credentials hat.
	 * Dann wird auf das Modul umgeleitet.
	 */
	public function executeIndex() {
		$creds = $this->getUser ()->listCredentials ();
		$appname = sfConfig::get ( 'sf_app' );
		$laenge = strlen ( $appname );
		foreach ( $creds as $cred ) {
			if (substr ( $cred, 0, $laenge ) == $appname) {
				$modul = substr ( $cred, $laenge + 1 );
				if ($modul != 'startseite')
					break;
			}
		}
		$this->redirect ( $modul . '/index' );
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
}