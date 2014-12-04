<?php
/**
 * login actions.
 *
 * @package    legos2
 * @subpackage login
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.3.2.1 2009-02-02 09:03:54 jgoebel Exp $
 */
class loginActions extends sfActions {
	public function executeLogin(sfWebRequest $request) {	
		//Kint::trace();	 
		$this->form = new LoginForm ();
		
		// Wenn der Aufruf nach dem Versenden des Formulars erfolgt, so sollen die eingegebenen Daten verarbeiteten werden
		if ($request->isMethod ( 'post' ) || $request->isMethod ( 'put' )) {			
			// binde die eingegebenen Daten des Formulars
			
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) ); 
			 //dd( $request->getParameter ( $this->form->getName () ) );
			// wenn der Formular ordentlich ausgefuellt ist und nur gueltige Angaben enthaelt, dann...
			if ($this->form->isValid ()) {								 
				/*
				 * User zur ursprünglichen Seite zurück schicken. Dazu die URI aus der Session nehmen, die in der jeweiligen Startseiten-Action gesetzt wird.
				 */
				if ($this->getUser ()->hasAttribute ( 'login_redirect', 'benutzer' ) && $this->getUser ()->getAttribute ( 'login_redirect', null, 'benutzer' ) != null) {
					$uri = $this->getUser ()->getAttribute ( 'login_redirect', null, 'benutzer' );
					// Die Session-Variable zuerst wieder zurück setzen.
					$this->getUser ()->setAttribute ( 'login_redirect', null, 'benutzer' );
					$this->redirect ( $uri );
				} else {
					/*
					 * Beim ersten Einloggen weiter zur Hauptseite des aktuellen Moduls.
					 */
					$this->redirect ( '@homepage' );
				}
			}
		}
	}
	public function executeLogout() {
		$this->getUser ()->setAuthenticated ( false );
		$this->getUser ()->clearCredentials ();
		
		// Session-Daten zurücksetzen.
		$this->getUser ()->getAttributeHolder ()->removeNamespace ( 'benutzer' );
		$this->getUser ()->getAttributeHolder ()->remove ( 'werkstattkunde' );
	}
}
