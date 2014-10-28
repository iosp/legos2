<?php

/**
 * TaxibotTrail form base class.
 *
 * @method TaxibotTrail getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotTrailForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'latitude'   => new sfWidgetFormInputText(),
      'longitude'  => new sfWidgetFormInputText(),
      'time'       => new sfWidgetFormDateTime(),
      'mission_id' => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'latitude'   => new sfValidatorString(array('max_length' => 20)),
      'longitude'  => new sfValidatorString(array('max_length' => 20)),
      'time'       => new sfValidatorDateTime(),
      'mission_id' => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('taxibot_trail[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotTrail';
  }


}
