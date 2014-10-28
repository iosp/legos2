<?php

/**
 * ExceedEvent form base class.
 *
 * @method ExceedEvent getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseExceedEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'start_time' => new sfWidgetFormDateTime(),
      'end_time'   => new sfWidgetFormDateTime(),
      'duration'   => new sfWidgetFormDateTime(),
      'mission_id' => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false, 'key_method' => 'getMissionId')),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'start_time' => new sfValidatorDateTime(),
      'end_time'   => new sfValidatorDateTime(),
      'duration'   => new sfValidatorDateTime(),
      'mission_id' => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'mission_id')),
    ));

    $this->widgetSchema->setNameFormat('exceed_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExceedEvent';
  }


}
