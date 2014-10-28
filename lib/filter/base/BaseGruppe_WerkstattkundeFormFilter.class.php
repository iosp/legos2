<?php

/**
 * Gruppe_Werkstattkunde filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseGruppe_WerkstattkundeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('gruppe_werkstattkunde_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gruppe_Werkstattkunde';
  }

  public function getFields()
  {
    return array(
      'gruppe_id'         => 'ForeignKey',
      'werkstattkunde_id' => 'Number',
    );
  }
}
