<?php

/**
 * startseite actions.
 *
 * @package    legos2
 * @subpackage startseite
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1 2008-06-06 13:02:35 jschaffer Exp $
 */
class startseiteActions extends sfActions {
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
