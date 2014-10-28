<?php

/**
 * Aircrafts form base class.
 *
 * @method Aircrafts getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAircraftsForm extends BaseFormPropel {
	public function setup() {
		$this->setWidgets ( array (
				'id' => new sfWidgetFormInputHidden (),
				'tail_number' => new sfWidgetFormInputText (),
				'type' => new sfWidgetFormInputText (),
				'mtow' => new sfWidgetFormInputText (),
				'max_fatigue_limit_percent' => new sfWidgetFormInputText (),
				'min_fatigue_limit_percent' => new sfWidgetFormInputText (),
				'max_fatigue_limit_value' => new sfWidgetFormInputText (),
				'min_fatigue_limit_value' => new sfWidgetFormInputText () 
		) );
		
		$this->setValidators ( array (
				'id' => new sfValidatorChoice ( array (
						'choices' => array (
								$this->getObject ()->getId () 
						),
						'empty_value' => $this->getObject ()->getId (),
						'required' => false 
				) ),
				'tail_number' => new sfValidatorString ( array (
						'max_length' => 255 
				) ),
				'type' => new sfValidatorString ( array (
						'max_length' => 255 
				) ),
				'mtow' => new sfValidatorNumber (),
				'max_fatigue_limit_percent' => new sfValidatorInteger ( array (
						'min' => - 2147483648,
						'max' => 2147483647 
				) ),
				'min_fatigue_limit_percent' => new sfValidatorInteger ( array (
						'min' => - 2147483648,
						'max' => 2147483647 
				) ),
				'max_fatigue_limit_value' => new sfValidatorNumber (),
				'min_fatigue_limit_value' => new sfValidatorNumber () 
		) );
		
		$this->widgetSchema->setNameFormat ( 'aircrafts[%s]' );
		
		$this->errorSchema = new sfValidatorErrorSchema ( $this->validatorSchema );
		
		parent::setup ();
	}
	public function getModelName() {
		return 'Aircrafts';
	}
}
