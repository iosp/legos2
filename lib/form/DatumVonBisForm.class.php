<?php
class DatumVonBisForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'datum_von' => new sfWidgetFormInput ( array (), array (
						'size' => 12 
				) ),
				'datum_bis' => new sfWidgetFormInput ( array (), array (
						'size' => 12 
				) ) 
		) );
		
		$this->widgetSchema->setNameFormat ( 'zeitraum[%s]' );
		
		$this->widgetSchema->setLabels ( array (
				'datum_von' => 'Von:',
				'datum_bis' => 'Bis:' 
		) );
		
		$this->setValidators ( array (
				'datum_von' => new sfValidatorDate ( array (
						'with_time' => false,
						'date_format' => '/((?:0(?!0)|1|2|3)(?<!3)[0-9]|3[0-1])\.((?:0(?!0)|1)(?<!1)[0-9]|1[0-2])\.((?:[0-9]{4})|(?:[0-9]{2}))/',
						'date_output' => 'd.m.Y',
						'required' => true 
				), array (
						'invalid' => 'Bitte ein Korrektes Datum angeben.',
						'required' => 'Bitte ein korrektes Datum angeben.',
						'bad_format' => 'Datum in folgendem Format angeben: TT.MM.JJJJ' 
				) ),
				'datum_bis' => new sfValidatorDate ( array (
						'with_time' => false,
						'date_format' => '/((?:0(?!0)|1|2|3)(?<!3)[0-9]|3[0-1])\.((?:0(?!0)|1)(?<!1)[0-9]|1[0-2])\.((?:[0-9]{4})|(?:[0-9]{2}))/',
						'required' => false 
				), array (
						'invalid' => 'Bitte ein Korrektes Datum angeben.',
						'bad_format' => 'Datum in folgendem Format angeben: TT.MM.JJJJ' 
				) ) 
		) );
		
		$this->setDefaults ( array (
				'datum_von' => date ( 'd.m.Y', strtotime ( 'yesterday' ) )  // gestern als Standard
				) );
		
		parent::setup ();
	}
}

?>
