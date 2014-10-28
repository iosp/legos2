<?php

/**
 * TaxibotActivity filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTaxibotActivityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'csv_file_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tractor_id'      => new sfWidgetFormPropelChoice(array('model' => 'TaxibotTractor', 'add_empty' => true, 'key_method' => 'getTractorId')),
      'trip'            => new sfWidgetFormFilterInput(),
      'ac_registration' => new sfWidgetFormFilterInput(),
      'position_from'   => new sfWidgetFormFilterInput(),
      'position_to'     => new sfWidgetFormFilterInput(),
      'departure'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'ready'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'completed'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'checked'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'csv_file_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tractor_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TaxibotTractor', 'column' => 'tractor_id')),
      'trip'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ac_registration' => new sfValidatorPass(array('required' => false)),
      'position_from'   => new sfValidatorPass(array('required' => false)),
      'position_to'     => new sfValidatorPass(array('required' => false)),
      'departure'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ready'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'completed'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'checked'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('taxibot_activity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotActivity';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'csv_file_date'   => 'Date',
      'tractor_id'      => 'ForeignKey',
      'trip'            => 'Number',
      'ac_registration' => 'Text',
      'position_from'   => 'Text',
      'position_to'     => 'Text',
      'departure'       => 'Date',
      'ready'           => 'Date',
      'completed'       => 'Date',
      'checked'         => 'Boolean',
    );
  }
}
