<?php

/**
 * Benutzer_Modul form base class.
 *
 * @method Benutzer_Modul getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseBenutzer_ModulForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'modul_id'    => new sfWidgetFormInputHidden(),
      'benutzer_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'modul_id'    => new sfValidatorPropelChoice(array('model' => 'Modul', 'column' => 'id', 'required' => false)),
      'benutzer_id' => new sfValidatorPropelChoice(array('model' => 'Benutzer', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('benutzer_modul[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Benutzer_Modul';
  }


}
