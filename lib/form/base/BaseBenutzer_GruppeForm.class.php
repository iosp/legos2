<?php

/**
 * Benutzer_Gruppe form base class.
 *
 * @method Benutzer_Gruppe getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseBenutzer_GruppeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'gruppe_id'   => new sfWidgetFormInputHidden(),
      'benutzer_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'gruppe_id'   => new sfValidatorPropelChoice(array('model' => 'Gruppe', 'column' => 'id', 'required' => false)),
      'benutzer_id' => new sfValidatorPropelChoice(array('model' => 'Benutzer', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('benutzer_gruppe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Benutzer_Gruppe';
  }


}
