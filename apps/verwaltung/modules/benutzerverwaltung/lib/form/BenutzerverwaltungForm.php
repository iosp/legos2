<?php
class BenutzerverwaltungForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				// in diesem hidden field wird gespeichert, ob wir editieren oder neu anlegen (für den Callback-Validator nötig)
				'edit_new' => new sfWidgetFormInputHidden (),
				'name' => new sfWidgetFormInputText (),
				'passwort' => new sfWidgetFormInputPassword (),
				'passwort_wiederholen' => new sfWidgetFormInputPassword (),
				'login' => new sfWidgetFormInputText (),
				'beschreibung' => new sfWidgetFormInputText () 
		) );
		
		$this->setValidators ( array (
				'edit_new' => new sfValidatorString ( array (
						'required' => false 
				) ),
				'name' => new sfValidatorString ( array (
						'min_length' => 2,
						'max_length' => 255,
						'required' => true 
				), array (
						'min_length' => 'Ihr Name muss mindestens %min_length% Zeichen lang sein.',
						'max_length' => 'Ihr Name darf nicht länger als %max_length% Zeichen sein.',
						'required' => 'Bitte geben sie einen Namen an.' 
				) ),
				'passwort' => new sfValidatorString ( array (
						'max_length' => 255,
						'required' => true 
				), array (
						'max_length' => 'Das von Ihnen angegebene alte Passwort ist zu lang.',
						'required' => 'Bitte geben Sie ein Passwort an.' 
				) ),
				'passwort_wiederholen' => new sfValidatorString ( array (
						'max_length' => 255,
						'required' => true 
				), array (
						'max_length' => 'Das von Ihnen angegebene Passwort ist zu lang.',
						'required' => 'Bitte geben Sie auch das wiederholte Passwort an.' 
				) ),
				'login' => new sfValidatorString ( array (
						'min_length' => 3,
						'max_length' => 255,
						'required' => true 
				), array (
						'min_length' => 'Das Login muss mindestens %min_length% Zeichen lang sein.',
						'max_length' => 'Das Login darf nicht länger als 255 Zeichen sein.',
						'required' => 'Bitte geben sie ein Login ein.' 
				) ),
				'beschreibung' => new sfValidatorString ( array (
						'required' => false 
				) ) 
		) );
		
		$this->validatorSchema->setPostValidator ( new sfValidatorAnd ( array (
				new sfValidatorSchemaCompare ( 'passwort', '==', 'passwort_wiederholen', array (), array (
						'invalid' => 'Das wiederholte Passwort stimmt nicht mit dem ersten Passwort überein.' 
				) ),
				new sfValidatorCallback ( array (
						'callback' => array (
								$this,
								'checkLoginNameExists' 
						) 
				) ) 
		) ) );
		
		$this->widgetSchema->setLabels ( array (
				'name' => 'Name*:',
				'passwort' => 'Passwort*:',
				'passwort_wiederholen' => 'Passwort wiederholen*:',
				'login' => 'Login*:',
				'beschreibung' => 'Beschreibung:' 
		) );
		
		$this->widgetSchema->setNameFormat ( 'benutzerverwaltung[%s]' );
		
		parent::setup ();
	}
	
	/**
	 * Callback-Function des Formular-Post-Validators, die überprüft, ob der Login-Name eines
	 * neuen Benutzers bereits existiert.
	 * Die Prüfung geschieht in dieser Funktion, da wir nur beim Neuanlegen von Benutzern prüfen
	 * wollen und nicht beim Editieren.
	 */
	public function checkLoginNameExists($validator, $values) {
		// Wenn das hidden field 'edit_new' auf 'new' ist, dann müssen wir prüfen
		if (isset ( $values ['edit_new'] ) && $values ['edit_new'] != 'edit') {
			// Prüfen, ob der Login-Name bereits vorhanden ist.
			$crit = new Criteria ();
			$crit->add ( BenutzerPeer::LOGIN, $values ['login'] );
			if (BenutzerPeer::doSelectOne ( $crit )) {
				// Einen Formular-Fehler erzeugen, der zum login-Feld gehört.
				$error = new sfValidatorError ( $validator, 'Login-Name existiert bereits.' );
				throw new sfValidatorErrorSchema ( $validator, array (
						'login' => $error 
				) );
			}
		}
		// Wenn der Login-Name noch nicht existiert oder wir gar nichts geprüft haben, die sauberen Values zurück geben
		return $values;
	}
}
?>
