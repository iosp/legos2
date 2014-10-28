<?php

/**
 * AircraftType form base class.
 *
 * @method AircraftType getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAircraftTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'name'                     => new sfWidgetFormInputText(),
      'hlc_id'                   => new sfWidgetFormInputText(),
      'long_fatigue_limit_value' => new sfWidgetFormInputText(),
      'long_static_limit_value'  => new sfWidgetFormInputText(),
      'lat_static_limit_value'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                     => new sfValidatorString(array('max_length' => 255)),
      'hlc_id'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'long_fatigue_limit_value' => new sfValidatorNumber(),
      'long_static_limit_value'  => new sfValidatorNumber(),
      'lat_static_limit_value'   => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('aircraft_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AircraftType';
  }


}
