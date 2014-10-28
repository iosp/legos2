<?php

/**
 * TaxibotMission form base class.
 *
 * @method TaxibotMission getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotMissionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'mission_id'                 => new sfWidgetFormInputText(),
      'mission_type'               => new sfWidgetFormInputText(),
      'aircraft_tail_number'       => new sfWidgetFormInputText(),
      'aircraft_type'              => new sfWidgetFormInputText(),
      'start_time'                 => new sfWidgetFormDateTime(),
      'end_time'                   => new sfWidgetFormDateTime(),
      'flight_number'              => new sfWidgetFormInputText(),
      'aircraft_weight'            => new sfWidgetFormInputText(),
      'aircraft_cg'                => new sfWidgetFormInputText(),
      'tractor_id'                 => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => false, 'key_method' => 'getTractorId')),
      'driver_name'                => new sfWidgetFormInputText(),
      'cellulr_ip'                 => new sfWidgetFormInputText(),
      'pcm_start'                  => new sfWidgetFormDateTime(),
      'pcm_end'                    => new sfWidgetFormDateTime(),
      'dcm_start'                  => new sfWidgetFormDateTime(),
      'dcm_end'                    => new sfWidgetFormDateTime(),
      'pushback_start'             => new sfWidgetFormDateTime(),
      'pushback_end'               => new sfWidgetFormDateTime(),
      'left_engine_fuel_dcm'       => new sfWidgetFormInputText(),
      'right_engine_fuel_dcm'      => new sfWidgetFormInputText(),
      'left_engine_fuel_pcm'       => new sfWidgetFormInputText(),
      'right_engine_fuel_pcm'      => new sfWidgetFormInputText(),
      'left_engine_fuel_pushback'  => new sfWidgetFormInputText(),
      'right_engine_fuel_pushback' => new sfWidgetFormInputText(),
      'left_engine_fuel_maint'     => new sfWidgetFormInputText(),
      'right_engine_fuel_maint'    => new sfWidgetFormInputText(),
      'left_engine_hours_pcm'      => new sfWidgetFormInputText(),
      'right_engine_hours_pcm'     => new sfWidgetFormInputText(),
      'left_engine_hours_dcm'      => new sfWidgetFormInputText(),
      'right_engine_hours_dcm'     => new sfWidgetFormInputText(),
      'left_engine_hours_maint'    => new sfWidgetFormInputText(),
      'right_engine_hours_maint'   => new sfWidgetFormInputText(),
      'blf_name'                   => new sfWidgetFormInputText(),
      'join_after_mission_id'      => new sfWidgetFormInputText(),
      'operational_scenario'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'mission_id'                 => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'mission_type'               => new sfValidatorString(array('max_length' => 255)),
      'aircraft_tail_number'       => new sfValidatorString(array('max_length' => 255)),
      'aircraft_type'              => new sfValidatorString(array('max_length' => 255)),
      'start_time'                 => new sfValidatorDateTime(),
      'end_time'                   => new sfValidatorDateTime(),
      'flight_number'              => new sfValidatorString(array('max_length' => 255)),
      'aircraft_weight'            => new sfValidatorNumber(),
      'aircraft_cg'                => new sfValidatorNumber(),
      'tractor_id'                 => new sfValidatorPropelChoice(array('model' => 'TaxibotTractor', 'column' => 'tractor_id')),
      'driver_name'                => new sfValidatorString(array('max_length' => 255)),
      'cellulr_ip'                 => new sfValidatorString(array('max_length' => 255)),
      'pcm_start'                  => new sfValidatorDateTime(),
      'pcm_end'                    => new sfValidatorDateTime(),
      'dcm_start'                  => new sfValidatorDateTime(),
      'dcm_end'                    => new sfValidatorDateTime(),
      'pushback_start'             => new sfValidatorDateTime(),
      'pushback_end'               => new sfValidatorDateTime(),
      'left_engine_fuel_dcm'       => new sfValidatorNumber(),
      'right_engine_fuel_dcm'      => new sfValidatorNumber(),
      'left_engine_fuel_pcm'       => new sfValidatorNumber(),
      'right_engine_fuel_pcm'      => new sfValidatorNumber(),
      'left_engine_fuel_pushback'  => new sfValidatorNumber(),
      'right_engine_fuel_pushback' => new sfValidatorNumber(),
      'left_engine_fuel_maint'     => new sfValidatorNumber(),
      'right_engine_fuel_maint'    => new sfValidatorNumber(),
      'left_engine_hours_pcm'      => new sfValidatorNumber(),
      'right_engine_hours_pcm'     => new sfValidatorNumber(),
      'left_engine_hours_dcm'      => new sfValidatorNumber(),
      'right_engine_hours_dcm'     => new sfValidatorNumber(),
      'left_engine_hours_maint'    => new sfValidatorNumber(),
      'right_engine_hours_maint'   => new sfValidatorNumber(),
      'blf_name'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'join_after_mission_id'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'operational_scenario'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_mission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotMission';
  }


}
