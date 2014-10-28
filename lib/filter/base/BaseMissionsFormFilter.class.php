<?php

/**
 * Missions filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMissionsFormFilter extends BaseFormFilterPropel {
	public function setup() {
		$this->setWidgets ( array (
				'mission_type' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'aircraft_tail_number' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'start_time' => new sfWidgetFormFilterDate ( array (
						'from_date' => new sfWidgetFormDate (),
						'to_date' => new sfWidgetFormDate (),
						'with_empty' => false 
				) ),
				'end_time' => new sfWidgetFormFilterDate ( array (
						'from_date' => new sfWidgetFormDate (),
						'to_date' => new sfWidgetFormDate (),
						'with_empty' => false 
				) ),
				'flight_number' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'aircraft_weight' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'aircraft_cg' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'driver_name' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ),
				'tractor_id' => new sfWidgetFormPropelChoice ( array (
						'model' => 'TaxibotTractor',
						'add_empty' => true 
				) ),
				'cellulr_ip' => new sfWidgetFormFilterInput ( array (
						'with_empty' => false 
				) ) 
		) );
		
		$this->setValidators ( array (
				'mission_type' => new sfValidatorPass ( array (
						'required' => false 
				) ),
				'aircraft_tail_number' => new sfValidatorPass ( array (
						'required' => false 
				) ),
				'start_time' => new sfValidatorDateRange ( array (
						'required' => false,
						'from_date' => new sfValidatorDate ( array (
								'required' => false 
						) ),
						'to_date' => new sfValidatorDate ( array (
								'required' => false 
						) ) 
				) ),
				'end_time' => new sfValidatorDateRange ( array (
						'required' => false,
						'from_date' => new sfValidatorDate ( array (
								'required' => false 
						) ),
						'to_date' => new sfValidatorDate ( array (
								'required' => false 
						) ) 
				) ),
				'flight_number' => new sfValidatorPass ( array (
						'required' => false 
				) ),
				'aircraft_weight' => new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array (
						'required' => false 
				) ) ),
				'aircraft_cg' => new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array (
						'required' => false 
				) ) ),
				'driver_name' => new sfValidatorPass ( array (
						'required' => false 
				) ),
				'tractor_id' => new sfValidatorPropelChoice ( array (
						'required' => false,
						'model' => 'TaxibotTractor',
						'column' => 'id' 
				) ),
				'cellulr_ip' => new sfValidatorPass ( array (
						'required' => false 
				) ) 
		) );
		
		$this->widgetSchema->setNameFormat ( 'missions_filters[%s]' );
		
		$this->errorSchema = new sfValidatorErrorSchema ( $this->validatorSchema );
		
		parent::setup ();
	}
	public function getModelName() {
		return 'Missions';
	}
	public function getFields() {
		return array (
				'id' => 'Number',
				'mission_type' => 'Text',
				'aircraft_tail_number' => 'Text',
				'start_time' => 'Date',
				'end_time' => 'Date',
				'flight_number' => 'Text',
				'aircraft_weight' => 'Number',
				'aircraft_cg' => 'Number',
				'driver_name' => 'Text',
				'tractor_id' => 'ForeignKey',
				'cellulr_ip' => 'Text' 
		);
	}
}
