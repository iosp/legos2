<?php

/**
 * TaxibotTable form base class.
 *
 * @method TaxibotTable getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'nlg_long_force'          => new sfWidgetFormInputText(),
      'exceeding_amount'        => new sfWidgetFormInputText(),
      'aircraft_number'         => new sfWidgetFormInputText(),
      'tractor_id'              => new sfWidgetFormInputText(),
      'flight_number'           => new sfWidgetFormInputText(),
      'aircraft_type'           => new sfWidgetFormInputText(),
      'time'                    => new sfWidgetFormDateTime(),
      'driver_name'             => new sfWidgetFormInputText(),
      'aircraft_weight'         => new sfWidgetFormInputText(),
      'aircraft_center_gravity' => new sfWidgetFormInputText(),
      'latitude'                => new sfWidgetFormInputText(),
      'longitude'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nlg_long_force'          => new sfValidatorNumber(array('required' => false)),
      'exceeding_amount'        => new sfValidatorNumber(array('required' => false)),
      'aircraft_number'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tractor_id'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flight_number'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'aircraft_type'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'time'                    => new sfValidatorDateTime(array('required' => false)),
      'driver_name'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'aircraft_weight'         => new sfValidatorNumber(array('required' => false)),
      'aircraft_center_gravity' => new sfValidatorNumber(array('required' => false)),
      'latitude'                => new sfValidatorNumber(array('required' => false)),
      'longitude'               => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotTable';
  }


}
