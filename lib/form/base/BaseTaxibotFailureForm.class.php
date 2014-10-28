<?php

/**
 * TaxibotFailure form base class.
 *
 * @method TaxibotFailure getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotFailureForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'name'              => new sfWidgetFormInputText(),
      'dates'             => new sfWidgetFormInputText(),
      'taxibot_number'    => new sfWidgetFormInputText(),
      'failure_family'    => new sfWidgetFormInputText(),
      'mode_of_operation' => new sfWidgetFormInputText(),
      'mission'           => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 255)),
      'dates'             => new sfValidatorString(array('max_length' => 255)),
      'taxibot_number'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'failure_family'    => new sfValidatorString(array('max_length' => 255)),
      'mode_of_operation' => new sfValidatorString(array('max_length' => 255)),
      'mission'           => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('taxibot_failure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotFailure';
  }


}
