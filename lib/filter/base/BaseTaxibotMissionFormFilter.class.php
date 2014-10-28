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
      'mission_id'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mission_type'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_tail_number'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_type'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'start_time'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_time'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'flight_number'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_weight'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aircraft_cg'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tractor_id'                 => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true, 'key_method' => 'getTractorId')),
      'driver_name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cellulr_ip'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pcm_start'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pcm_end'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'dcm_start'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'dcm_end'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pushback_start'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pushback_end'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'left_engine_fuel_dcm'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_fuel_dcm'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_fuel_pcm'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_fuel_pcm'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_fuel_pushback'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_fuel_pushback' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_fuel_maint'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_fuel_maint'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_hours_pcm'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_hours_pcm'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_hours_dcm'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_hours_dcm'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'left_engine_hours_maint'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'right_engine_hours_maint'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'blf_name'                   => new sfWidgetFormFilterInput(),
      'join_after_mission_id'      => new sfWidgetFormFilterInput(),
      'operational_scenario'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mission_id'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mission_type'               => new sfValidatorPass(array('required' => false)),
      'aircraft_tail_number'       => new sfValidatorPass(array('required' => false)),
      'aircraft_type'              => new sfValidatorPass(array('required' => false)),
      'start_time'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'end_time'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'flight_number'              => new sfValidatorPass(array('required' => false)),
      'aircraft_weight'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aircraft_cg'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tractor_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotTractor', 'column' => 'tractor_id')),
      'driver_name'                => new sfValidatorPass(array('required' => false)),
      'cellulr_ip'                 => new sfValidatorPass(array('required' => false)),
      'pcm_start'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pcm_end'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dcm_start'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dcm_end'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pushback_start'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pushback_end'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'left_engine_fuel_dcm'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_fuel_dcm'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_fuel_pcm'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_fuel_pcm'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_fuel_pushback'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_fuel_pushback' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_fuel_maint'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_fuel_maint'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_hours_pcm'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_hours_pcm'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_hours_dcm'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_hours_dcm'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'left_engine_hours_maint'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'right_engine_hours_maint'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'blf_name'                   => new sfValidatorPass(array('required' => false)),
      'join_after_mission_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'operational_scenario'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'                         => 'Number',
      'mission_id'                 => 'Number',
      'mission_type'               => 'Text',
      'aircraft_tail_number'       => 'Text',
      'aircraft_type'              => 'Text',
      'start_time'                 => 'Date',
      'end_time'                   => 'Date',
      'flight_number'              => 'Text',
      'aircraft_weight'            => 'Number',
      'aircraft_cg'                => 'Number',
      'tractor_id'                 => 'ForeignKey',
      'driver_name'                => 'Text',
      'cellulr_ip'                 => 'Text',
      'pcm_start'                  => 'Date',
      'pcm_end'                    => 'Date',
      'dcm_start'                  => 'Date',
      'dcm_end'                    => 'Date',
      'pushback_start'             => 'Date',
      'pushback_end'               => 'Date',
      'left_engine_fuel_dcm'       => 'Number',
      'right_engine_fuel_dcm'      => 'Number',
      'left_engine_fuel_pcm'       => 'Number',
      'right_engine_fuel_pcm'      => 'Number',
      'left_engine_fuel_pushback'  => 'Number',
      'right_engine_fuel_pushback' => 'Number',
      'left_engine_fuel_maint'     => 'Number',
      'right_engine_fuel_maint'    => 'Number',
      'left_engine_hours_pcm'      => 'Number',
      'right_engine_hours_pcm'     => 'Number',
      'left_engine_hours_dcm'      => 'Number',
      'right_engine_hours_dcm'     => 'Number',
      'left_engine_hours_maint'    => 'Number',
      'right_engine_hours_maint'   => 'Number',
      'blf_name'                   => 'Text',
      'join_after_mission_id'      => 'Number',
      'operational_scenario'       => 'Number',
    );
  }
}
