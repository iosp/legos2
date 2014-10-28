<?php

/**
 * TaxibotTable filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotTableFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nlg_long_force'          => new sfWidgetFormFilterInput(),
      'exceeding_amount'        => new sfWidgetFormFilterInput(),
      'aircraft_number'         => new sfWidgetFormFilterInput(),
      'tractor_id'              => new sfWidgetFormFilterInput(),
      'flight_number'           => new sfWidgetFormFilterInput(),
      'aircraft_type'           => new sfWidgetFormFilterInput(),
      'time'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'driver_name'             => new sfWidgetFormFilterInput(),
      'aircraft_weight'         => new sfWidgetFormFilterInput(),
      'aircraft_center_gravity' => new sfWidgetFormFilterInput(),
      'latitude'                => new sfWidgetFormFilterInput(),
      'longitude'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nlg_long_force'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'exceeding_amount'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aircraft_number'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tractor_id'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flight_number'           => new sfValidatorPass(array('required' => false)),
      'aircraft_type'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'time'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'driver_name'             => new sfValidatorPass(array('required' => false)),
      'aircraft_weight'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aircraft_center_gravity' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'latitude'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'longitude'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('taxibot_table_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotTable';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'nlg_long_force'          => 'Number',
      'exceeding_amount'        => 'Number',
      'aircraft_number'         => 'Number',
      'tractor_id'              => 'Number',
      'flight_number'           => 'Text',
      'aircraft_type'           => 'Number',
      'time'                    => 'Date',
      'driver_name'             => 'Text',
      'aircraft_weight'         => 'Number',
      'aircraft_center_gravity' => 'Number',
      'latitude'                => 'Number',
      'longitude'               => 'Number',
    );
  }
}
