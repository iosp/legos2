<?php

/**
 * Hilfe form base class.
 *
 * @method Hilfe getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHilfeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'seite'  => new sfWidgetFormInputText(),
      'titel'  => new sfWidgetFormInputText(),
      'inhalt' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'seite'  => new sfValidatorString(array('max_length' => 255)),
      'titel'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'inhalt' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hilfe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Hilfe';
  }


}
