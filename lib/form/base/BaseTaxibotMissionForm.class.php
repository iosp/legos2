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
      'id'                   => new sfWidgetFormInputHidden(),
      'mission_id'           => new sfWidgetFormInputText(),
      'mission_type'         => new sfWidgetFormInputText(),
      'aircraft_id'          => new sfWidgetFormPropelChoice(array('model' => 'Aircraft', 'add_empty' => false)),
      'start_time'           => new sfWidgetFormDateTime(),
      'end_time'             => new sfWidgetFormDateTime(),
      'flight_number'        => new sfWidgetFormInputText(),
      'aircraft_weight'      => new sfWidgetFormInputText(),
      'aircraft_cg'          => new sfWidgetFormInputText(),
      'tractor_id'           => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => false)),
      'driver_name'          => new sfWidgetFormInputText(),
      'cellulr_ip'           => new sfWidgetFormInputText(),
      'cul_de_sac_time'      => new sfWidgetFormTime(),
      'left_engine_fuel'     => new sfWidgetFormInputText(),
      'right_engine_fuel'    => new sfWidgetFormInputText(),
      'blf_name'             => new sfWidgetFormInputText(),
      'operational_scenario' => new sfWidgetFormInputText(),
      'is_commited'          => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'mission_id'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'mission_type'         => new sfValidatorString(array('max_length' => 255)),
      'aircraft_id'          => new sfValidatorPropelChoice(array('model' => 'Aircraft', 'column' => 'id')),
      'start_time'           => new sfValidatorDateTime(),
      'end_time'             => new sfValidatorDateTime(),
      'flight_number'        => new sfValidatorString(array('max_length' => 255)),
      'aircraft_weight'      => new sfValidatorNumber(),
      'aircraft_cg'          => new sfValidatorNumber(),
      'tractor_id'           => new sfValidatorPropelChoice(array('model' => 'TaxibotTractor', 'column' => 'id')),
      'driver_name'          => new sfValidatorString(array('max_length' => 255)),
      'cellulr_ip'           => new sfValidatorString(array('max_length' => 255)),
      'cul_de_sac_time'      => new sfValidatorTime(array('required' => false)),
      'left_engine_fuel'     => new sfValidatorNumber(array('required' => false)),
      'right_engine_fuel'    => new sfValidatorNumber(array('required' => false)),
      'blf_name'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'operational_scenario' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'is_commited'          => new sfValidatorBoolean(),
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
