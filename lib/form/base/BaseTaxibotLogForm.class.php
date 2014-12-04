<?php

/**
 * TaxibotLog form base class.
 *
 * @method TaxibotLog getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'log_id'        => new sfWidgetFormInputHidden(),
      'log_file'      => new sfWidgetFormInputText(),
      'tractor_id'    => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true)),
      'load'          => new sfWidgetFormInputText(),
      'date'          => new sfWidgetFormDateTime(),
      'load_validity' => new sfWidgetFormInputCheckbox(),
      'load_exceeded' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'log_id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getLogId()), 'empty_value' => $this->getObject()->getLogId(), 'required' => false)),
      'log_file'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tractor_id'    => new sfValidatorPropelChoice(array('model' => 'TaxibotTractor', 'column' => 'id', 'required' => false)),
      'load'          => new sfValidatorNumber(array('required' => false)),
      'date'          => new sfValidatorDateTime(array('required' => false)),
      'load_validity' => new sfValidatorBoolean(array('required' => false)),
      'load_exceeded' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotLog';
  }


}
