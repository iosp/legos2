<?php

/**
 * Aircraft filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAircraftFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tail_number' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'        => new sfWidgetFormPropelChoice(array('model' => 'AircraftType', 'add_empty' => true, 'key_method' => 'getName')),
    ));

    $this->setValidators(array(
      'tail_number' => new sfValidatorPass(array('required' => false)),
      'type'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AircraftType', 'column' => 'name')),
    ));

    $this->widgetSchema->setNameFormat('aircraft_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Aircraft';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'tail_number' => 'Text',
      'type'        => 'ForeignKey',
    );
  }
}
