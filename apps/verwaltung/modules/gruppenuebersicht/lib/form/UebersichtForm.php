
<?php
class UebersichtForm extends BaseForm {
	public function setup() {
		$this->setWidgets ( array (
				'group' => new sfWidgetFormChoice ( array (
						'choices' => $this->getDefault ( 'group' ),
						'multiple' => false,
						'expanded' => false 
				) ),
				'user' => new sfWidgetFormChoice ( array (
						'choices' => $this->getDefault ( 'user' ),
						'multiple' => false,
						'expanded' => false 
				) ) 
		) );
		
		$this->getWidget ( 'group' )->setAttribute ( 'onChange', 'selectChange("user")' );
		$this->getWidget ( 'user' )->setAttribute ( 'onChange', 'selectChange("group")' );
		
		$this->setValidators ( array (
				'group' => new sfValidatorString ( array (
						'required' => false 
				) ),
				'user' => new sfValidatorString ( array (
						'required' => false 
				) ) 
		) );
		
		$this->setDefaults ( array (
				'group' => 0,
				'user' => 0 
		) );
		
		$this->widgetSchema->setLabels ( array (
				'group' => 'Gruppe:',
				'user' => 'Benutzer:' 
		) );
		
		$this->widgetSchema->setNameFormat ( 'uebersicht[%s]' );
		parent::setup ();
	}
}
?>