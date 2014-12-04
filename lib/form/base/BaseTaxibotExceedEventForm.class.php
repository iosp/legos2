<?php

/**
 * TaxibotExceedEvent form base class.
 *
 * @method TaxibotExceedEvent getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotExceedEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'exceed_type'      => new sfWidgetFormInputText(),
      'start_time'       => new sfWidgetFormDateTime(),
      'end_time'         => new sfWidgetFormDateTime(),
      'start_milisecond' => new sfWidgetFormInputText(),
      'end_milisecond'   => new sfWidgetFormInputText(),
      'duration'         => new sfWidgetFormTime(),
      'mission_id'       => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false)),
      'latitude'         => new sfWidgetFormInputText(),
      'longitude'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'exceed_type'      => new sfValidatorString(array('max_length' => 255)),
      'start_time'       => new sfValidatorDateTime(),
      'end_time'         => new sfValidatorDateTime(),
      'start_milisecond' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'end_milisecond'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'duration'         => new sfValidatorTime(array('required' => false)),
      'mission_id'       => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'id')),
      'latitude'         => new sfValidatorString(array('max_length' => 20)),
      'longitude'        => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('taxibot_exceed_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotExceedEvent';
  }


}
