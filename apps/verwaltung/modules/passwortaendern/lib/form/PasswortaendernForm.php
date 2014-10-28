<?php
class PasswortaendernForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'altes_passwort' => new sfWidgetFormInputPassword (),
				'neues_passwort' => new sfWidgetFormInputPassword (),
				'neues_passwort2' => new sfWidgetFormInputPassword () 
		) );
		
		$this->setValidators ( array (
				'altes_passwort' => new sfValidatorString ( array (
						'max_length' => 255,
						'required' => true 
				), array (
						'max_length' => 'Das von Ihnen angegebene alte Passwort ist zu lang.',
						'required' => 'Bitte geben Sie Ihr altes Passwort an. Es ist ein Pflichtfeld.' 
				) ),
				'neues_passwort' => new sfValidatorString ( array (
						'min_length' => 6,
						'max_length' => 255,
						'required' => true 
				), array (
						'min_length' => 'Ihr neues Passwort muss mindestens %min_length% Zeichen enthalten.',
						'max_length' => 'Das von Ihnen angegebene neue Passwort ist zu lang.',
						'required' => 'Bitte geben Sie ein neues Passwort an. Es ist ein Pflichtfeld.' 
				) ),
				'neues_passwort2' => new sfValidatorString ( array (
						'min_length' => 6,
						'max_length' => 255,
						'required' => true 
				), array (
						'min_length' => 'Ihr wiederholtes neues Passwort muss mindestens %min_length% Zeichen enthalten.',
						'max_length' => 'Das von Ihnen angegebene wiederholte neue Passwort ist zu lang.',
						'required' => "Bitte wiederholen Sie Ihr neues Passwort. Es ist ein Pflichtfeld." 
				) ) 
		) );
		
		$this->validatorSchema->setPostValidator ( new sfValidatorSchemaCompare ( 'neues_passwort', '==', 'neues_passwort2', array (
				'throw_global_error' => false 
		), array (
				'invalid' => "Die Eingaben des neuen Passworts stimmen nicht überein." 
		) ) );
		
		$this->widgetSchema->setLabels ( array (
				'altes_passwort' => 'Altes Passwort*:',
				'neues_passwort' => 'Neues Passwort*:',
				'neues_passwort2' => 'Neues Passwort wiederholen*:' 
		) );
		
		$this->widgetSchema->setNameFormat ( 'passwortaendern[%s]' );
		
		parent::setup ();
	}
}
?>