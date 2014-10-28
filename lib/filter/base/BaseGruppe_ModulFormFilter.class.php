<?php

/**
 * Gruppe_Modul filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseGruppe_ModulFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('gruppe_modul_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gruppe_Modul';
  }

  public function getFields()
  {
    return array(
      'gruppe_id' => 'ForeignKey',
      'modul_id'  => 'ForeignKey',
    );
  }
}
