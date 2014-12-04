<?php

/**
 * TaxibotFatigueHistory form base class.
 *
 * @method TaxibotFatigueHistory getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotFatigueHistoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'aircraft_id'   => new sfWidgetFormPropelChoice(array('model' => 'Aircraft', 'add_empty' => false)),
      'date'          => new sfWidgetFormDateTime(),
      'milisecond'    => new sfWidgetFormInputText(),
      'long_force_kn' => new sfWidgetFormInputText(),
      'lat_force_kn'  => new sfWidgetFormInputText(),
      'veolcity'      => new sfWidgetFormInputText(),
      'tiller'        => new sfWidgetFormInputText(),
      'break_event'   => new sfWidgetFormInputCheckbox(),
      'mission_id'    => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'aircraft_id'   => new sfValidatorPropelChoice(array('model' => 'Aircraft', 'column' => 'id')),
      'date'          => new sfValidatorDateTime(),
      'milisecond'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'long_force_kn' => new sfValidatorNumber(),
      'lat_force_kn'  => new sfValidatorNumber(),
      'veolcity'      => new sfValidatorNumber(),
      'tiller'        => new sfValidatorNumber(),
      'break_event'   => new sfValidatorBoolean(),
      'mission_id'    => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('taxibot_fatigue_history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotFatigueHistory';
  }


}
