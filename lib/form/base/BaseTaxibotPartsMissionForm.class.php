<?php

/**
 * TaxibotPartsMission form base class.
 *
 * @method TaxibotPartsMission getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotPartsMissionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'mission_id'         => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false)),
      'start'              => new sfWidgetFormDateTime(),
      'end'                => new sfWidgetFormDateTime(),
      'left_engine_fuel'   => new sfWidgetFormInputText(),
      'right_engine_fuel'  => new sfWidgetFormInputText(),
      'left_engine_hours'  => new sfWidgetFormInputText(),
      'right_engine_hours' => new sfWidgetFormInputText(),
      'type'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'mission_id'         => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'id')),
      'start'              => new sfValidatorDateTime(),
      'end'                => new sfValidatorDateTime(),
      'left_engine_fuel'   => new sfValidatorNumber(),
      'right_engine_fuel'  => new sfValidatorNumber(),
      'left_engine_hours'  => new sfValidatorNumber(),
      'right_engine_hours' => new sfValidatorNumber(),
      'type'               => new sfValidatorString(array('max_length' => 25)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_parts_mission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotPartsMission';
  }


}
