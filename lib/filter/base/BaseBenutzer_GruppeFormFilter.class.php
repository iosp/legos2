<?php

/**
 * Benutzer_Gruppe filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseBenutzer_GruppeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('benutzer_gruppe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Benutzer_Gruppe';
  }

  public function getFields()
  {
    return array(
      'gruppe_id'   => 'ForeignKey',
      'benutzer_id' => 'ForeignKey',
    );
  }
}
