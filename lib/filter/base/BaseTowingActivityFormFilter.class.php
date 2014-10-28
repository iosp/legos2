<?php

/**
 * TowingActivity filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTowingActivityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'order_id'           => new sfWidgetFormFilterInput(),
      'timestamp'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tractor_id'         => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true, 'key_method' => 'getTractorId')),
      'driver_id'          => new sfWidgetFormFilterInput(),
      'engine_temperature' => new sfWidgetFormFilterInput(),
      'tire_pressure'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'order_id'           => new sfValidatorPass(array('required' => false)),
      'timestamp'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tractor_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotTractor', 'column' => 'tractor_id')),
      'driver_id'          => new sfValidatorPass(array('required' => false)),
      'engine_temperature' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tire_pressure'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('towing_activity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TowingActivity';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'order_id'           => 'Text',
      'timestamp'          => 'Date',
      'tractor_id'         => 'ForeignKey',
      'driver_id'          => 'Text',
      'engine_temperature' => 'Number',
      'tire_pressure'      => 'Number',
    );
  }
}
