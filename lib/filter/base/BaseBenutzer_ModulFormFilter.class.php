<?php

/**
 * Benutzer_Modul filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseBenutzer_ModulFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('benutzer_modul_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Benutzer_Modul';
  }

  public function getFields()
  {
    return array(
      'modul_id'    => 'ForeignKey',
      'benutzer_id' => 'ForeignKey',
    );
  }
}
