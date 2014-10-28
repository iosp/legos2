<?php

/**
 * TaxibotCancel form base class.
 *
 * @method TaxibotCancel getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotCancelForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'alert' => new sfWidgetFormInputText(),
      'time'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'alert' => new sfValidatorString(array('max_length' => 255)),
      'time'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('taxibot_cancel[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotCancel';
  }


}
