<?php

/**
 * Missions form base class.
 *
 * @method Missions getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissionsForm extends BaseFormPropel {
	public function setup() {
		$this->setWidgets ( array (
				'id' => new sfWidgetFormInputHidden (),
				'mission_type' => new sfWidgetFormInputText (),
				'aircraft_tail_number' => new sfWidgetFormInputText (),
				'start_time' => new sfWidgetFormDateTime (),
				'end_time' => new sfWidgetFormDateTime (),
				'flight_number' => new sfWidgetFormInputText (),
				'aircraft_weight' => new sfWidgetFormInputText (),
				'aircraft_cg' => new sfWidgetFormInputText (),
				'driver_name' => new sfWidgetFormInputText (),
				'tractor_id' => new sfWidgetFormPropelChoice ( array (
						'model' => 'TaxibotTractor',
						'add_empty' => true 
				) ),
				'cellulr_ip' => new sfWidgetFormInputText () 
		) );
		
		$this->setValidators ( array (
				'id' => new sfValidatorChoice ( array (
						'choices' => array (
								$this->getObject ()->getId () 
						),
						'empty_value' => $this->getObject ()->getId (),
						'required' => false 
				) ),
				'mission_type' => new sfValidatorString ( array (
						'max_length' => 255 
				) ),
				'aircraft_tail_number' => new sfValidatorString ( array (
						'max_length' => 255 
				) ),
				'start_time' => new sfValidatorDateTime (),
				'end_time' => new sfValidatorDateTime (),
				'flight_number' => new sfValidatorString ( array (
						'max_length' => 255 
				) ),
				'aircraft_weight' => new sfValidatorNumber (),
				'aircraft_cg' => new sfValidatorNumber (),
				'driver_name' => new sfValidatorString ( array (
						'max_length' => 255 
				) ),
				'tractor_id' => new sfValidatorPropelChoice ( array (
						'model' => 'TaxibotTractor',
						'column' => 'id',
						'required' => false 
				) ),
				'cellulr_ip' => new sfValidatorString ( array (
						'max_length' => 255 
				) ) 
		) );
		
		$this->widgetSchema->setNameFormat ( 'missions[%s]' );
		
		$this->errorSchema = new sfValidatorErrorSchema ( $this->validatorSchema );
		
		parent::setup ();
	}
	public function getModelName() {
		return 'Missions';
	}
}
