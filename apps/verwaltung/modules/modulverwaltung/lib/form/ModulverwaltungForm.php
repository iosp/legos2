<?php
class ModulverwaltungForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'name' => new sfWidgetFormInputText () 
		) );
		
		$this->widgetSchema->setLabels ( array (
				'name' => 'Name*:' 
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
				) ) 
		)
		 );
		
		$this->widgetSchema->setNameFormat ( 'modulverwaltung[%s]' );
		
		parent::setup ();
	}
}
?>