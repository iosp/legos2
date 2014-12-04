<?php

/**
 * TaxibotMission filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotMissionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mission_id'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mission_type'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_id'          => new sfWidgetFormPropelChoice(array('model' => 'Aircraft', 'add_empty' => true)),
      'start_time'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_time'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'flight_number'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_weight'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_cg'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tractor_id'           => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true)),
      'driver_name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cellulr_ip'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cul_de_sac_time'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'left_engine_fuel'     => new sfWidgetFormFilterInput(),
      'right_engine_fuel'    => new sfWidgetFormFilterInput(),
      'blf_name'             => new sfWidgetFormFilterInput(),
      'operational_scenario' => new sfWidgetFormFilterInput(),
      'is_commited'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'mission_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mission_type'         => new sfValidatorPass(array('required' => false)),
      'aircraft_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Aircraft', 'column' => 'id')),
      'start_time'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'end_time'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'flight_number'        => new sfValidatorPass(array('required' => false)),
      'aircraft_weight'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aircraft_cg'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tractor_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotTractor', 'column' => 'id')),
      'driver_name'          => new sfValidatorPass(array('required' => false)),
      'cellulr_ip'           => new sfValidatorPass(array('required' => false)),
      'cul_de_sac_time'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'left_engine_fuel'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_fuel'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'blf_name'             => new sfValidatorPass(array('required' => false)),
      'operational_scenario' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_commited'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('taxibot_mission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotMission';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'mission_id'           => 'Number',
      'mission_type'         => 'Text',
      'aircraft_id'          => 'ForeignKey',
      'start_time'           => 'Date',
      'end_time'             => 'Date',
      'flight_number'        => 'Text',
      'aircraft_weight'      => 'Number',
      'aircraft_cg'          => 'Number',
      'tractor_id'           => 'ForeignKey',
      'driver_name'          => 'Text',
      'cellulr_ip'           => 'Text',
      'cul_de_sac_time'      => 'Date',
      'left_engine_fuel'     => 'Number',
      'right_engine_fuel'    => 'Number',
      'blf_name'             => 'Text',
      'operational_scenario' => 'Number',
      'is_commited'          => 'Boolean',
    );
  }
}
