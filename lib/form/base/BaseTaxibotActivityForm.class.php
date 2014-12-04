<?php

/**
 * TaxibotActivity form base class.
 *
 * @method TaxibotActivity getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotActivityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'csv_file_date'   => new sfWidgetFormDate(),
      'tractor_id'      => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true)),
      'trip'            => new sfWidgetFormInputText(),
      'ac_registration' => new sfWidgetFormInputText(),
      'position_from'   => new sfWidgetFormInputText(),
      'position_to'     => new sfWidgetFormInputText(),
      'departure'       => new sfWidgetFormDateTime(),
      'ready'           => new sfWidgetFormDateTime(),
      'completed'       => new sfWidgetFormDateTime(),
      'checked'         => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'csv_file_date'   => new sfValidatorDate(array('required' => false)),
      'tractor_id'      => new sfValidatorPropelChoice(array('model' => 'TaxibotTractor', 'column' => 'id', 'required' => false)),
      'trip'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'ac_registration' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'position_from'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'position_to'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'departure'       => new sfValidatorDateTime(array('required' => false)),
      'ready'           => new sfValidatorDateTime(array('required' => false)),
      'completed'       => new sfValidatorDateTime(array('required' => false)),
      'checked'         => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('taxibot_activity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotActivity';
  }


}
