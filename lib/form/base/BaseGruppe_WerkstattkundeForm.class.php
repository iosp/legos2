<?php

/**
 * Gruppe_Werkstattkunde form base class.
 *
 * @method Gruppe_Werkstattkunde getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseGruppe_WerkstattkundeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'gruppe_id'         => new sfWidgetFormInputHidden(),
      'werkstattkunde_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'gruppe_id'         => new sfValidatorPropelChoice(array('model' => 'Gruppe', 'column' => 'id', 'required' => false)),
      'werkstattkunde_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getWerkstattkundeId()), 'empty_value' => $this->getObject()->getWerkstattkundeId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gruppe_werkstattkunde[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gruppe_Werkstattkunde';
  }


}
