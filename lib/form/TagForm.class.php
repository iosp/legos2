<?php
class TagForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'datum' => new sfWidgetFormDateDynarch ( array (), array (
						'size' => 12 
				) ) 
		) );
		
		$this->widgetSchema->setLabels ( array (
				'datum' => 'Tag:' 
		) );
		
		$this->setValidators ( array (
				'datum' => new sfValidatorDate ( array (
						'required' => true,
						'max' => strtotime ( 'yesterday' ) 
				), array (
						'required' => 'Bitte geben Sie ein Datum an:',
						'invalid' => 'Ungültige Eingabe! Bitte geben Sie ein Datum im Format TT.MM.JJJJ an:',
						'max' => 'Das angegebene Datum muss in der Vergangenheit liegen.' 
				) ) 
		) );
		
		$this->setDefaults ( array (
				'datum' => date ( 'd.m.Y', strtotime ( 'yesterday' ) )  // gestern
				) );
		
		$this->widgetSchema->setNameFormat ( 'tag[%s]' );
		parent::setup ();
	}
}
?>