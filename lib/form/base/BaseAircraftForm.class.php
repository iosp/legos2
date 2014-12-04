<?php

/**
 * Aircraft form base class.
 *
 * @method Aircraft getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAircraftForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'tail_number' => new sfWidgetFormInputText(),
      'type_id'     => new sfWidgetFormPropelChoice(array('model' => 'AircraftType', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tail_number' => new sfValidatorString(array('max_length' => 255)),
      'type_id'     => new sfValidatorPropelChoice(array('model' => 'AircraftType', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('aircraft[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Aircraft';
  }


}
