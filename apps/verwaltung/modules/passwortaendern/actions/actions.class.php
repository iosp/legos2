<?php

/**
 * passwortaendern actions.
 *
 * @package    legos2
 * @subpackage passwortaendern
 * @author     daniel s.
 */
class passwortaendernActions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		// Erstelle das Formular um das Passwort des aktuell eingelogten Benutzers aendern zu koennen
		$this->form = new PasswortAendernForm ();
		
		// Wenn der Aufruf nach dem Versenden des Formulars erfolgt, so sollen die eingegebenen Daten verarbeiteten werden
		if ($request->isMethod ( 'post' ) || $request->isMethod ( 'put' )) {
			// binde die eingegebenen Daten des Formulars
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			
			// finde die ID des aktuell eingelogten Benutzer heraus
			$benutzer_id = $this->getUser ()->getAttribute ( 'id', '', 'benutzer' );
			// hole die Daten des Benutzers
			$benutzer = BenutzerPeer::retrieveByPK ( $benutzer_id );
			
			// wenn der nur gueltige Angaben enthaelt, dann...
			if ($this->form->isValid ()) {
				// und wenn im Formular angegebene alte Passwort dem alten Passwort des Benutzers entspricht...
				if ($benutzer->pruefePasswort ( $this->form->getValue ( 'altes_passwort' ) )) {
					// dann aendere das Passwort wie gewuenscht
					$benutzer->setPasswort ( $this->form->getValue ( 'neues_passwort' ) );
					$benutzer->save ();
					
					// zeige die erfolgreiche Passwortaenderung an.
					$this->redirect ( 'passwortaendern/aendern' );
				} else {
					// sonst zeige an dass das alte Passwort falsch war
					$this->redirect ( 'passwortaendern/unveraendert' );
				}
			}
		}
	}
	
	/**
	 * Zeigt eine Bestaetigungsseite für erfolgreiche Passwortaenderung an.
	 */
	public function executeAendern() {
		return sfView::SUCCESS;
	}
	
	/**
	 * Zeigt eine Fehlerseite für erfolgslose Passwortaenderung an.
	 */
	public function executeUnveraendert() {
		return sfView::SUCCESS;
	}
}
?>