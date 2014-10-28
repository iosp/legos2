<?php

/**
 * Aircrafts filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAircraftsFormFilter extends BaseFormFilterPropel {
	public function setup() {
		$this->setWidgets ( array (
				'tail_number' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'type' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'mtow' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'max_fatigue_limit_percent' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'min_fatigue_limit_percent' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'max_fatigue_limit_value' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'min_fatigue_limit_value' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ) 
		) );
		
		$this->setValidators ( array (
				'tail_number' => new sfValidatorPass ( array (
						'required' => false 
				) ),
				'type' => new sfValidatorPass ( array (
						'required' => false 
				) ),
				'mtow' => new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array (
						'required' => false 
				) ) ),
				'max_fatigue_limit_percent' => new sfValidatorSchemaFilter ( 'text', new sfValidatorInteger ( array (
						'required' => false 
				) ) ),
				'min_fatigue_limit_percent' => new sfValidatorSchemaFilter ( 'text', new sfValidatorInteger ( array (
						'required' => false 
				) ) ),
				'max_fatigue_limit_value' => new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array (
						'required' => false 
				) ) ),
				'min_fatigue_limit_value' => new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array (
						'required' => false 
				) ) ) 
		) );
		
		$this->widgetSchema->setNameFormat ( 'aircrafts_filters[%s]' );
		
		$this->errorSchema = new sfValidatorErrorSchema ( $this->validatorSchema );
		
		parent::setup ();
	}
	public function getModelName() {
		return 'Aircrafts';
	}
	public function getFields() {
		return array (
				'id' => 'Number',
				'tail_number' => 'Text',
				'type' => 'Text',
				'mtow' => 'Number',
				'max_fatigue_limit_percent' => 'Number',
				'min_fatigue_limit_percent' => 'Number',
				'max_fatigue_limit_value' => 'Number',
				'min_fatigue_limit_value' => 'Number' 
		);
	}
}
