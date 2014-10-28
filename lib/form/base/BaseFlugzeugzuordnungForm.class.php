<?php

/**
 * Flugzeugzuordnung form base class.
 *
 * @method Flugzeugzuordnung getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFlugzeugzuordnungForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'flugzeugregistrierung' => new sfWidgetFormInputText(),
      'airline_id'            => new sfWidgetFormInputText(),
      'flugzeugtyp_id'        => new sfWidgetFormInputText(),
      'von'                   => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'flugzeugregistrierung' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'airline_id'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flugzeugtyp_id'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'von'                   => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('flugzeugzuordnung[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Flugzeugzuordnung';
  }


}
