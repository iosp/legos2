<?php
class GruppenverwaltungForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'name' => new sfWidgetFormInputText (),
				'beschreibung' => new sfWidgetFormInputText () 
		) );
		
		$this->widgetSchema->setLabels ( array (
				'name' => 'Name:',
				'beschreibung' => 'Beschreibung:' 
		) );
		
		$this->setValidators ( array (
				'name' => new sfValidatorString ( array (
						'min_length' => 2,
						'max_length' => 255,
						'required' => true 
				), array (
						'min_length' => 'Ihr Name muss mindestens %min_length% Zeichen lang sein.',
						'max_length' => 'Ihr Name darf nicht länger als %max_length% Zeichen sein.',
						'required' => 'Bitte geben sie einen Namen an.' 
				) ),
				'beschreibung' => new sfValidatorString ( array (
						'required' => false 
				) ) 
		) );
		
		$this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array (
				'callback' => array (
						$this,
						'checkGruppennameExists' 
				) 
		) ) );
		
		$this->widgetSchema->setNameFormat ( 'gruppenverwaltung[%s]' );
		
		parent::setup ();
	}
	
	/**
	 * Callback-Function des Formular-Post-Validators, die überprüft, ob der Gruppenname einer
	 * neuen Gruppe bereits existiert.
	 */
	public function checkGruppennameExists($validator, $values) {
		// Prüfen, ob der Gruppenname bereits vorhanden ist.
		$criteria = new Criteria ();
		$criteria->add ( GruppePeer::NAME, $values ['name'] );
		if (GruppePeer::doSelectOne ( $criteria )) {
			// Einen Formular-Fehler erzeugen, der zum name-Feld gehört.
			$error = new sfValidatorError ( $validator, 'Eine Gruppe mit diesem Namen existiert bereits.' );
			throw new sfValidatorErrorSchema ( $validator, array (
					'name' => $error 
			) );
		}
		// Wenn der Gruppenname noch nicht existiert, die sauberen Values zurück geben
		return $values;
	}
}
?>