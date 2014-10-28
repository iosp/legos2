<?php

/**
 * AircraftType filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAircraftTypeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hlc_id'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'long_fatigue_limit_value' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'long_static_limit_value'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lat_static_limit_value'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'                     => new sfValidatorPass(array('required' => false)),
      'hlc_id'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'long_fatigue_limit_value' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'long_static_limit_value'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'lat_static_limit_value'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('aircraft_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AircraftType';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'name'                     => 'Text',
      'hlc_id'                   => 'Number',
      'long_fatigue_limit_value' => 'Number',
      'long_static_limit_value'  => 'Number',
      'lat_static_limit_value'   => 'Number',
    );
  }
}
