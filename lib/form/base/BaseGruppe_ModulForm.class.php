<?php

/**
 * Gruppe_Modul form base class.
 *
 * @method Gruppe_Modul getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseGruppe_ModulForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'gruppe_id' => new sfWidgetFormInputHidden(),
      'modul_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'gruppe_id' => new sfValidatorPropelChoice(array('model' => 'Gruppe', 'column' => 'id', 'required' => false)),
      'modul_id'  => new sfValidatorPropelChoice(array('model' => 'Modul', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gruppe_modul[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gruppe_Modul';
  }


}
