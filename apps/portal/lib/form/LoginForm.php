<?php
class LoginForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'name' => new sfWidgetFormInputText (),
				'passwort' => new sfWidgetFormInputPassword () 
		) );
		
		$this->setValidators ( array (
				'name' => new sfValidatorString ( array (
						'max_length' => 255,
						'required' => true 
				), array (
						'max_length' => 'Der von Ihnen angegebene Benutzername ist zu lang.',
						'required' => 'Bitte geben Sie Ihren Benutzernamen an.' 
				) ),
				'passwort' => new sfValidatorString ( array (
						'max_length' => 255,
						'required' => true 
				), array (
						'max_length' => 'Das von Ihnen angegebene neue Passwort ist zu lang.',
						'required' => 'Bitte geben Sie Ihr Passwort an.' 
				) ) 
		) );
		
		$this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array (
				'callback' => array (
						$this,
						'checkPassword' 
				) 
		) ) );
		
		$this->widgetSchema->setLabels ( array (
				'name' => 'Login:',
				'passwort' => 'Passwort:' 
		) );
		
		$this->widgetSchema->setNameFormat ( 'login[%s]' );
		
		parent::setup ();
	}
	
	/**
	 * Callback-Function des Formular-Post-Validators, die überprüft, ob das Passwort korrekt ist.
	 */
	public function checkPassword($validator, $values) {
		//$e = new Exception;
		//d($e->getTraceAsString());
		 //dd($values);
		// Prüfen, ob der Login-Name bereits vorhanden ist.
		$crit = new Criteria ();
		$crit->add ( BenutzerPeer::LOGIN, $values ['name'] );
		$benutzer = BenutzerPeer::doSelectOne ( $crit );
		
		// Passwort prüfen
		if ($benutzer && $benutzer->pruefePasswort ( $values ['passwort'] )) {
			/*
			 * Zugangsdaten sind korrekt, Benutzer anmelden.
			 */
			sfContext::getInstance ()->getUser ()->setAuthenticated ( true );
			$benutzer->setLastLogin ( date ( 'd.m.Y H:i:s' ) );
			$benutzer->setLoginCount ( $benutzer->getLoginCount () + 1 );
			$benutzer->save ();
			
			/*
			 * Nun den eigentlichen Login durchführen
			 */
			Login::doLogin ( $benutzer );
			
			/*
			 * Die Formularwerte zurückgeben. Damit ist alles paletti.
			 */
			return $values;
		}
		
		/*
		 * Wenn wir hier landen, dann waren die Zugangsdaten falsch (entweder existiert der Benutzer nicht oder das Passwort war falsch). Also einen Formular-Fehler erzeugen, der zum login-Feld gehört.
		 */
		$error = new sfValidatorError ( $validator, 'Login / Passwort falsch.' );
		throw new sfValidatorErrorSchema ( $validator, array (
				'name' => $error 
		) );
	}
}
?>
