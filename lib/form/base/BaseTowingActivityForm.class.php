<?php

/**
 * TowingActivity form base class.
 *
 * @method TowingActivity getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTowingActivityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'order_id'           => new sfWidgetFormInputText(),
      'timestamp'          => new sfWidgetFormDateTime(),
      'tractor_id'         => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true, 'key_method' => 'getTractorId')),
      'driver_id'          => new sfWidgetFormInputText(),
      'engine_temperature' => new sfWidgetFormInputText(),
      'tire_pressure'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'order_id'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'timestamp'          => new sfValidatorDateTime(array('required' => false)),
      'tractor_id'         => new sfValidatorPropelChoice(array('model' => 'TaxibotTractor', 'column' => 'tractor_id', 'required' => false)),
      'driver_id'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'engine_temperature' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tire_pressure'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('towing_activity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TowingActivity';
  }


}
